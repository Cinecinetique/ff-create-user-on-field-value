<?php

namespace Cinecinetique\Wordpress\FFPro ;

Class ChangeUserRole {

    private $_wpdb;
    private $_frmdb;

    public function __construct($wpdb,$frmdb) {
        $this->_wpdb = $wpdb;
        $this->_frmdb = $frmdb;
    }
    
    public function get_wpdb () {
      return $this->_wpdb;
    }

    public function get_frmdb () {
        return $this->_frmdb;
    }

}
