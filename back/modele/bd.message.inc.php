<?php
   
function getMessages() {
    $resultat = array();
    try {
        $cnx = connexionPDO("");
        $req = $cnx->prepare("select * from contact");
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getUnMessage($id) {
    $resultat = array();
    try {
        $cnx = connexionPDO("");
        $req = $cnx->prepare("select * from contact where id = :id");
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getReponse($id) {
    $resultat = array();
    try {
        $cnx = connexionPDO("");
        $req = $cnx->prepare("select * from reponse_contact where idcontact = :id");
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function traiterMessage($id, $commentaire){
    $resultat = false;
    try {
        $cnx = connexionPDO("");
        $req = $cnx->prepare('UPDATE contact SET traite = 1, commentaire = :commentaire, datetraitement = curdate() WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        $resultat = $req->execute();
        if ($resultat){
            setAccesDb("message", "update", $id, $_SESSION['mail']);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function supprMessage($id){
    $resultat = false;
    try {
        $cnx = connexionPDO("");
        $req = $cnx->prepare('DELETE FROM contact WHERE id = :id ');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $resultat = $req->execute();
        if ($resultat){
            setAccesDb("message", "delete", $id, $_SESSION['mail']);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

?>