<?php

require_once 'Images.php';
require_once 'Albums.php';
require_once 'Products.php';
require_once 'Orders.php';
require_once 'Customers.php';
require_once 'Events.php';

class ModelExtensionVkTables extends Model
{
    /**
     * Create tables
     */
    public function createTables()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "vk_images (`type` VARCHAR(255), " . DB_PREFIX . "source_id VARCHAR(255), " . DB_PREFIX . "path VARCHAR(255), vk_id INT(11), `date_added` datetime NOT NULL)");
        $this->db->query("ALTER TABLE " . DB_PREFIX . "vk_images CONVERT TO CHARACTER SET utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "vk_albums (" . DB_PREFIX . "id INT(11), " . DB_PREFIX . "parent_id INT(11), " . DB_PREFIX . "name VARCHAR(255), vk_id INT(11))");
        $this->db->query("ALTER TABLE " . DB_PREFIX . "vk_albums CONVERT TO CHARACTER SET utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "vk_products (" . DB_PREFIX . "id INT(11), vk_id INT(11), categories_albums TEXT, offer TEXT)");
        $this->db->query("ALTER TABLE " . DB_PREFIX . "vk_products CONVERT TO CHARACTER SET utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "vk_orders (id INT(11) PRIMARY KEY AUTO_INCREMENT, " . DB_PREFIX . "id INT(11), " . DB_PREFIX . "status INT(11), vk_id INT(11), vk_status INT(11), vk_user_id INT(11), json_last_event MEDIUMTEXT)");
        $this->db->query("ALTER TABLE " . DB_PREFIX . "vk_orders CONVERT TO CHARACTER SET utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "vk_customers (" . DB_PREFIX . "id INT(11), vk_id INT(11))");
        $this->db->query("ALTER TABLE " . DB_PREFIX . "vk_customers CONVERT TO CHARACTER SET utf8;");

        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "vk_events (id INT(11) PRIMARY KEY AUTO_INCREMENT, order_vk_id INT(11))");
        $this->db->query("ALTER TABLE " . DB_PREFIX . "vk_events CONVERT TO CHARACTER SET utf8;");
    }

    /**
     * Delete tables
     */
    public function unsetTables()
    {
        $this->db->query("DROP TABLE " . DB_PREFIX . "vk_images");
        $this->db->query("DROP TABLE " . DB_PREFIX . "vk_albums");
        $this->db->query("DROP TABLE " . DB_PREFIX . "vk_products");
        $this->db->query("DROP TABLE " . DB_PREFIX . "vk_orders");
        $this->db->query("DROP TABLE " . DB_PREFIX . "vk_customers");
        $this->db->query("DROP TABLE " . DB_PREFIX . "vk_events");
    }

    /**
     * @return Images
     */
    public function images()
    {
        return new Images($this->db);
    }

    /**
     * @return Albums
     */
    public function albums()
    {
        return new Albums($this->db);
    }

    /**
     * @return Products
     */
    public function products()
    {
        return new Products($this->db);
    }

    /**
     * @return Orders
     */
    public function orders()
    {
        return new Orders($this->db);
    }

    /**
     * @return Customers
     */
    public function customers()
    {
        return new Customers($this->db);
    }

    /**
     * @return Events
     */
    public function events()
    {
        return new Events($this->db);
    }
}