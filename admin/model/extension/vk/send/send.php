<?php

require_once __DIR__ . '/../send.php';

class ModelExtensionVkSendSend extends ModelExtensionVkSend
{
    /**
     * @var array
     */
    private $settings;

    /**
     * ModelExtensionVkSendSend constructor.
     *
     * @param $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->model('setting/setting');
        $this->load->model('extension/vk/tables');

        $this->settings = $this->getSettings();
    }

    /**
     * Update order in vk
     */
    public function updateOrders()
    {
        if (file_exists(DIR_SYSTEM . '/vk_cron/last_run.log')) {
            $last_run = file_get_contents(DIR_SYSTEM . '/vk_cron/last_run.log');
        } else {
            $last_run = date('Y-m-d 00:00:00');
        }

        file_put_contents(DIR_SYSTEM . '/vk_cron/last_run.log', date('Y-m-d H:i:s'));

        $orders = $this->getOrders(['filter_date_modified' => $last_run]);

        if (!empty($orders)) {
            foreach ($orders as $order) {
                $flag = false;

                $order_vk = $this->model_extension_vk_tables->orders()->get($order['order_id']);

                $histories = $this->getOrderHistories($order['order_id']);

                if (!empty($histories) && !empty(end($histories))) {
                    $endComment = end($histories);
                    $flag = true;
                }

                if ($order['order_status_id'] != $order_vk[DB_PREFIX . 'status'] && in_array($order['order_status_id'], $this->settings['vk_settings_status'])) {
                    $vk_status = array_search($order['order_status_id'], $this->settings['vk_settings_status']);

                    $this->orderStatusEdit(
                        array(
                            'vk_id' => $order_vk['vk_id'],
                            'vk_status' => $vk_status,
                            DB_PREFIX . 'status' => $order['order_status_id']
                        )
                    );

                    $flag = true;
                }

                if ($flag === true) {
                    $this->orderEditFromVk(
                        array(
                            'user_id' => (int)$order_vk['vk_user_id'],
                            'order_id' => (int)$order_vk['vk_id'],
                            'status' => isset($vk_status) ? $vk_status : $order_vk['vk_status'],
                            'merchant_comment' => isset($endComment) ? $endComment : ''
                        )
                    );
                }
            }
        }
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

        foreach ($allSettingsSettings as $key => $value) {

            if ($key == 'vk_settings_status' || $key == 'vk_settings_delivery') {
                $setting_data[$key] = $value;
            }
        }

        $allSettingsOath = $this->model_setting_setting->getSetting('vk_oath');

        foreach ($allSettingsOath as $key1 => $value1) {

            if ($key1 == 'vk_oath_id_group' || $key1 == 'vk_oath_access_token') {
                $setting_data[$key1] = $value1;
            }
        }

        return $setting_data;
    }
}
