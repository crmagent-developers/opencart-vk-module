<?php

class ModelExtensionVkSend extends Model
{
    /**
     * @var object
     */
    protected $vkApiClient;

    /**
     * ModelExtensionVkSend constructor.
     *
     * @param $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->library('vk/vk');

        $this->vkApiClient = $this->vk->getApiClient();
    }

    /**
     * Edit order status in opencart base
     *
     * @param array $data
     */
    public function orderStatusEdit($data)
    {
        $this->model_extension_vk_tables->orders()->editStatuses($data['vk_id'], $data['vk_status'], $data['oc_status']);
    }

    /**
     * Edit order in vk
     *
     * @param $params
     */
    public function orderEditFromVk($params)
    {
        $this->vkApiClient->market()->editOrder($params);
    }

    /**
     * Get order history from opencart
     *
     * @param int $order_id
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    public function getOrderHistories($order_id, $start = 0, $limit = 100)
    {
        $data = array();

        $query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

        foreach ($query->rows as $row) {
//            if (!empty($row['comment'])) {
                $data[] = array(
                    'comment' => nl2br($row['comment']),
                );
//            }
        }

        return $data;
    }
}