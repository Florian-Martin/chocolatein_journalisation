<?php

function connexionPDO($mode) {
    $login = "userchoc";
    $mdp = "p@ssCh0c";
    if ($mode == "logconnexion"){
        $bd = "bddchoclog";
    }
    else{
        if ($mode == "logAccesDb"){
            $bd = "choclogaccesbdd";
        }
        else{
            $login = "root";
            $mdp = "";
            $bd = "bddchocsq3";
        }
    }
	$serveur = "127.0.0.1:3307";

    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        print "Erreur de connexion PDO ";
        die();
    }
}

?>
