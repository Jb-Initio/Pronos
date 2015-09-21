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
        $tab_matches = $app['session']->get('matches');
        $local_name = null;
        $visitor_name = null;
        $local_score_pronos = null;
        $visitor_score_pronos = null;
        $activate_fields = true;

        $match_id_tmp = $app['session']->get('tmp_message');

        $id_match = $match_id_tmp['match_id'];

        //var_dump($id_match);
        //var_dump($tab_matches);
        //die();
        $match = $this->getMatch($tab_matches, $id_match);
        var_dump($match);
        die();
        $user = $app['session']->get('user')['user'];
        $nom_user = $user->getNom();

        $db_prono = new DbPronostic();
        $id_user = $db_prono->getIdUser('bobno');

        if (sizeof($id_user) != O) { //Si l'utilisateur n'est pas enregistré dans la base
            //Récupérer le match correspondant à l'utilisateur
            $match = $db_prono->getMatch($id_user, $match_id_tmp);
            //Stocker le nom de l'équipe local ds une var
            //Stocker le nom de l'équipe visiteur ds une var
            //stocker le champs 'local_team_score_pronos' dans une variable
            //Stocker le champs visitor_team_score_pronos dans une variable
        }

        //Vérifier si la date courante a  dépassée la ( date de début de match - 1h )
        if (true) {
            $activate_fields = false;
        }
        die();
        return $app['twig']->render('pronostic.twig', array(
                                                            'local_name' =>  $local_name,
                                                            'visitor_name' => $visitor_name,
                                                            'local_score_pronos' => $local_score_pronos,
                                                            'visitor_score_pronos' => $visitor_score_pronos,
                                                            'activate_fields' => $activate_fields,
                                                           ));
    }

    /**
     * Calcule tout les points de chaque match et le total des points.
     */
    public function dashboardResult ()
    {

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

    /**
     * Permet de récupérer l'objet correspondant à un match.
     * @param array $tab_match tableau des matchs
     * @param $match_id identifiant du match recherché
     * @return bool retourne false si l'id n'est pas dans le tableau des matchs. Sinon le match trouvé.
     */
    private function getMatch (array $tab_match, $match_id)
    {
        $mon_match = null;
        foreach ($tab_match as $match){

            if($match->match_id == $match_id){
                $mon_match = $match;
                var_dump('break actionné');
                break;
            }
            die('fin du foreach');
        }
        return $mon_match;
    }
}