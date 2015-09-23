<?php
$loader = require_once __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../vendor/doctrine/common/lib/Doctrine/Common/ClassLoader.php';

use Doctrine\Common\ClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader->add("App", dirname(__DIR__));//Ajout du r�pertoir applicatif dans l'autoloader
//METTRE LE BON CHEMIN VERS DOCTRINE !!!!!!!
$classLoader = new ClassLoader('Doctrine', '/path/to/doctrine');
$classLoader->register();

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../App/views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());


//Rooting Post
$app->post('mom', function (Request $request) use ($app) {
    $pseudo = $request->get('pseudo');
    $app['session']->set('tmp_message', ['pseudo' => $pseudo]);

    return $app->redirect('/silex_pronostic/web/index.php/MatchController');
})->bind('mom');

$app->post('pronostic', function (Request $request) use ($app) {
    //Sauvegarder les données du formulaire dans la session

    return $app->redirect('/silex_pronostic/web/index.php/PronosController/validerPronos');
})->bind('validation');


//Rooting GET
$app->get('/pronostic/', function (Request $request) use ($app) {
    $id = $request->get('match_id');
    $app['session']->set('tmp_message', ['match_id' => $id]);

    return $app->redirect('/silex_pronostic/web/index.php/PronosController');
})->bind('pronostic');


$app->mount("/MatchController", new App\Controllers\MatchController());
$app->mount("/PronosController", new App\Controllers\PronosController());
$app->mount("/", new App\Controllers\IndexController());




/*
$app->get('/accueil', function () use ($app) {
    return $app['twig']->render('accueil.twig',[]);
});

$app->get('/testHeure', function () use ($app) {
    date_default_timezone_set('Europe/London');
    var_dump(date('d.m.Y H:i:s'));

});

$app->get('/sindex', function () use ($app) {
    $config = new \Doctrine\DBAL\Configuration();

    $connectionParams = array(
        'dbname' => 'befoot',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    );
    $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

    $sql = "SELECT * FROM users as u, matchs WHERE u.id = ?";
    $id = 2;
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    var_dump($stmt->fetchAll());
    die();
    $sql = "SELECT * FROM users";
    $stmt = $conn->query($sql);
    var_dump($stmt->fetchAll());
    die();
    return $app['twig']->render('index.twig');
});

$app->get('/silex', function () use ($app) {
    $reqCometition = 'http://football-api.com/api/?Action=competitions&APIKey=a9b47ac5-3ed9-b8b1-05510e59d602';
    $reqStandings = 'http://football-api.com/api/?Action=standings&APIKey=a9b47ac5-3ed9-b8b1-05510e59d602&comp_id=1204';

    $requestComp = new \sylouuu\Curl\Get($reqCometition);
    $requestComp->send();

    $requestStand = new \sylouuu\Curl\Get($reqStandings);
    $requestStand->send();

    var_dump(date('d.m.Y'));

    die();

    $requestFix = new \sylouuu\Curl\Get($reqFixtures);
    $requestFix->send();

    $contenus = array(
                     $requestComp->getResponse(),
                     $requestStand->getResponse(),
                     $requestToday->getResponse(),
                     $requestFix->getResponse()
                     );

    //var_dump('<p>'.$contenus.'</p>');

    //var_dump(\lib\FootBallAPI\FootBallAPI::getPremierLeague());
    return $app['twig']->render('index.twig', array(
                                                    'titre' => 'Match Premier League',
                                                    'contenus' =>$contenus
                                                    ));
});
*/
$app->run();

