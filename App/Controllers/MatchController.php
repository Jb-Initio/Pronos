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
        if ($app['session']->get('user') === null) {
            $tmp_message = $app['session']->get('tmp_message');
            if ($tmp_message === null) {
                return  $app->redirect("/silex_pronostic/web/index.php/");
            }
            $app['session']->set('user', ['user' => new User($app['session']->get('tmp_message')['pseudo'])]);
            $app['session']->set('tmp_message', null);
        }
        //Récupération & stockage  matches data
        $matchs_jour = FootBallAPI::getMatchsOfTheDay(null, '20.09.2015');

        if (property_exists($matchs_jour, 'ERROR') && (property_exists($matchs_jour, 'ERROR') == null)){

            return $app['twig']->render('matchsjour.twig', array('matches' =>[],
                                                                 'error' => true
                                                                 ));
        }
        $tab_matches = $matchs_jour->matches;
        $app['session']->set('matches', $tab_matches);
        var_dump($tab_matches);
        return $app['twig']->render('matchsjour.twig', array('matches' => $tab_matches));
    }

    public function matchsWeek(Application $app)
    {
        var_dump('function: matchsSemaine');
        die();
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
        //Définition des routes
        $match->match("/", __CLASS__.'::matchsDay');
        $match->match("/matchs_day", __CLASS__.'::matchsDay');// Code équivalent ==> $index->match("/", 'App\Controller\IndexController::index');
        $match->match("/matchs_week", __CLASS__.'::matchsWeek');

        return $match;
    }
}