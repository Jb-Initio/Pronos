<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 22/09/2015
 * Time: 22:53
 */

namespace App\Models\testUnitaire;


use App\Controllers;




class PronosControllerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp ()
    {
      require  PronosController.php;
    }
    public function testIsNotTimeOut ()
    {
        $expected1 = PronosController::isNotTimeout("20.09.2015", "20:30", true);
        $expected2 = PronosController::isNotTimeout("20.12.2015", "20:30", true);
        $this->assertTrue($expected1, "PronosController");
        $this->assertFalse($expected2, "PronosController");
    }
}