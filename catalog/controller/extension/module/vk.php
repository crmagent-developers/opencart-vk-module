<?php


class ControllerExtensionModuleVk extends Controller {

    /**
     * ControllerExtensionModuleVk constructor.
     *
     * @param $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
    }

    /**
     * Update order in vk
     *
     * @param string $trigger
     * @param array $parameter
     *
     * @return void
     */
    public function editOrder($trigger, $parameter = null)
    {
        if (isset($parameter)) {
            if (file_exists(DIR_APPLICATION . 'model/extension/vk/custom/send.php')) {
                $this->load->model('extension/vk/custom/send');
                $this->model_extension_vk_custom_send->updateOrder($parameter);
            } else {
                $this->load->model('extension/vk/send/send');
                $this->model_extension_vk_send_send->updateOrder($parameter);
            }
        }
    }
}
