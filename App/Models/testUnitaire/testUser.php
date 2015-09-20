<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20/09/2015
 * Time: 11:31
 */

namespace App\Models\testUnitaire;


use App\Models\User;

class testUser extends \PHPUnit_Framework_TestCase
{

    public function testGetNom ()
    {
        $user = new User('jean-claude');
        $this->assertEquals('jean-claude', $user->getNom());

    }

    public function testSetNom ()
    {
        $user = new User('jean-claude');
        $user->setNom('jean-claudia');
        $this->assertEquals('jean-claudia', $user->getNom());
    }
}