<?php


class Orders
{
    /**
     * @var object
     */
    private $db;

    /**
     * Orders constructor.
     *
     * @param object $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get data order
     *
     * @param mixed $seach
     * @param string $code
     * @param string $return
     *
     * @return array
     */
    public function get($seach, $code = DB_PREFIX . 'id', $return = 'all')
    {
        $data = array();

        if (strripos($code, 'id') !== false) {
            $seach = (int)$seach;
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_orders WHERE " . $code . " = '" . $seach . "'");

        foreach ($query->row as $key => $value) {
            if ($return == 'all') {
                $data[$key] = $value;
            } elseif ($return == $key) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Get the data of the post-added order
     *
     * @param string $needed
     *
     * @return string|int
     */
    public function getLastOrder($needed = 'vk_id')
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_orders ORDER BY id DESC LIMIT 1");

        foreach ($query->row as $key => $value) {
            if ($key == $needed) {

                return $value;
            }
        }
    }

    /**
     * Get all orders
     *
     * @param string $key
     *
     * @return array
     */
    public function getAll($key = DB_PREFIX . 'id')
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_orders");

        $data = array();

        foreach ($query->rows as $row) {
            $data[$row[$key]] = $row;
        }

        return $data;
    }

    /**
     * Set data order
     *
     * @param array $data
     */
    public function set($data)
    {
        $this->db->query(
            "INSERT INTO " . DB_PREFIX . "vk_orders SET " . DB_PREFIX . "id = '" . (int)$data[DB_PREFIX . 'id'] . "', " . DB_PREFIX . "status = '" . (int)$data[DB_PREFIX . 'status'] . "', vk_id = '" . (int)$data['vk_id'] . "', vk_status = '" . (int)$data['vk_status'] . "', vk_user_id = '" . (int)$data['vk_user_id'] . "', json_last_event = '" . $this->db->escape(json_encode($data['json_last_event'], true)) . "', date_added = NOW(), date_modified = NOW()");
    }

    /**
     * Update last added order
     *
     * @param array $data
     */
    public function updateNewOrder($data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "vk_orders SET " . DB_PREFIX . "id = '" . (int)$data[DB_PREFIX . 'id'] . "', " . DB_PREFIX . "status = '" . (int)$data[DB_PREFIX . 'status'] . "', date_modified = NOW() WHERE vk_id = '" . (int)$data['vk_id'] . "'");
    }

    /**
     * Edit order status
     *
     * @param int $vk_id
     * @param int $vk_status
     * @param int $oc_status
     */
    public function editStatuses($vk_id, $vk_status, $oc_status)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "vk_orders SET vk_status = '" . (int)$vk_status . "', " . DB_PREFIX . "status = '" . (int)$oc_status . "', date_modified = NOW() WHERE vk_id = '" . $vk_id . "'");
    }

    /**
     * Delete order
     *
     * @param int $id
     * @param string $code
     */
    public function delete($id, $code = DB_PREFIX . 'id')
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "vk_orders WHERE " . $code . " = '" . (int)$id . "'");
    }
}