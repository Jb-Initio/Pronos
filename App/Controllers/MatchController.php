<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20/09/2015
 * Time: 00:01
 */

namespace App\Controllers;

use App\Models\FootBallAPI;
use App\Models\User;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class MatchController implements ControllerProviderInterface
{
    public function matchsDay(Application $app)
    {
        // Vérifie si l'utilisateur possède un nom
        if ($app['session']->get('user') === null) {
            $tmp_message = $app['session']->get('tmp_message');
            if ($tmp_message === null) {
                return  $app->redirect("/silex_pronostic/web/index.php/");
            }
            $app['session']->set('user', ['user' => new User($app['session']->get('tmp_message')['pseudo'])]);
            $app['session']->set('tmp_message', null);
        }
        //R�cup�ration & stockage  matches data
        $matchs_jour = FootBallAPI::getMatchsOfTheDay(null, '20.09.2015');
        $flash_tmp_message = "";
        $flash = false;
        $flash_message = $app['session']->get('flash');
        if ($flash_message != null){
            $flash = $flash_message['flash'];
            $flash_tmp_message = $flash_message['tmp_message'];
            $app['session']->set('flash', null);
        }
        if (property_exists($matchs_jour, 'ERROR') && (property_exists($matchs_jour, 'ERROR') == null)){

            return $app['twig']->render('matchsjour.twig', array(
                                                                 'flash' => $flash,
                                                                 'flash_message' => $flash_message,
                                                                'matches' =>[],
                                                                 'error' => true
                                                                 ));
        }
        $tab_matches = $matchs_jour->matches;
        $app['session']->set('matches', $tab_matches);
        return $app['twig']->render('matchsjour.twig', array(
            'flash' => $flash,
            'flash_message' => $flash_message,
            'matches' => $tab_matches));
    }

    public function matchsWeek(Application $app)
    {   //Traitement des données à traiter
        if ($app['session']->get('user') === null) {
            $tmp_message = $app['session']->get('tmp_message');
            if ($tmp_message === null) {
                return  $app->redirect("/silex_pronostic/web/index.php/");
            }
            $app['session']->set('user', ['user' => new User($app['session']->get('tmp_message')['pseudo'])]);
            //$app['session']->set('tmp_message', null);
        }

        //R�cup�ration & stockage  matches data
        $tmp_message = $app['session']->get('tmp_message');
        $matchs_jour = FootBallAPI::getPeriodMatchs($tmp_message['dateDebut'], $tmp_message['dateFin']);

        if (property_exists($matchs_jour, 'ERROR') && (property_exists($matchs_jour, 'ERROR') == null)){

            return $app['twig']->render('matchsperiod.twig', array('matches' =>[],
                'error' => true
            ));
        }

        ////
        $flash = false;
        $flash_message = $app['session']->get('flash');
        if ($flash_message != null){
            $flash = $flash_message['flash'];
            $flash_tmp_message = $flash_message['tmp_message'];
            $flash_message = $app['session']->set('flash', null);
        }
        ////
        $tab_matches = $matchs_jour->matches;
        $app['session']->set('matches', $tab_matches);
        return $app['twig']->render('matchsperiod.twig', array(
                                                            'flash' => $flash,
                                                            'flash_message' => $flash_tmp_message,
                                                            'matches' => $tab_matches,
                                                            'dateDebut' => $tmp_message['dateDebut'],
                                                            'dateFin' =>  $tmp_message['dateFin']

        ));
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $match = $app['controllers_factory'];
        //D�finition des routes
        $match->match("/", __CLASS__.'::matchsDay');
        $match->match("/matchs_day", __CLASS__.'::matchsDay');// Code �quivalent ==> $index->match("/", 'App\Controller\IndexController::index');
        $match->match("/matchs_period", __CLASS__.'::matchsWeek');

        return $match;
    }
}