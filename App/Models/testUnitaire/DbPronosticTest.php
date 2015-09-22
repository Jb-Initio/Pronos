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
        $this->assertNull($dbProno->getIdUser('bopo'));
    }

    public function getMatchTest ()
    {
        $expected = array(
            'id' =>  '2',
            'match_id' => '2126781',
            'match_date' => '2015-09-21',
            'local_team_id' => '6874161',
            'local_team_score_pronos' => '684',
            'visitor_team_id' =>   '684',
            'visitor_team_score_pronos' => '687',
            'point' => null,
            'user_id' => '2'
        );
        $dbProno = new DbPronostic();
        $this->assertEquals($dbProno->getMatch('2', '15752'), $expected);
    }
}