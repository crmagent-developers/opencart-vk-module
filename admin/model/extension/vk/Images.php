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
     * @param int $source_id
     * @param string $type
     *
     * @return array
     */
    public function get($path, $source_id, $type) {
        $data = array();
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vk_images WHERE " . DB_PREFIX . "path = '" . $path . "' AND " . DB_PREFIX . "source_id = '" . $source_id . "' AND `type` = '" . $type . "'");

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
        $this->db->query("INSERT INTO " . DB_PREFIX . "vk_images SET `type` = '" . $data['type'] . "', " . DB_PREFIX . "source_id = '" . $data[DB_PREFIX . 'source_id'] . "', " . DB_PREFIX . "path = '" . $data[DB_PREFIX . 'path'] . "', vk_id = '" . (int)$data['vk_id'] . "', date_added = NOW(), date_modified = NOW()");
    }

    /**
     * Delete image
     *
     * @param string $path
     * @param int $source_id
     * @param string $type
     */
    public function delete($source_id, $type) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "vk_images WHERE " . DB_PREFIX . "source_id = '" . $source_id . "' AND `type` = '" . $type . "'");
    }
}