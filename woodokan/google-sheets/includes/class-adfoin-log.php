<?php

class woodokan_google_sheets_integration_Log extends woodokan_google_sheets_integration_DB {

    /*
    * The constructor function
    */
    public function __construct() {
        global $wpdb;

        $this->db    = $wpdb;
        $this->table = $this->db->prefix . 'woodokan_log';
    }
}