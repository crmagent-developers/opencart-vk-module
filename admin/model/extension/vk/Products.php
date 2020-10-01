<?php


class Products
{
    /**
     * @var object
     */
    private $db;

    /**
     * Products constructor.
     *
     * @param object $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get data product
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

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_products WHERE " . $code . " = '" . $seach . "'");

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
     * Get all products
     *
     * @param null $key
     *
     * @return array
     */
    public function getAll()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_products");

        $data = array();

        foreach ($query->rows as $row) {
            if (!key_exists($row[DB_PREFIX . 'id'], $data)) {
                $data[$row[DB_PREFIX . 'id']] = array(
                        DB_PREFIX . 'id' => $row[DB_PREFIX . 'id'],
                        'categories_albums' => json_decode($row['categories_albums'], true),
                        'offers' => array(
                            $row['offer'] => array(
                                    'vk_id' => $row['vk_id'],
                                    'offer' => $row['offer']
                                )
                        )
                    );
            } else {
                $data[$row[DB_PREFIX . 'id']]['offers'][$row['offer']] = array(
                    'vk_id' => $row['vk_id'],
                    'offer' => $row['offer']
                );
            }
        }

        return $data;
    }

    /**
     * Set data product
     *
     * @param array $data
     */
    public function set($data)
    {
        $this->db->query(
            "INSERT INTO " . DB_PREFIX . "vk_products SET " . DB_PREFIX . "id = '" . $data[DB_PREFIX . 'id'] . "', vk_id = '" . (int)$data['vk_id'] . "', categories_albums = '" . $data['categories_albums'] . "', offer = '" . $data['offer'] . "'");
    }

    /**
     * Edit data product
     *
     * @param array $data
     */
    public function edit($data)
    {
        $this->db->query(
            "UPDATE " . DB_PREFIX . "vk_products SET categories_albums = '" . $data['categories_albums'] . "' WHERE vk_id = '" . (int)$data['vk_id'] . "'");
    }

    /**
     * Delete product
     *
     * @param int $id
     * @param string $code
     */
    public function delete($id, $code = DB_PREFIX . 'id')
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "vk_products WHERE " . $code . " = '" . (int)$id . "'");
    }
}