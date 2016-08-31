<?php

namespace Cinecinetique\Wordpress\FFPro\Tests;

use \Mockery as m;

class ChangeUserRoleTest extends \PHPUnit_Framework_TestCase {


    public function setUp() {
        $_POST['item_meta'] = array (
          36 => "Foo Bar"
        ) ;
    }
    public function tearDown() {
        m::close() ;
    }

    public function testFailure()
    {
          $this->assertFalse(false);
    }

    function test_class_can_be_instantiated () {
          $wpdb = new \stdClass;
          $frmdb = new \stdClass;
          $sut = new \Cinecinetique\Wordpress\FFPro\ChangeUserRole ($wpdb, $frmdb) ;

          $this->assertNotNull($sut->get_wpdb()) ;
          $this->assertNotNull($sut->get_frmdb()) ;
    }

    function test_retrieve_field_value () {
        $wpdb = m::mock('wpdb') ;
        $frmdb = new \stdClass ;

        $sut = new \Cinecinetique\Wordpress\FFPro\ChangeUserRole ($wpdb, $frmdb) ;


        $wpdb->shouldReceive('get_var')
            ->with(
            "SELECT id FROM wp_frm_fields WHERE field_key='xxx'"
            )
            ->times(1)
            ->andReturn(36) ;

        $value = $sut->retrieve_field_value("xxx") ;
        $this->assertEquals("Foo Bar", $value);
  }

}
