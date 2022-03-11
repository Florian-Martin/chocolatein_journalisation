<?php

function setConnexion($email){
    $resultat = false;
    $adresseIP = $_SERVER['REMOTE_ADDR'];
    $dateHeureDebut = date('Y-m-d H:i:s');

    try{
        $cnx = connexionPDO("logconnexion");
        $req = $cnx->prepare('INSERT INTO connexion (adresseIP, login, dateHeure)
                              VALUES (:adresseIP, :login, :dateHeure)');
        $req->bindParam(':adresseIP', $adresseIP, PDO::PARAM_STR);
        $req->bindParam(':login', $email, PDO::PARAM_STR);
        $req->bindParam(':dateHeure', $dateHeureDebut, PDO::PARAM_STR);
        $resultat = $req->execute();
    
        $_SESSION['idConnexion'] = $cnx->lastInsertId();
    }
    catch(PDOException $e){
        print("Erreur ! : " . $e->getMessage());
        die();
    }
    return $resultat;
}

function setTentative($email){
    $resultat = false;
    $adresseIP = $_SERVER['REMOTE_ADDR'];
    $dateHeure = date('Y-m-d H:i:s');

    try{
        $cnx = connexionPDO("logconnexion");
        $req = $cnx->prepare('INSERT INTO tentative (adresseIP, login, dateHeure)
                              VALUES (:adresseIP, :login, :dateHeure)');
        $req->bindParam(':adresseIP', $adresseIP, PDO::PARAM_STR);
        $req->bindParam(':login', $email, PDO::PARAM_STR);
        $req->bindParam(':dateHeure', $dateHeure, PDO::PARAM_STR);

        $resultat = $req->execute();

    }
    catch(PDOException $e){
        print("Erreur ! : " . $e->getMessage());
        die();
    }
    return $resultat;
}

function updateConnexion(){
    $resultat = false;
    $dateHeureFin = date('Y-m-d H:i:s');
    $id = $_SESSION['idConnexion'];

    try{
        $cnx = connexionPDO("logconnexion");
        $req = $cnx->prepare('UPDATE connexion
                              SET dateHeureFin = :dateHeureFin
                              WHERE id = :id');
        $req->bindParam('dateHeureFin', $dateHeureFin, PDO::PARAM_STR);
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $resultat = $req->execute();

    }
    catch(PDOException $e){
        print("Erreur ! : " . $e->getMessage());
        die();
    }
    return $resultat;
}

function verifierBanni($login, $adresseIP){
    try{
        $cnx = connexionPDO("logconnexion");
        $req = $cnx->prepare('SELECT count(*) as nb from bannis 
                              WHERE (login = :login or adresseIP = :adresseIP) 
                              AND dateHeureFin > NOW()');
        $req->bindParam(':login', $login, PDO::PARAM_STR);
        $req->bindParam(':adresseIP', $adresseIP, PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        print("Erreur ! : " . $e->getMessage());
        die();
    }
    
    return $resultat['nb'] > 0 ? true : false;
}
?>