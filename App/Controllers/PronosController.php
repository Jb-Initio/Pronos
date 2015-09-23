<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20/09/2015
 * Time: 21:56
 */

namespace App\Controllers;


use App\Models\DbPronostic;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class PronosController implements ControllerProviderInterface
{

    public function pronostic (Application $app)
    {
        if ($app['session']->get('user') === null) {
            $tmp_message = $app['session']->get('tmp_message');
            if ($tmp_message === null) {
                return $app->redirect("/silex_pronostic/web/index.php/");
            }
        }

        $tab_matches = $app['session']->get('matches');
        $local_name = null;
        $visitor_name = null;
        $local_score_pronos = null;
        $visitor_score_pronos = null;
        $date_debut_match = null;
        $heure_debut_match = null;
        $activate_fields = true;

        $match_id_tmp = $app['session']->get('tmp_message');

        $id_match = $match_id_tmp['match_id'];

        $match = $this->getMatch($tab_matches, $id_match); //Données de session
        if ($match != null){
            $local_name = $match->match_localteam_name;
            $visitor_name = $match->match_visitorteam_name;
            $date_debut_match = $match->match_formatted_date;
            $heure_debut_match = $match->match_time;
        }

        $user = $app['session']->get('user')['user'];
        $nom_user = $user->getNom();

        $db_prono = new DbPronostic();
        $id_user = $db_prono->getIdUser($nom_user);

        if ($id_user != null) { //Si l'utilisateur est  enregistré dans la base
            $match = $db_prono->getMatch($id_user, explode("'", $match_id_tmp['match_id'])[1]);//Données de bdd
            $local_score_pronos  = $match['local_team_score_pronos'];
            $visitor_score_pronos  = $match['visitor_team_score_pronos'];
        }

        $activate_fields = $this->isNotTimeout($date_debut_match, $heure_debut_match);
        var_dump(array(
            'local_name' =>  $local_name,
            'visitor_name' => $visitor_name,
            'local_pronos' => $local_score_pronos,
            'visitor_pronos' => $visitor_score_pronos,
            'activate_fields' => $activate_fields,
            'heure_debut' => $heure_debut_match,
            'date_debut' => $date_debut_match
        ));

        return $app['twig']->render('pronostic.twig', array(
                                                            'local_name' =>  $local_name,
                                                            'visitor_name' => $visitor_name,
                                                            'local_pronos' => $local_score_pronos,
                                                            'visitor_pronos' => $visitor_score_pronos,
                                                            'activate_fields' => $activate_fields,
                                                            'heure_debut' => $heure_debut_match,
                                                            'date_debut' => $date_debut_match
                                                            ));
    }

    /**
     * Calcule tout les points de chaque match et le total des points.
     */
    public function dashboardResult (Application $app)
    {
        return $app['twig']->render('dashboardResult.twig');
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
        $prono->match("/validerPronos", __CLASS__.'::validerPronos');
        $prono->match("/resultat", __CLASS__.'::dashboardResult');
        return $prono;
    }

    /**
     * Permet d'extraire l'objet correspondant à l'id d'un match.
     * @param array $tab_match tableau des matchs
     * @param $match_id identifiant du match recherché
     * @return bool retourne false si l'id n'est pas dans le tableau des matchs. Sinon le match trouvé.
     */
    private function getMatch (array $tab_match, $match_id)
    {
        $mon_match = null;

        foreach ($tab_match as $match){
            if ($match_id === ("'".$match->match_id."'")){
                return $mon_match = $match;
                break;
            }

        }
        return $mon_match;
    }

    public function validerPronos(Application $app)
    {
        //Vérifier les données saisies par l'user'
        //Rentrer le nom d'utilisateur dans la bdd
        //Rentrer le pronostic de l'user dans la bdd

        return $app->redirect('/silex_pronostic/web/index.php/MatchController');
    }


    /**
     * Permet de savoir si la date actuel n'a pas encore dépassé le temps oassé en paramêtre.
     *
     * @param string $date_debut_match date. format :  'jj.mm.yyyy' .
     * @param string $heure_debut_match heure sous format 'Heure:min'
     * @param bool|true $avance true si vous voulez soustraire un décalage au temps
     * courant sinon à false pour ajouter un décalage au temps courant.
     * Valeur a true par défaut.
     * @param string $decalage permet de préciser le décalage sur le temps courant.
     * @return bool true si le temps passé en paramètre n'a pas été dépassé. Sinon retourn false.
     */
    public static function isNotTimeout($date_debut_match, $heure_debut_match, $avance = true, $decalage = 'PT1H')
    {
        $date_time_match = new \DateTime($date_debut_match ." ". $heure_debut_match);
        $date_time_courante = new  \DateTime(date('d.m.Y H:i'));

        if ($avance) {
            $decal_date = $date_time_courante->sub(new \DateInterval($decalage));
        } else {
            $decal_date = $date_time_courante->add(new \DateInterval($decalage));
        }

        $date_invert = $date_time_match->diff($decal_date);

        if ($date_invert->invert == 0) {
             return false;
        }

        return true;
    }
}