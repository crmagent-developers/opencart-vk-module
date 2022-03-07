<?php

class ModelExtensionVkReferences extends Model
{
    const DELIVERY_TYPES_VK = array(
        0 => 'Самовывоз',
        1 => 'Доставка в пункт выдачи Boxberry',
        2 => 'Доставка в пункт выдачи СДЭК',
        3 => 'В ближайшее почтовое отделение'
    );

    const STATUSES_VK = array(
        0 => 'Новый',
        1 => 'Согласуется',
        2 => 'Собирается',
        3 => 'Доставляется',
        4 => 'Выполнен',
        5 => 'Отменен',
        6 => 'Возвращен'
    );

    const PAYMENT_TYPES = array();

    const LENGTH_FACTOR = array(
        'mm' => 1,
        'cm' => 10,
        'm' => 1000
    );

    const WEIGHT_FACTOR = array(
        'g' => 1,
        'kg' => 1000
    );

    /**
     * @var object
     */
    protected $vkApiClient;

    /**
     * @var object
     */
    private $opencartApiClient;

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->library('vk/vk');

        $this->vkApiClient = $this->vk->getApiClient();
    }

    /**
     * Getting a list all categories
     *
     * @return array
     */
    public function getCategories()
    {
        return array(
            'opencart' => $this->getOpercartCategories(),
            'vk' => $this->getVkCategories()
        );
    }

    /**
     * Getting a list of non-empty categories from opencart
     *
     * @return array
     */
    private function getOpercartCategories()
    {
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $categories = $this->model_catalog_category->getCategories(['sort' => 'name']);

        foreach ($categories as $key => &$category) {
            $productsFromCategory = $this->model_catalog_product->getProductsByCategoryId($category['category_id']);

            if (!empty($productsFromCategory)) {
                $category['count'] = count($productsFromCategory);
            } else {
                unset($categories[$key]);
            }
        }

        unset($category);

        return $categories;
    }

    /**
     * Getting a list categories from Vk
     *
     * @return array
     */
    private function getVkCategories()
    {
        $categories = $this->vkApiClient->market()->getCategories(['count' => 1000]);

        return $this->parseCategoriesVk($categories);
    }

    /**
     * Parse response getCategories from Vk
     *
     * @param $categories
     *
     * @return array
     */
    private function parseCategoriesVk($categories)
    {
        $array = [];

        foreach ($categories['items'] as $item) {
            $array[$item['section']['id']]['name'] = $item['section']['name'];
            $array[$item['section']['id']]['id'] = $item['section']['id'];

            $array[$item['section']['id']]['categories'][] = [
                'id' => $item['id'],
                'name' => $item['name']
            ];
        }

        return $array;
    }

    /**
     * Get all shares from opencart
     *
     * @return array
     */
    public function getShares()
    {
        $shares = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special");

        foreach ($query->rows as $row) {
            if (!key_exists($row['product_id'], $shares)) {
                $shares[$row['product_id']] = ['priority' => $row['priority'], 'price' => $row['price']];
            } else {
                if ($shares[$row['product_id']]['priority'] > $row['priority']) {
                    $shares[$row['product_id']] = ['priority' => $row['priority'], 'price' => $row['price']];
                } elseif ($shares[$row['product_id']]['priority'] == $row['priority'] &&
                    $shares[$row['product_id']]['price'] > $row['price']) {
                    $shares[$row['product_id']] = ['priority' => $row['priority'], 'price' => $row['price']];
                }
            }
        }

        return $shares;
    }

    /**
     * Get permalinks from opencart
     *
     * @return array
     */
    public function getPermalinks()
    {
        $links = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias");

        foreach ($query->rows as $row) {

            if (strripos($row['query'], 'category') !== false) {
                $category_id = str_replace('category_id=', '', $row['query']);
                $links['categories'][$category_id] = $row['keyword'];
            } elseif (strripos($row['query'], 'product') !== false) {
                $product_id = str_replace('product_id=', '', $row['query']);
                $links['products'][$product_id] = $row['keyword'];
            }
        }

        return $links;
    }

    /**
     * Get all statuses
     *
     * @return array
     */
    public function getOrderStatuses()
    {
        return array(
            'opencart' => $this->getOpercartOrderStatuses(),
            'vk' => $this->getVkOrderStatuses()
        );
    }

    /**
     * Array order statuses from vk
     *
     * @return array
     */
    private function getVkOrderStatuses()
    {
        return self::STATUSES_VK;
    }

    /**
     * Get order statuses from opencart
     *
     * @return array
     */
    private function getOpercartOrderStatuses()
    {
        $this->load->model('localisation/order_status');

        return $this->model_localisation_order_status->getOrderStatuses(array());
    }


    /**
     * Get all delivery types
     *
     * @return array
     */
    public function getDeliveryTypes()
    {
        $this->load->model('setting/store');

        return array(
            'opencart' => $this->getOpercartDeliveryTypes(),
            'vk' => $this->getVkDeliveryTypes()
        );
    }

    /**
     * Get delivery methods from opencart
     *
     * @return array
     */
    public function getOpercartDeliveryTypes()
    {
        //метод из билиотеки vk - инициализируем кастомный api клиент для opencart
        $this->opencartApiClient = $this->vk->getOcApiClient($this->registry);

        return $this->opencartApiClient->getDeliveryTypes();
    }

    /**
     * Get delivery types from vk
     *
     * @return array
     */
    public function getVkDeliveryTypes()
    {
        return self::DELIVERY_TYPES_VK;
    }

    /**
     * Get category id by name from opencart
     *
     * @param string $name
     *
     * @return bool|int
     */
    public function getCategoryIdByName($name)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE name = '" . $name . "'");

        foreach ($query->row as $key => $value) {
            if ($key == 'category_id') {

                return $value;
            }
        }

        return false;
    }

    /**
     * Get all payment types
     *
     * @return array
     */
    public function getPaymentTypes()
    {
        return array(
            'opencart' => $this->getOpercartPaymentTypes(),
            'vk' => $this->getVkPaymentTypes()
        );
    }

    /**
     * Get delivery types from vk
     *
     * @return array
     */
    public function getVkPaymentTypes()
    {
        return self::PAYMENT_TYPES;
    }

    /**
     * Get payment types from opencart
     *
     * @return array
     */
    public function getOpercartPaymentTypes()
    {
        $paymentTypes = array();
        $files = glob(DIR_APPLICATION . 'controller/extension/payment/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');

                $this->load->language('extension/payment/' . $extension);

                $configStatus = $extension . '_status';

                if ($this->config->get($configStatus)) {
                    $paymentTypes[$extension] = strip_tags(
                        $this->language->get('heading_title')
                    );
                }
            }
        }

        return $paymentTypes;
    }

    /**
     * Get all length classes
     *
     * @return array
     */
    public function getLengthClasses()
    {
        return array(
            'opencart' => $this->getOpercartLengthClasses(),
            'vk' => $this->getVkLengthFactor()
        );
    }

    /**
     * Get length factor from vk
     *
     * @return int[]
     */
    public function getVkLengthFactor()
    {
        return self::LENGTH_FACTOR;
    }

    /**
     * Get length classes from opencart
     *
     * @return array
     */
    public function getOpercartLengthClasses()
    {
        $this->load->model('localisation/length_class');

        return $this->model_localisation_length_class->getLengthClasses();
    }

    /**
     * Get all weight classes
     *
     * @return array
     */
    public function getWeightClasses()
    {
        return array(
            'opencart' => $this->getOpercartWeightClasses(),
            'vk' => $this->getVkWeightFactor()
        );
    }

    /**
     * Get weight factor from vk
     *
     * @return int[]
     */
    public function getVkWeightFactor()
    {
        return self::WEIGHT_FACTOR;
    }

    /**
     * Get weight classes from opencart
     *
     * @return array
     */
    public function getOpercartWeightClasses()
    {
        $this->load->model('localisation/weight_class');

        return $this->model_localisation_weight_class->getWeightClasses();
    }
}