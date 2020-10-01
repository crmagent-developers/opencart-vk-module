<?php

class Events
{
    /**
     * @var object
     */
    private $db;

    /**
     * Events constructor.
     *
     * @param object $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get the id of the order with which the last event occurred
     *
     * @return array
     */
    public function getLastEvent()
    {
        $data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_events ORDER BY id DESC LIMIT 1");

        foreach ($query->row as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * Delete event
     *
     * @param int $order_vk_id
     */
    public function delete($order_vk_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "vk_events WHERE order_vk_id = '" . (int)$order_vk_id . "'");
    }
}