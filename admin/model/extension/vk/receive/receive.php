<?php

require_once __DIR__ . '/../receive.php';

class ModelExtensionVkReceiveReceive extends ModelExtensionVkReceive
{
    /**
     * @var object
     */
    protected $vkApiClient;

    /**
     * @var object
     */
    protected $opencartApiClient;

    /**
     * @var array
     */
    protected $settings;

    /**
     * ModelExtensionVkReceiveReceive constructor.
     *
     * @param $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->library('vk/vk');
        $this->load->language('extension/module/vk');
        $this->load->model('setting/setting');

        $this->opencartApiClient = $this->vk->getOcApiClient($this->registry);
        $this->vkApiClient = $this->vk->getApiClient();
        $this->settings = $this->getSettings();
    }

    /**
     * Update order in opencart from vk
     *
     * @param int $vk_id
     */
    public function updateOrder($vk_id)
    {
        $this->load->model('sale/order');

        $vk_order = $this->model_extension_vk_tables->orders()->get($vk_id, 'vk_id');
        $oc_order = $this->model_sale_order->getOrder($vk_order[DB_PREFIX . 'id']);
        $lastEvent = json_decode($vk_order['json_last_event'], true);

        $flag = false;

        if ($vk_order['vk_status'] != $lastEvent['object']['status'] && isset($this->settings['vk_settings_status'][$lastEvent['object']['status']])) {
            $oc_order['order_status_id'] = $this->settings['vk_settings_status'][$lastEvent['object']['status']];

            $this->opencartApiClient->addHistory($vk_order[DB_PREFIX . 'id'], $oc_order['order_status_id']);

            $this->model_extension_vk_tables->orders()->editStatuses(
                $vk_id,
                $lastEvent['object']['status'],
                $this->settings['vk_settings_status'][$lastEvent['object']['status']]
            );

            $flag = true;
        }

        if (isset($lastEvent['object']['delivery']['track_number'])
            && isset($lastEvent['object']['delivery']['track_link'])
            && strripos($oc_order['comment'], $lastEvent['object']['delivery']['track_number']) === false
            && strripos($oc_order['comment'], $lastEvent['object']['delivery']['track_link']) === false
        ) {
            $oc_order['comment'] =
                'Трек номер - ' . $lastEvent['object']['delivery']['track_number'] . PHP_EOL .
                'Ссылка для отслеживания - ' . $lastEvent['object']['delivery']['track_link'] . PHP_EOL .
                $oc_order['comment'];

            $flag = true;
        }

        if ($flag == true) {
            $this->editOrder($vk_order[DB_PREFIX . 'id'], $oc_order);
        }
    }

    /**
     * Create order in opencart from vk
     *
     * @param array $orderFromVk
     *
     * @return array
     */
    public function createOrder($orderFromVk)
    {
        $this->load->model('customer/customer');
        $this->load->model('catalog/product');
        $this->load->model('extension/vk/references');

        $ocDelivery = $this->model_extension_vk_references->getOpercartDeliveryTypes();
        $ocPayments = $this->model_extension_vk_references->getOpercartPaymentTypes();

        $address = $this->getAddress($orderFromVk['object']['delivery']);
        $customer = $this->getDataCustomer($orderFromVk, $address);
        $checkCustomer = $this->model_extension_vk_tables->customers()->get($orderFromVk['object']['user_id'], 'vk_id');

        if (empty($checkCustomer)) {
            $customer_id = $this->model_customer_customer->addCustomer($customer);

            $this->model_extension_vk_tables->customers()->set(array(
                DB_PREFIX . 'id' => $customer_id,
                'vk_id' => $orderFromVk['object']['user_id']
            ));
        } else {
            $customer_id = $checkCustomer[DB_PREFIX . 'id'];
        }

        if (!empty($address['region'])) {
            $responceRegion = $this->getZoneByName($address['region']);

            if ($responceRegion) {
                $region['name'] = $responceRegion['name'];
                $region['id'] = $responceRegion['zone_id'];
            } else {
                $region['name'] = $address['region'];
                $region['id'] = 0;
            }
        } else {
            $region['name'] = '';
            $region['id'] = 0;
        }

        $responseCountry = $this->getCountryByName($address['country']);

        if (empty($responseCountry) && $address['country'] == 'Россия') {
            $responseCountry = $this->getCountryByName('Российская Федерация');
        }

        if ($responseCountry) {
            $country['name'] = $responseCountry['name'];
            $country['id'] = $responseCountry['country_id'];
        } else {
            $country['name'] = $address['country'];
            $country['id'] = 0;
        }

        $delivery = $this->getDelivery(
            $this->model_extension_vk_references->getVkDeliveryTypes(),
            $orderFromVk['object']['delivery']['type']
        );

        $comment = 'Ссылка на страницу покупателя в вконтакте - https://vk.com/id' . $orderFromVk['object']['user_id'] . PHP_EOL .
            'Номер заказа в вконтакте - №' . $orderFromVk['object']['display_order_id'] . PHP_EOL;

        if (!empty($orderFromVk['object']['comment'])) {
            $comment .= PHP_EOL . 'Комментарий покупателя к заказу - ' . $orderFromVk['object']['comment'];
        }

        $data = array();

        $data['invoice_prefix']     = 'VK-' . $orderFromVk['object']['id'];
        $data['telephone']          = $customer['telephone'];
        $data['currency_code']      = $this->config->get('config_currency');
        $data['currency_value']     = $this->getCurrencyByCode($data['currency_code'], 'value');
        $data['currency_id']        = $this->getCurrencyByCode($data['currency_code'], 'currency_id');
        $data['language_id']        = $this->getLanguageByCode($this->config->get('config_language'), 'language_id');
        $data['store_id']           = 0;
        $data['store_url']          = 'https://vk.com/public' . $orderFromVk['group_id'];
        $data['store_name']         = 'Магазин Вконтакте';
        $data['customer']           = $customer['firstname'];
        $data['customer_id']        = $customer_id;
        $data['customer_group_id']  = 1;
        $data['firstname']          = $customer['firstname'];
        $data['lastname']           = $customer['lastname'];
        $data['email']              = $customer['email'];
        $data['comment']            = $comment;
        $data['fax']                = '';

        $data['payment_address']    = '0';
        $data['payment_firstname']  = $customer['firstname'];
        $data['payment_lastname']   = $customer['lastname'];
        $data['payment_address_1']  = $address['address'];
        $data['payment_address_2']  = '';
        $data['payment_company']    = '';
        $data['payment_company_id'] = '';
        $data['payment_city']       = $address['city'];
        $data['payment_postcode']   = $address['postcode'];
        $data['payment_country_id'] = $country['id'];
        $data['payment_country']    = $country['name'];
        $data['payment_zone_id']    = $region['id'];
        $data['payment_zone']       = $region['name'];
        $data['payment']            = $this->settings['vk_settings_payment_default'];
        $data['payment_code']       = $this->settings['vk_settings_payment_default'];
        $data['payment_method']     = $ocPayments[$this->settings['vk_settings_payment_default']];

        $data['shipping_country_id']    = $country['id'];
        $data['shipping_country']       = $country['name'];
        $data['shipping_zone_id']       = $region['id'];
        $data['shipping_zone']          = $region['name'];
        $data['shipping_address']       = '0';
        $data['shipping_firstname']     = $customer['firstname'];
        $data['shipping_lastname']      = $customer['lastname'];
        $data['shipping_address_1']     = $address['address'];
        $data['shipping_address_2']     = '';
        $data['shipping_company']       = '';
        $data['shipping_company_id']    = '';
        $data['shipping_city']          = $address['city'];
        $data['shipping_postcode']      = $address['postcode'];
        $data['shipping']               = $delivery;
        $data['shipping_code']          = $delivery;

        $shipping = explode('.', $data['shipping']);
        $shippingModule = $shipping[0];

        if (isset($ocDelivery[$shippingModule][$data['shipping']]['title'])) {
            $data['shipping_method'] = $ocDelivery[$shippingModule][$data['shipping']]['title'];
        } else {
            $data['shipping_method'] = $ocDelivery[$shippingModule]['title'];
        }

        // this data will not retrive from vk for now
        $data['tax'] = '';
        $data['tax_id'] = '';
        $data['product'] = '';
        $data['product_id'] = '';
        $data['reward'] = '';
        $data['affiliate'] = '';
        $data['affiliate_id'] = 0;
        $data['payment_tax_id'] = '';
        $data['order_product_id'] = '';
        $data['payment_company'] = '';
        $data['payment_company_id'] = '';
        $data['company'] = '';
        $data['company_id'] = '';
        $data['custom_field'] = array();

        $data['order_product'] = array();

        if (count($orderFromVk['object']['preview_order_items']) < 5) {
            $items = $orderFromVk['object']['preview_order_items'];
        } else {
            $responseGetItemsOrder = $this->vkApiClient->market()->getOrderItems(
                array(
                    'user_id' => $orderFromVk['object']['user_id'],
                    'order_id' => $orderFromVk['object']['id'],
                    'count' => 50
                    // 'offset' =>
                )
            );

            $items = isset($responseGetItemsOrder['items'])
                ? $responseGetItemsOrder['items']
                : $orderFromVk['object']['preview_order_items'];
        }

        foreach ($items as $item) {
            $productId = $this->model_extension_vk_tables->products()->get($item['item_id'], 'vk_id', DB_PREFIX . 'id')[DB_PREFIX . 'id'];

            $options = array();

            $offerId = $this->vk->getOfferId($item['item']['description']);

            if($offerId != 0) {
                $optionsFromVk = explode('_', $offerId);

                foreach ($optionsFromVk as $optionFromVk) {
                    $optionData = explode('-', $optionFromVk);
                    $productOptionId = $optionData[0];
                    $optionValueId = $optionData[1];

                    $productOptions = $this->model_catalog_product->getProductOptions($productId);

                    foreach($productOptions as $productOption) {
                        if($productOptionId == $productOption['product_option_id']) {
                            foreach($productOption['product_option_value'] as $productOptionValue) {
                                if($productOptionValue['option_value_id'] == $optionValueId) {
                                    $options[] = array(
                                        'product_option_id' => $productOptionId,
                                        'product_option_value_id' => $productOptionValue['product_option_value_id'],
                                        'value' => $this->getOptionValue($productOptionValue['option_value_id'], 'name'),
                                        'type' => $productOption['type'],
                                        'name' => $productOption['name'],
                                    );
                                }
                            }
                        }
                    }
                }
            }

            $product = $this->model_catalog_product->getProduct($productId);
            $rewards = $this->model_catalog_product->getProductRewards($productId);

            $data['order_product'][] = array(
                'name' => $product['name'],
                'model' => $product['model'],
                'price' => $item['price']['amount']/100,
                'total' => (float)(($item['price']['amount']/100) * $item['quantity']),
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'option' => $options,
                'reward' => $rewards[$data['customer_group_id']]['points'] * $item['quantity']
            );
        }

        $sub_total_price = 0;
        $shipping_price = 0;
        $total_price = 0;

        foreach ($orderFromVk['object']['price_details'] as $price_detail) {
            switch ($price_detail['title']) {
                case 'Стоимость товаров':
                    $sub_total_price = $price_detail['price']['amount']/100;

                    break;
                case 'Стоимость доставки':
                    $shipping_price = $price_detail['price']['amount']/100;

                    break;
                case 'Итого':
                    $total_price = $price_detail['price']['amount']/100;

                    break;
            }
        }
        
        $data['total'] = $total_price;

        $data['order_total'] = array(
            array(
                'order_total_id' => '',
                'code' => 'sub_total',
                'title' => $this->language->get('product_summ'),
                'value' => $sub_total_price,
                'text' => $sub_total_price,
                'sort_order' => $this->model_setting_setting->getSetting('sub_total')['sub_total_sort_order']
            ),
            array(
                'order_total_id' => '',
                'code' => 'shipping',
                'title' => $data['shipping_method'],
                'value' => $shipping_price,
                'text' => $shipping_price,
                'sort_order' => $this->model_setting_setting->getSetting('shipping')['shipping_sort_order']
            ),
            array(
                'order_total_id' => '',
                'code' => 'total',
                'title' => $this->language->get('column_total'),
                'value' => $data['total'],
                'text' => $data['total'],
                'sort_order' => $this->model_setting_setting->getSetting('total')['total_sort_order']
            )
        );

        $data['fromApi'] = true;
        $data['order_status_id'] = $this->settings['vk_settings_status'][$orderFromVk['object']['status']];

        $order_id = $this->addOrder($data);

        return array(
            DB_PREFIX . 'id' => $order_id,
            'vk_id' => $orderFromVk['object']['id'],
            DB_PREFIX . 'status' => $data['order_status_id'],
        );
    }

    /**
     * Get data customer
     *
     * @param array $orderFromVk
     * @param array $address
     *
     * @return array
     */
    private function getDataCustomer($orderFromVk, $address)
    {
        $fullName = explode(' ', ($orderFromVk['object']['recipient']['name']));

        switch (count($fullName)) {
            case 1:
                $firstname = $fullName[0];

                break;
            case 2:
                $firstname = $fullName[1];
                $lastname = $fullName[0];

                break;
            case 3:
                $firstname = $fullName[1] . ' ' . $fullName[2];
                $lastname = $fullName[0];

                break;
            default: $firstname = $orderFromVk['object']['recipient']['name'];
        }

        $customer = array(
            'store_id' => 0,
            'customer_group_id' => '1',
            'firstname' => $firstname,
            'lastname' => isset($lastname) ? $lastname : '',
            'email' => 'id' . $orderFromVk['object']['user_id'] . '@vk.com',
            'telephone' => !empty($orderFromVk['object']['recipient']['phone']) ? $orderFromVk['object']['recipient']['phone'] : 80000000000,
            'fax' => '',
            'newsletter' => 0,
            'password' => 'tmppass',
            'status' => 1,
            'approved' => 1,
            'safe' => 0,
            'affiliate' => '',
            'address' => array(
                array(
                    'firstname' => $fullName[0],
                    'lastname' => isset($fullName[1]) ? $fullName[1] : '',
                    'address_1' => !empty($address['address']) ? trim($address['address']) : ' ',
                    'address_2' => ' ',
                    'city' => !empty($address['city']) ? $address['city'] : ' ',
                    'postcode' => !empty($address['postcode']) ? $address['postcode'] : ' ',
                    'tax_id' => '1',
                    'company' => '',
                    'company_id' => '',
                    'zone_id' => 0,
                    'country_id' => 0,
                    'default' => '1'
                )
            ),
        );

        return $customer;
    }

    /**
     * Get delivery code from opencart
     *
     * @param array $vkDeliveryTypes
     * @param string $orderDeliverType
     *
     * @return string
     */
    private function getDelivery($vkDeliveryTypes, $orderDeliverType)
    {
        $key = array_search($orderDeliverType, $vkDeliveryTypes);

        if ($key !== false && $this->settings['vk_settings_delivery'][$key] != 'not_delivery') {

            return $this->settings['vk_settings_delivery'][$key];
        } else {

            return $this->settings['vk_settings_delivery_default'];
        }
    }

    /**
     * Get address
     *
     * @param array $delivery
     *
     * @return array
     */
    private function getAddress($delivery)
    {
        $data = array();

        switch ($delivery['type']) {
            case 'Самовывоз':

                break;
            case 'Доставка в пункт выдачи Boxberry':
                $county = $this->vkApiClient->database()->getCountriesById(['country_ids' => $delivery['delivery_point']['address']['country_id']]);
                $city = $this->vkApiClient->database()->getCitiesById(['city_ids' => $delivery['delivery_point']['address']['city_id']]);
                $address = explode(',', $delivery['delivery_point']['address']['address']);

                $data['country'] = $county[0]['title'];
                $data['city'] = $city[0]['title'];
                $data['region'] = isset($city[0]['region']) ? $city[0]['region'] : '';
                $data['postcode'] = ctype_digit(trim($address[0])) ? trim($address[0]) : '';
                $data['address'] = trim(implode(',', array_slice($address, 2)));

                break;
            case 'Доставка в пункт выдачи СДЭК':
                $county = $this->vkApiClient->database()->getCountriesById(['country_ids' => $delivery['delivery_point']['address']['country_id']]);
                $city = $this->vkApiClient->database()->getCitiesById(['city_ids' => $delivery['delivery_point']['address']['city_id']]);

                $data['country'] = $county[0]['title'];
                $data['city'] = $city[0]['title'];
                $data['region'] = isset($city[0]['region']) ? $city[0]['region'] : '';
                $data['postcode'] = '';
                $data['address'] = trim($delivery['delivery_point']['address']['address']);

                break;
            case 'В ближайшее почтовое отделение':
                $address = explode(',', $delivery['address']);

                if (ctype_digit(trim($address[0]))) {
                    $data['country'] = trim($address[1]);
                    $data['city'] = trim($address[2]);
                    $data['region'] = '';
                    $data['postcode'] = ctype_digit(trim($address[0])) ? trim($address[0]) : '';
                    $data['address'] = trim(implode(',', array_slice($address, 3)));
                } else {
                    $data['country'] = trim($address[0]);
                    $data['city'] = trim($address[1]);
                    $data['region'] = '';
                    $data['postcode'] = '';
                    $data['address'] = trim(implode(',', array_slice($address, 2)));
                }

                break;
        }

        return $data;
    }

    /**
     * Get settings
     *
     * @return array
     */
    private function getSettings()
    {
        $setting_data = array();

        $allSettingsSettings = $this->model_setting_setting->getSetting('vk_settings');

        $setting_data['vk_settings_status'] = $allSettingsSettings['vk_settings_status'];
        $setting_data['vk_settings_delivery'] = $allSettingsSettings['vk_settings_delivery'];
        $setting_data['vk_settings_delivery_default'] = $allSettingsSettings['vk_settings_delivery_default'];
        $setting_data['vk_settings_payment_default'] = $allSettingsSettings['vk_settings_payment_default'];

        $allSettingsOath = $this->model_setting_setting->getSetting('vk_oath');

        $setting_data['vk_oath_id_group'] = $allSettingsOath['vk_oath_id_group'];
        $setting_data['vk_oath_access_token'] = $allSettingsOath['vk_oath_access_token'];

        return $setting_data;
    }
}