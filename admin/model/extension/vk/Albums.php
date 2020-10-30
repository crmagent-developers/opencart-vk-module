<?php


class Albums
{
    /**
     * @var object
     */
    private $db;

    /**
     * Albums constructor.
     *
     * @param object $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get data albums
     *
     * @param mixed $seach
     * @param string $code
     * @param string $return
     *
     * @return array|string
     */
    public function get($seach, $code = DB_PREFIX . 'id', $return = 'all') {

        $data = array();

        if (strripos($code, 'id') !== false) {
            $seach = (int)$seach;
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_albums WHERE " . $code . " = '" . $seach . "'");

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
     * Get all albums
     *
     * @return array
     */
    public function getAll() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_albums");

        return $query->rows;
    }

    /**
     * Set data albums
     *
     * @param array $data
     */
    public function set($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "vk_albums SET " . DB_PREFIX . "id = '" . $data[DB_PREFIX . 'id'] . "', " . DB_PREFIX . "parent_id = '" . $data[DB_PREFIX . 'parent_id'] . "', " . DB_PREFIX . "name = '" . $data[DB_PREFIX . 'name'] . "', vk_id = '" . (int)$data['vk_id'] . "', date_added = NOW(), date_modified = NOW()");
    }

    /**
     * Delete albums
     *
     * @param int $oc_id
     * @param null|int $oc_parent_id
     */
    public function delete($oc_id, $oc_parent_id = null) {
        $query = "DELETE FROM " . DB_PREFIX . "vk_albums WHERE " . DB_PREFIX . "id = '" . (int)$oc_id . "'";

        if (isset($oc_parent_id)) {
            $query .= " AND " . DB_PREFIX . "parent_id = '" . (int)$oc_parent_id . "'";
        }

        $this->db->query($query);
    }
}