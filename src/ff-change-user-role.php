<?php
namespace Cinecinetique\Wordpress\FFPro;
/**
 * @package Change_User_Role
 * @version 1.0
 */
/*
Plugin Name: Change User Role On Field Value For Formidable Forms
Plugin URI: https://cinecinetique.com
Description: Add functions to a Formidable form to change the role of a user when a field on a form has a specific value
Author: Rija Ménagé
Version: 1.0
Author URI: https://www.cinecinetique.com
*/

global $wpdb, $frmdb;

require_once (__DIR__ . '/classes/cinecinetique/wordpress/ffpro/ChangeUserRole.php') ;


Class ChangeUserRoleMain {

  function register_wordpress_hook ($wpdb, $frmdb) {

    $ff_plugin_class = new \Cinecinetique\Wordpress\FFPro\ChangeUserRole($wpdb, $frmdb);

    add_action('frm_after_update_entry', array ($ff_plugin_class, 'changeUserRole'), 45, 2);

  }
}


$main = new ChangeUserRoleMain () ;

$main->register_wordpress_hook ($wpdb, $frmdb) ;
