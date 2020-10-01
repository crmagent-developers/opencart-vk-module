<?php

if (is_file(__DIR__.'/config.php')) {
    require_once(__DIR__.'/config.php');
}

require_once DIR_SYSTEM . 'startup.php';
require_once DIR_CONFIG . 'admin.php';

require_once DIR_SYSTEM . 'library/vk/vk.php';

$db = new DB($_['db_type'], $_['db_hostname'], $_['db_username'], $_['db_password'], $_['db_database'], $_['db_port']);
$settings = $db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . 0 . "' AND `code` = '" . $db->escape('vk_oath') . "'");

foreach ($settings->rows as $row) {
     $setting_data[$row['key']] = $row['value'];
}

# 1 шаг авторизации
if (!$_GET) {
    $parameters = array(
        'client_id' => $setting_data['vk_oath_id_application'],
        'display' => 'page',
        'redirect_uri' => HTTPS_SERVER . 'admin/vk_oAth.php',
        'scope' => 'offline,market,photos,groups',
        'response_type' => 'code',
        'v' => '5.131'
    );

    if (isset($setting_data['vk_oath_access_token'])) {
        $parameters['group_ids'] = ltrim($setting_data['vk_oath_id_group'], '-');
        $parameters['scope'] = 'manage';
    }

    $url = 'https://oauth.vk.com/authorize';
    $url .= '?' . http_build_query($parameters, '', '&');

    header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, 302);
    exit();

# 2 шаг авторизации
} elseif (isset($_GET['code'])) {
    $parameters = array(
        'client_id' => $setting_data['vk_oath_id_application'],
        'client_secret' => $setting_data['vk_oath_secret_key'],
        'redirect_uri' => HTTPS_SERVER . 'admin/vk_oAth.php',
        'code' => $_GET['code']
    );

    $url = 'https://oauth.vk.com/access_token';
    $url .= '?' . http_build_query($parameters, '', '&');
    $response = file_get_contents($url);

    if (!isset($setting_data['vk_oath_access_token'])) {
        $accessToken = json_decode($response, true)['access_token'];

        $db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . 0 . "' AND `code` = '" . $db->escape('vk_oath') . "' AND `key` = '" . $db->escape('vk_oath_access_token') . "'");
        $db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . 0 . "' AND `code` = '" . $db->escape('vk_oath') . "' AND `key` = '" . $db->escape('vk_oath_access_token_info') . "'");
        $db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . 0 . "', `code` = '" . $db->escape('vk_oath') . "', `key` = '" . $db->escape('vk_oath_access_token') . "', `value` = '" . $db->escape($accessToken) . "'");
        $db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . 0 . "', `code` = '" . $db->escape('vk_oath') . "', `key` = '" . $db->escape('vk_oath_access_token_info') . "', `value` = '" . $db->escape($response) . "', serialized = '1'");

        header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), HTTPS_SERVER . 'admin/vk_oAth.php'), true, 302);
        exit();
    } else {
        $accessToken = json_decode($response, true)['access_token_' . ltrim($setting_data['vk_oath_id_group'], '-')];

        $db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . 0 . "' AND `code` = '" . $db->escape('vk_oath') . "' AND `key` = '" . $db->escape('vk_oath_access_token_group') . "'");
        $db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . 0 . "', `code` = '" . $db->escape('vk_oath') . "', `key` = '" . $db->escape('vk_oath_access_token_group') . "', `value` = '" . $db->escape($accessToken) . "'");
        $db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . 0 . "' AND `code` = '" . $db->escape('vk_oath') . "' AND `key` = '" . $db->escape('vk_oath_back_link') . "'");

        header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $setting_data['vk_oath_back_link']), true, 302);
        exit();
    }
}


