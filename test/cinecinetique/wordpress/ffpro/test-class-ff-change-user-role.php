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
            ->setMethods(array('retrieve_field_value','formKeyToId'))
            ->getMock();
        $entry_id = 54 ;
        $current_form_id = 42 ;

        $rolechanger->expects($this->once())
            ->method('formKeyToId')
            ->with( $this->equalTo('jfykn') )
            ->will( $this->returnValue(42) );


        $rolechanger->expects($this->exactly(2))
            ->method('retrieve_field_value')
            ->withConsecutive(
                 array($this->equalTo('f0ra1')),
                 array($this->equalTo('ry194'))
            )
            ->will($this->onConsecutiveCalls('Yes', 100));


        \WP_Mock::wpFunction( 'get_userdata', array(
            'args' => 100,
            'times' => 1,
            'return' => $user
        ) );

        $user->shouldReceive('has_cap')
            ->with(
            "administrator"
            )
            ->times(1)
            ->andReturn(false) ;

        $user->shouldReceive('set_role')
            ->with(
            'parent'
            )
            ->times(1) ;

        $rolechanger->changeUserRole($entry_id, $current_form_id);
    }

    function test_should_not_change_role_for_admin() {
        $user = m::mock('user') ;
        $rolechanger = $this->getMockBuilder('\Cinecinetique\Wordpress\FFPro\ChangeUserRole')
            ->disableOriginalConstructor()
            ->setMethods(array('retrieve_field_value','formKeyToId'))
            ->getMock();
        $entry_id = 54 ;
        $current_form_id = 42 ;

        $rolechanger->expects($this->once())
            ->method('formKeyToId')
            ->with( $this->equalTo('jfykn') )
            ->will( $this->returnValue(42) );


        $rolechanger->expects($this->exactly(2))
            ->method('retrieve_field_value')
            ->withConsecutive(
                 array($this->equalTo('f0ra1')),
                 array($this->equalTo('ry194'))
            )
            ->will($this->onConsecutiveCalls('Yes', 100));


        \WP_Mock::wpFunction( 'get_userdata', array(
            'args' => 100,
            'times' => 1,
            'return' => $user
        ) );

        $user->shouldReceive('has_cap')
            ->with(
            "administrator"
            )
            ->times(1)
            ->andReturn(true) ;

        $user->shouldReceive('set_role')
            ->with(
            'parent'
            )
            ->times(0) ;

        $rolechanger->changeUserRole($entry_id, $current_form_id);

    }

    function test_should_not_change_role_if_no_user() {
        $user = m::mock('user') ;
        $rolechanger = $this->getMockBuilder('\Cinecinetique\Wordpress\FFPro\ChangeUserRole')
            ->disableOriginalConstructor()
            ->setMethods(array('retrieve_field_value','formKeyToId'))
            ->getMock();
        $entry_id = 54 ;
        $current_form_id = 42 ;

        $rolechanger->expects($this->once())
            ->method('formKeyToId')
            ->with( $this->equalTo('jfykn') )
            ->will( $this->returnValue(42) );


        $rolechanger->expects($this->exactly(2))
            ->method('retrieve_field_value')
            ->withConsecutive(
                 array($this->equalTo('f0ra1')),
                 array($this->equalTo('ry194'))
            )
            ->will($this->onConsecutiveCalls('Yes', 100));


        \WP_Mock::wpFunction( 'get_userdata', array(
            'args' => 100,
            'times' => 1,
            'return' => null
        ) );

        $user->shouldReceive('has_cap')
            ->with(
            "administrator"
            )
            ->times(0); //because easy evaluation of ($user && ! has_cap('administrator')), if $user null, has_cap won't be called

        $user->shouldReceive('set_role')
            ->with(
            'parent'
            )
            ->times(0) ;

        $rolechanger->changeUserRole($entry_id, $current_form_id);
    }

    function test_should_not_change_role_if_no_user_id() {
        $user = m::mock('user') ;
        $rolechanger = $this->getMockBuilder('\Cinecinetique\Wordpress\FFPro\ChangeUserRole')
            ->disableOriginalConstructor()
            ->setMethods(array('retrieve_field_value','formKeyToId'))
            ->getMock();
        $entry_id = 54 ;
        $current_form_id = 42 ;

        $rolechanger->expects($this->once())
            ->method('formKeyToId')
            ->with( $this->equalTo('jfykn') )
            ->will( $this->returnValue(42) );


        $rolechanger->expects($this->exactly(2))
            ->method('retrieve_field_value')
            ->withConsecutive(
                 array($this->equalTo('f0ra1')),
                 array($this->equalTo('ry194'))
            )
            ->will($this->onConsecutiveCalls('Yes', null));


        \WP_Mock::wpFunction( 'get_userdata', array(
            'args' => 100,
            'times' => 1,
            'return' => $user
        ) );

        $user->shouldReceive('has_cap')
            ->with(
            "administrator"
            )
            ->times(0); //because easy evaluation of ($user && ! has_cap('administrator')), if $user null, has_cap won't be called

        $user->shouldReceive('set_role')
            ->with(
            'parent'
            )
            ->times(0) ;

        $rolechanger->changeUserRole($entry_id, $current_form_id);
    }


    function test_should_not_change_role_if_wrong_form () {
        $user = m::mock('user') ;
        $rolechanger = $this->getMockBuilder('\Cinecinetique\Wordpress\FFPro\ChangeUserRole')
            ->disableOriginalConstructor()
            ->setMethods(array('formKeyToId'))
            ->getMock();
        $entry_id = 54 ;
        $current_form_id = 20 ;

        $rolechanger->expects($this->once())
            ->method('formKeyToId')
            ->with( $this->equalTo('jfykn') )
            ->will( $this->returnValue(42) );


        $user->shouldReceive('set_role')
            ->with(
            'parent'
            )
            ->times(0) ;


        $rolechanger->changeUserRole($entry_id, $current_form_id);
    }

    function test_should_not_change_role_if_wrong_value () {
        $user = m::mock('user') ;
        $rolechanger = $this->getMockBuilder('\Cinecinetique\Wordpress\FFPro\ChangeUserRole')
            ->disableOriginalConstructor()
            ->setMethods(array('formKeyToId', 'retrieve_field_value'))
            ->getMock();
        $entry_id = 54 ;
        $current_form_id = 42 ;

        $rolechanger->expects($this->once())
            ->method('formKeyToId')
            ->with( $this->equalTo('jfykn') )
            ->will( $this->returnValue(42) );

        $rolechanger->expects($this->once())
            ->method('retrieve_field_value')
            ->with( $this->equalTo('f0ra1') )
            ->will( $this->returnValue('foobar') );

        $user->shouldReceive('set_role')
            ->with(
            'parent'
            )
            ->times(0) ;


        $rolechanger->changeUserRole($entry_id, $current_form_id);
    }
}
