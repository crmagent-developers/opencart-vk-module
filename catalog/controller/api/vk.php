<?php

class ControllerApiVk extends Controller
{
    /**
     * Get delivery types from opencart
     */
    public function getDeliveryTypes()
    {
        $api = $this->auth();

        if (isset($api['error'])) {
            $response = $api;
        } else {
            $this->load->model('localisation/country');
            $this->load->model('setting/setting');
            $this->load->library('vk/vk');
            $setting = $this->model_setting_setting->getSetting('vk');

            $response = array();

            if (isset($setting['vk_country']) && $setting['vk_country']) {
                foreach ($setting['vk_country'] as $country) {
                    $response = $this->mergeDeliveryTypes($country, $response);
                }
            }
        }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    /**
     * Add order history in opencart
     */
    public function addOrderHistory()
    {
        $api = $this->auth();

        if (isset($api['error'])) {
            $response = $api;
        } elseif (!isset($this->request->post['order_id']) || !isset($this->request->post['order_status_id'])) {
            $response = array('error' => 'Not found data');
        } else {
            $this->load->model('checkout/order');
            \vk\vk::$history_run = true;
            $this->model_checkout_order->addOrderHistory($this->request->post['order_id'], $this->request->post['order_status_id']);
            \vk\vk::$history_run = false;
            $response = array('success' => true);
        }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            $this->response->addHeader('Access-Control-Max-Age: 1000');
            $this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));
    }

    /**
     * Get delivary type by zone
     *
     * @param int $country_id
     *
     * @return array
     */
    protected function getDeliveryTypesByZones($country_id)
    {
        $this->loadModels();
        $this->load->model('localisation/zone');
        $this->load->model('localisation/country');

        $shippingModules = $this->{'model_' . $this->modelExtension}->getExtensions('shipping');
        $zones = $this->model_localisation_zone->getZonesByCountryId($country_id);
        $country = $this->model_localisation_country->getCountry($country_id);
        $quote_data = array();

        foreach ($zones as $zone) {
            $address = array(
                'country_id' => $country_id,
                'zone_id' => $zone['zone_id'],
                'iso_code_2' => $country['iso_code_2'],
                'iso_code_3' => $country['iso_code_3'],
                'zone_code' => $zone['code'],
                'postcode' => '',
                'city' => ''
            );

            foreach ($shippingModules as $shippingModule) {
                $this->load->model('extension/shipping/' . $shippingModule['code']);

                $shippingCode = $shippingModule['code'];

                if ($this->config->get($shippingCode . '_status')) {
                    if ($shippingCode == 'free') {
                        $free_total = $this->config->get('free_total');

                        if ($free_total > 0) {
                            $this->config->set('free_total', 0);
                        }
                    }

                    if ($this->{'model_extension_shipping_' . $shippingModule['code']}->getQuote($address)) {
                        $quote_data[] = $this->{'model_extension_shipping_' . $shippingModule['code']}->getQuote($address);
                    } else {
                        $this->load->language('extension/shipping/' . $shippingModule['code']);

                        $quote_data[] = array(
                            'code' => $shippingModule['code'],
                            'title' => $this->language->get('text_title'),
                            'quote' => array(
                                array(
                                    'code' => $shippingModule['code'],
                                    'title' => $this->language->get('text_title')
                                )
                            )
                        );
                    }
                }
            }
        }

        $deliveryTypes = array();

        foreach ($quote_data as $shipping) {
            foreach ($shipping['quote'] as $shippingMethod) {
                $deliveryTypes[$shipping['code']]['title'] = $shipping['title'];
                $deliveryTypes[$shipping['code']][$shippingMethod['code']] = $shippingMethod;
            }
        }

        return $deliveryTypes;
    }

    /**
     * Merge delivery types
     *
     * @param $country
     * @param $result
     *
     * @return mixed
     */
    private function mergeDeliveryTypes($country, $result) {
        $delivery_types = $this->getDeliveryTypesByZones($country);

        foreach ($delivery_types as $shipping_module => $shipping_type) {
            if (isset($result[$shipping_module])) {
                $result[$shipping_module] = array_merge($result[$shipping_module], $shipping_type);
            } else {
                $result[$shipping_module] = $shipping_type;
            }
        }

        return $result;
    }

    /**
     * Auth
     *
     * @return string[]
     */
    private function auth()
    {
        if (!isset($this->request->get['key'])
            || !$this->request->get['key']
        ) {
            return array('error' => 'Not found api key');
        }

        if (isset($this->request->get['key'])
            && !empty($this->request->get['key'])
        ) {
            $this->load->model('account/api');

            $api = $this->model_account_api->getApiByKey($this->request->get['key']);

            if (!empty($api)) {
                return $api;
            }
        }

        return array('error' => 'Invalid api key');
    }

    /**
     * Load models
     */
    private function loadModels()
    {
        $this->load->model('extension/extension');

        $this->modelExtension = 'extension_extension';
    }
}
