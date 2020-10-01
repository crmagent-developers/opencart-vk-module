<?php

require_once 'Orders.php';

class ModelExtensionVkTables extends Model
{
    /**
     * @return Orders
     */
    public function orders()
    {
        return new Orders($this->db);
    }
}