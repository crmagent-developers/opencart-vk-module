<?php


class Images
{
    /**
     * @var object
     */
    private $db;

    /**
     * Images constructor.
     *
     * @param object $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get image
     *
     * @param string $path
     *
     * @return array
     */
    public function get($path) {
        $data = array();
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_images WHERE " . DB_PREFIX . "path = '" . $path . "'");

        foreach ($query->row as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * Set image
     *
     * @param array $data
     */
    public function set($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "vk_images SET " . DB_PREFIX . "path = '" . $data[DB_PREFIX . 'path'] . "', vk_id = '" . (int)$data['vk_id'] . "'");
    }

    /**
     * Delete image
     *
     * @param string $path
     */
    public function delete($path) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "vk_images WHERE " . DB_PREFIX . "path = '" . $path . "'");
    }
}