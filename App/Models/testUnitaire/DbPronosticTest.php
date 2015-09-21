<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 21/09/2015
 * Time: 22:47
 */

namespace App\Models\testUnitaire;


use App\Models\DbPronostic;

class DbPronosticTest extends \PHPUnit_Framework_TestCase
{
    public function getIdUserTest ()
    {
        $dbProno = new DbPronostic();
        $this->assertEquals($dbProno->getIdUser('bobino'), 2);
    }

    public function getMatchTest ()
    {
        $dbProno = new DbPronostic();
        $dbProno->getMatch('2', '15752');
    }
}