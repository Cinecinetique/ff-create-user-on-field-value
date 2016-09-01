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

        // form & fields keys of interest. We work with keys instead of ids as ids change as forms are deployed on different environments
        $field_to_check_key = 'f0ra1';
        $user_id_field_key = 'ry194' ;
        $target_form_key = 'jfykn' ;
        $new_role = 'parent';
        $wanted_value = 'Yes';

        // we return immediately if the current form being processed is not the one we want to act on
        if ( $form_id != $this->formKeyToId($target_form_key) )
            return;

        // get field value for field to check
        $value_to_check = $this->retrieve_field_value($field_to_check_key);
        if ($wanted_value != $value_to_check)
            return;

        // get field value for User id
        $user_id = $this->retrieve_field_value($user_id_field_key);
        if ($value_to_check && $user_id) {
            // get user_data. This is a core Wordpress function
            $user = get_userdata($user_id);
            // set user role only if user exists and is not an admin, don't want to demote an admin
            if ( $user && ! $user->has_cap('administrator') ) {
                    $user->set_role( $new_role );
            }
        }


    }

}
