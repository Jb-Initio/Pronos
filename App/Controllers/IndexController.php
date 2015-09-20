<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 19/09/2015
 * Time: 21:31
 */

namespace App\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class IndexController implements ControllerProviderInterface
{

    public function index(Application $app)
    {
        var_dump('Fonction : index()');

        return $app['twig']->render('accueil.twig',[]);
    }

    public function deux(Application $app)
    {
        var_dump('Fonction : deux()');
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
        $index = $app['controllers_factory'];

        $index->match("/", __CLASS__.'::index');
        $index->match("/IndexController", __CLASS__.'::index');
        $index->match("/IndexController/index", __CLASS__.'::index');// Code équivalent ==> $index->match("/", 'App\Controller\IndexController::index');
        $index->match("/IndexController/deux", __CLASS__.'::deux');

        return $index;
    }
}