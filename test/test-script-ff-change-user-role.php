<?php

namespace Cinecinetique\Wordpress\FFPro\ChangeUserRole\Tests;

class ScriptChangeUserRoleTest extends \PHPUnit_Framework_TestCase {

  public function setUp() {
        \WP_Mock::setUp();
  }

  public function tearDown() {
        \WP_Mock::tearDown();
  }

  function test_action_hook_is_created () {
    $wpdb = new \stdClass;
    $frmdb = new \stdClass;

    $main = new \Cinecinetique\Wordpress\FFPro\ChangeUserRoleMain () ;

    \WP_Mock::expectActionAdded( 'frm_after_update_entry',
                                  array ($this->isInstanceOf ('FFChangeUserRole'), 'changeUserRole') ,
                                  45, 2
                                );

    $main->register_wordpress_hook($wpdb, $frmdb);
  }

}
