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

    public function setUp ()
    {
        require_once  DbPronostic.php;
    }
   /* public function testGetIdUser ()
    {

        $dbProno = new DbPronostic();
        $expected = 2;
        $this->assertEquals(2, 2);
        //$this->assertEquals(1, 0);
        //$this->assertEquals($expected, $dbProno->getIdUser('bobino'), 'Veleur de retour de getIdUser() de DbPronostic incorrect');
    }*/

    public function testGetMatch ()
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
        $this->assertArraySubset($expected, $dbProno->getMatch('2', '15752'));
    }
}