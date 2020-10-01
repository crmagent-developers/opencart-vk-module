<?php


class Customers
{
    /**
     * @var object
     */
    private $db;

    /**
     * Customers constructor.
     *
     * @param object $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get customer
     *
     * @param int $id
     * @param string $code
     *
     * @return array
     */
    public function get($id, $code = DB_PREFIX . 'id')
    {
        $data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_customers WHERE " . $code . " = '" . (int)$id . "'");

        foreach ($query->row as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * Get all customers
     *
     * @param string $key
     *
     * @return array
     */
    public function getAll($key = DB_PREFIX . 'id')
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_customers");

        $data = array();

        foreach ($query->rows as $row) {
            $data[$row[$key]] = $row;
        }

        return $data;
    }

    /**
     * Set data customer
     *
     * @param array $data
     */
    public function set($data)
    {
        $this->db->query("INSERT INTO " . DB_PREFIX . "vk_customers SET " . DB_PREFIX . "id = '" . (int)$data[DB_PREFIX . 'id'] . "', vk_id = '" . (int)$data['vk_id'] . "'");
    }

    /**
     * Delete customer
     *
     * @param int $id
     * @param string $code
     */
    public function delete($id, $code = DB_PREFIX . 'id')
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "vk_customers WHERE " . $code . " = '" . (int)$id . "'");
    }
}