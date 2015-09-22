<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 21/09/2015
 * Time: 17:45
 */

namespace App\Models;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class DbPronostic
{
    private $config;
    private $conn;

    function __construct ()
    {
        $this->config = new Configuration();
        $connectionParams = array(
             'dbname' => 'befoot',
             'user' => 'root',
             'password' => '',
             'host' => 'localhost',
             'driver' => 'pdo_mysql',
        );
        $this->conn = DriverManager::getConnection($connectionParams, $this->config);

    }


    /**
     * Permet de récupérer l'id d'un utilisateur.
     * @param $nom_user Pseudo de l'utilisateur.
     * @return null Renvoie null si l'utilisateur n'existe pas sinon renvoie l'id.
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIdUser ($nom_user)
    {//Récuperer l'exception !!'
        $sql = "SELECT id
                FROM users
                WHERE nom = :pseudo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("pseudo", $nom_user);
        $stmt->execute();
        $reponse = $stmt->fetchAll();
        $taille = sizeof($reponse);
        if ($taille != 0) {
            return $reponse[0]['id'];
        }
        return null;
    }

    /**
     * Permet de récupérer le pronostic d'un match de l'utilisateur.
     * @param $id_user l'identifiant d'un utilisateur.
     * @param $id_match l'identifiant d'un match .
     * @return null renvoie null si le pronostic est inexistant Sinon renvoie un tablaeu de données.
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getMatch ($id_user, $id_match)
    {//Récuperer l'exception !!'
        $sql = "SELECT *
                FROM matchs
                WHERE user_id = :id_user
                AND match_id = :match_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id_user', $id_user);
        $stmt->bindValue('match_id', $id_match);
        $stmt->execute();

        $reponse = $stmt->fetchAll();
        $taille = sizeof($reponse);
        if ($taille != 0) {
            return $reponse[0];
        }
        return null;
    }


}