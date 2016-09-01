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

    function test_formKeyToId () {
        $wpdb = m::mock('wpdb') ;
        $frmdb = new \stdClass ;

        $sut = new \Cinecinetique\Wordpress\FFPro\ChangeUserRole ($wpdb, $frmdb) ;

        $wpdb->shouldReceive('get_var')
            ->with(
            "SELECT id FROM wp_frm_forms WHERE form_key='xxx'"
            )
            ->times(1)
            ->andReturn(36) ;

        $sut->formKeyToId("xxx");

    }

    function test_change_user_role_happy_path () {
        $user = m::mock('user') ;
        $rolechanger = $this->getMockBuilder('\Cinecinetique\Wordpress\FFPro\ChangeUserRole')
            ->disableOriginalConstructor()
            ->setMethods(array('retrieve_field_value','get_wpdb'))
            ->getMock();
        $entry_id = 54 ;
        $form_id = 20 ;


        $rolechanger->expects($this->exactly(2))
            ->method('retrieve_field_value')
            ->withConsecutive(
                 array($this->equalTo('f0ra1')),
                 array($this->equalTo('ry194'))
            )
            ->will($this->onConsecutiveCalls('yes', 100));


        \WP_Mock::wpFunction( 'get_userdata', array(
            'args' => 100,
            'times' => 1,
            'return' => $user
        ) );

        $user->shouldReceive('set_role')
            ->with(
            "Parent"
            )
            ->times(1) ;

        $rolechanger->changeUserRole($entry_id, $form_id);
    }

}
