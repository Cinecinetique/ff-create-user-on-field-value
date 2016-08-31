<?php

namespace Cinecinetique\Wordpress\FFPro\Tests;

use \Mockery as m;

class ChangeUserRoleTest extends \PHPUnit_Framework_TestCase {


  public function setUp() {

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

}
