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

    public function retrieve_field_value($field_key) {
        $paid_field_id = $this->get_wpdb()->get_var("SELECT id FROM wp_frm_fields WHERE field_key='{$field_key}'");
        return $_POST['item_meta'][$paid_field_id];

    }

    public function formKeyToId($field_key) {
        $form_id = $this->get_wpdb()->get_var("SELECT id FROM wp_frm_forms WHERE form_key='{$field_key}'");
        return $form_id;

    }


    public function changeUserRole ($entry_id,$form_id) {

        $target_field_key = 'f0ra1';
        $target_user_key = 'ry194' ;

        //happy path:
        //get field value for Paid field
        $paid_value = $this->retrieve_field_value($target_field_key);
        //get field value for User id
        $user_id = $this->retrieve_field_value($target_user_key);
        //get user_data
        $user = get_userdata($user_id);
        //set user role
        $user->set_role('Parent');


    }

}
