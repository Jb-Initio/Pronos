<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20/09/2015
 * Time: 21:56
 */

namespace App\Controllers;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class PronosController implements ControllerProviderInterface
{

    public function pronostic (Application $app)
    {
        var_dump('fonction : pronotic in');
        $tab_matches = $app['session']->get('matches');
        var_dump($tab_matches);
        die();
        $match_id = $app['session']->get('tmp_message');
        return $app['twig']->render('pronostic.twig', array('match_id' =>  $match_id ));
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
        $prono = $app['controllers_factory'];
        $prono->match("/", __CLASS__.'::pronostic');
        $prono->match("/pronostic", __CLASS__.'::pronostic');
        return $prono;
    }
}