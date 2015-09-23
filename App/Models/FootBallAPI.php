<?php

/**
 * Created by PhpStorm.
 * User: hp
 * Date: 18/09/2015
 * Time: 22:12
 */
namespace App\Models;

class FootBallAPI
{
    const  API_KEY =  'a9b47ac5-3ed9-b8b1-05510e59d602';
    /**
     * Permet d'avoir la liste de toutes les comp�titions.
     * (Seul la Premier League est disponible avec un forfait gratuit)
     * @return mixed
     */
    public static function getCompetitionsPremierLeague ()
    {
        $reqCometition = 'http://football-api.com/api/?Action=competitions&APIKey='.self::API_KEY;
        $reponse = new HttpRequest($reqCometition, HttpRequest::METH_GET);
        try {
            $reponse->send();
            if ($reponse->getResponseCode() == 200) {
                return  json_decode($reponse->getResponseBody());
            }
        } catch (HttpException $ex) {
            echo $ex;
        }
    }

    /**
     * Permet d'avoir l'ensemble des matchs du jour
     * @return mixed R�sultat sour forme objet php
     */
    public static function getTodayMatchs()
    {
        $req_today = 'http://football-api.com/api/?Action=today&APIKey='.self::API_KEY.'&comp_id=1204';
        $request_today = new \sylouuu\Curl\Get($req_today);
        $request_today->send();
        return json_decode($request_today->getResponse());
    }


    /**
     * Permet d'avoir l'ensemble des matchs d'une comp�tition d�finie sur une p�riode.
     * (Avec un compte free, seul la Premier League peut �tre consult�e.)
     * @param Date $from_date date d�but
     * @param Date $to_date date de fin
     * @param int $comp_id identifiant de la comp�tition voulu
     * @return mixed R�sultat sour forme objet php
     */
    public static function getPeriodMatchs( $from_date,  $to_date, $comp_id = 1204)
    {
        $req_fixtures = 'http://football-api.com/api/?Action=fixtures&APIKey='.self::API_KEY.'&comp_id=1204&from_date='.$from_date.'&to_date='.$to_date;
        $request_fix = new \sylouuu\Curl\Get($req_fixtures);
        $request_fix->send();
        return json_decode($request_fix->getResponse());
    }

    /**
     * Permet d'avoir l'ensemble des matchs du jour correspondant a la league s�lectionn�e.
     * Si le 2nd param�tre n'est pas d�fini, la date du jour sera automatiquement attribu� � $today.
     * (Avec un compte free, seul la Premier League peut �tre consult�e.)
     * @param int $comp_id identifiant de la comp�tition
     * @param string today sp�cifie la date des matchs voulus.
     * @return mixed R�sultat sour forme objet php
     */
    public static function getMatchsOfTheDay($comp_id = 1204, $today = null)
    {
        if ($today === null) {
           $today =  date('d.m.Y');
        }
        $req_today = 'http://football-api.com/api/?Action=fixtures&APIKey='.self::API_KEY.'&comp_id='.$comp_id.'&match_date='. $today;
        $request_today = new \sylouuu\Curl\Get($req_today);
        $request_today->send();
        return json_decode($request_today->getResponse());
    }

}

