<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20/09/2015
 * Time: 11:26
 */

namespace App\Models;


class User
{
    private $nom;

    public function __construct($nom){
            $this->nom = $nom;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
}