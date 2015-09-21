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
     * Permet de récuperer un utilisateur
     * @param $nom_user
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIdUser ($nom_user)
    {
        $sql = "SELECT id
                FROM users
                WHERE nom = :pseudo";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue("pseudo", $nom_user);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getMatch ($id_user, $id_match)
    {
        $sql = "SELECT id
                FROM matchs
                WHERE user_id = :id_user
                AND match_id = :match_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id_user', $id_user);
        $stmt->bindValue('match_id', $id_match);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}