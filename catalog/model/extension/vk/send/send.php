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
     *
     * @param array $parameter
     */
    public function updateOrder($parameter)
    {
        $flag = false;

        $oc_order_id = $parameter[0];
        $oc_order_status = $parameter[1];

        $order_vk = $this->model_extension_vk_tables->orders()->get($oc_order_id);

        $histories = $this->getOrderHistories($oc_order_id);
        
        if (!empty($histories) && !empty(end($histories))) {
            $endComment = end($histories);
            $flag = true;
        }

        if ($oc_order_status != $order_vk[DB_PREFIX . 'status'] && in_array($oc_order_status, $this->settings['vk_settings_status'])) {
            $vk_status = array_search($oc_order_status, $this->settings['vk_settings_status']);

            $this->orderStatusEdit(
                array(
                    'vk_id' => $order_vk['vk_id'],
                    'vk_status' => $vk_status,
                    DB_PREFIX . 'status' => $oc_order_status
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
