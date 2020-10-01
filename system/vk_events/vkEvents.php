<?php

if (!isset($_REQUEST)) {
    return;
}

$_SERVER['HTTPS'] = 'off';
$_SERVER['SERVER_PORT'] = 80;

require_once(realpath(dirname(__FILE__)) . '/../../admin/config.php');
require_once(DIR_SYSTEM . 'startup.php');

$config = new Config();
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$data = json_decode(file_get_contents('php://input'), true);

switch ($data['type']) {
    case 'confirmation':
        $query = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE code = 'vk_event_code'");
        $db->query("DELETE FROM " . DB_PREFIX . "setting WHERE code = 'vk_event_code'");

        echo $query->row['value'];
        break;

    case 'market_order_new':
        $query = $db->query("SELECT * FROM " . DB_PREFIX . "vk_orders WHERE vk_id = '" . (int)$data['object']['id'] . "'");

        if (!$query->row) {
            $db->query(
                "INSERT INTO " . DB_PREFIX . "vk_orders SET 
                vk_id = '" . (int)$data['object']['id'] . "', 
                vk_status = '" . (int)$data['object']['status'] . "', 
                vk_user_id = '" . (int)$data['object']['user_id'] . "', 
                json_last_event = '" . $db->escape(json_encode($data, true)) . "'");

            $cli_action = 'extension/module/vk/createOrder';
            require_once('dispatch.php');
        }

        echo('ok');

        break;

    case 'market_order_edit':
        $query = $db->query("SELECT * FROM " . DB_PREFIX . "vk_orders WHERE vk_id = '" . (int)$data['object']['id'] . "'");

            if ($query->row) {
                $db->query("UPDATE " . DB_PREFIX . "vk_orders SET json_last_event = '" . $db->escape(json_encode($data, true)) . "' WHERE vk_id = '" . (int)$data['object']['id'] . "'");
                $db->query("INSERT INTO " . DB_PREFIX . "vk_events SET order_vk_id = '" . (int)$data['object']['id'] . "'");

                $cli_action = 'extension/module/vk/editOrder';
                require_once('dispatch.php');
            }

            echo('ok');

            break;

    default:

        echo('ok');

        break;
}