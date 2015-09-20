<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 19/09/2015
 * Time: 22:48
 */

namespace App\Models\testUnitaire;


class FootBallAPITest extends \PHPUnit_Framework_TestCase
{
    public function testGetCompetitionPremierLeague()
    {
        $this->assertNotInstanceOf('stdClass', FootBallAPI::getCompetitionsPremierLeague());
        $this->assertNotNull(null, FootBallAPI::getCompetitionsPremierLeague());
    }

    public function testGetTodayMatchs()
    {
        $this->assertNotInstanceOf('stdClass', FootBallAPI::getCompetitionsPremierLeague());
        $this->assertNotNull(null, FootBallAPI::getCompetitionsPremierLeague());
    }

}