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
        //var_dump('Fonction : index()');
        $flash_tmp_message = "";
        $flash = false;
        $flash_message = $app['session']->get('flash');
        if ($flash_message != null){
            $flash = $flash_message['flash'];
            $flash_tmp_message = $flash_message['tmp_message'];
            $app['session']->set('flash', null);
        }
        return $app['twig']->render('accueil.twig',array(
                                            'flash' => $flash,
                                            'flash_message' => $flash_tmp_message

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
        $index = $app['controllers_factory'];

        $index->match("/", __CLASS__.'::index');
        $index->match("/IndexController", __CLASS__.'::index');
        $index->match("/IndexController/index", __CLASS__.'::index');// Code �quivalent ==> $index->match("/", 'App\Controller\IndexController::index');
        $index->match("/IndexController/deux", __CLASS__.'::deux');

        return $index;
    }
}