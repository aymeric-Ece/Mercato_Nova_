<?php

session_start();

// CONNEXION MYSQL

$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try{

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

}catch(PDOException $e){

    die("Erreur connexion base de données.");

}

// FORMULAIRE

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $identifiant = trim(
        htmlspecialchars($_POST["identifiant"] ?? '')
    );

    $mot_de_passe = $_POST["mot_de_passe"] ?? '';

    // RECHERCHE UTILISATEUR

    $requete = $pdo->prepare("

        SELECT *
        FROM utilisateurs

        WHERE
            nom_utilisateur = ?
            OR email = ?
            OR telephone = ?

    ");

    $requete->execute([
        $identifiant,
        $identifiant,
        $identifiant
    ]);

    $utilisateur = $requete->fetch();

    // UTILISATEUR INTROUVABLE

    if(!$utilisateur){

        header(
            "Location: seconnecter.php?erreur_identifiant=1&identifiant=$identifiant"
        );

        exit();

    }

    // VERIFICATION MDP

    if(
        !password_verify(
            $mot_de_passe,
            $utilisateur["mot_de_passe"]
        )
    ){

        header(
            "Location: seconnecter.php?erreur_mdp=1&identifiant=$identifiant"
        );

        exit();

    }

    // SESSION

    $_SESSION["id"] = $utilisateur["id"];

    $_SESSION["nom_utilisateur"] = $utilisateur["nom_utilisateur"];

    // REDIRECTION

    header("Location: accueil.html");

    exit();

}

?>
