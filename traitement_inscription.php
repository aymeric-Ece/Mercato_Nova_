<?php

// CONNEXION MYSQL

$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";
session_start();
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

    header("Location: inscription.php?erreur=connexion");
    exit();

}

// TRAITEMENT FORMULAIRE

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nom_utilisateur = trim(
        htmlspecialchars($_POST["nom_utilisateur"] ?? '')
    );

    $email = trim(
        htmlspecialchars($_POST["email"] ?? '')
    );

    $telephone = trim(
        htmlspecialchars($_POST["telephone"] ?? '')
    );

    $mot_de_passe = $_POST["mot_de_passe"] ?? '';

    $confirmation = $_POST["confirmation_mot_de_passe"] ?? '';

    // CONDITIONS

    if(
        !isset($_POST["confidentialite"]) ||
        !isset($_POST["majeur"])
    ){

        header("Location: inscription.php?erreur_conditions=1&nom_utilisateur=$nom_utilisateur&email=$email&telephone=$telephone");
        exit();

    }

    // MOTS DE PASSE

    if($mot_de_passe != $confirmation){

        header("Location: inscription.php?erreur_mdp=1&nom_utilisateur=$nom_utilisateur&email=$email&telephone=$telephone");
        exit();

    }

    // NOM UTILISATEUR

    $verification_nom = $pdo->prepare("
        SELECT id
        FROM utilisateurs
        WHERE nom_utilisateur = ?
    ");

    $verification_nom->execute([$nom_utilisateur]);

    if($verification_nom->rowCount() > 0){

        header("Location: inscription.php?erreur_nom=1&nom_utilisateur=$nom_utilisateur&email=$email&telephone=$telephone");
        exit();

    }

    // EMAIL

    $verification_email = $pdo->prepare("
        SELECT id
        FROM utilisateurs
        WHERE email = ?
    ");

    $verification_email->execute([$email]);

    if($verification_email->rowCount() > 0){

        header("Location: inscription.php?erreur_email=1&nom_utilisateur=$nom_utilisateur&email=$email&telephone=$telephone");
        exit();

    }

    // TELEPHONE

    $verification_telephone = $pdo->prepare("
        SELECT id
        FROM utilisateurs
        WHERE telephone = ?
    ");

    $verification_telephone->execute([$telephone]);

    if($verification_telephone->rowCount() > 0){

        header("Location: inscription.php?erreur_telephone=1&nom_utilisateur=$nom_utilisateur&email=$email&telephone=$telephone");
        exit();

    }

    // HASH PASSWORD

    $mot_de_passe_hash = password_hash(
        $mot_de_passe,
        PASSWORD_DEFAULT
    );

   // INSERTION MYSQL
    $requete = $pdo->prepare("
        INSERT INTO utilisateurs(
            nom_utilisateur,
            email,
            telephone,
            mot_de_passe
        )
        VALUES(?, ?, ?, ?)
    ");

    $requete->execute([
        $nom_utilisateur,
        $email,
        $telephone,
        $mot_de_passe_hash
    ]);

    // --- AJOUT DE LA CONNEXION AUTOMATIQUE APRÈS INSCRIPTION ---
    $nouvel_id = $pdo->lastInsertId(); // Récupère l'ID créé par MySQL
    
    $_SESSION["id"] = $nouvel_id;
    $_SESSION["utilisateur_id"] = $nouvel_id;
    $_SESSION["nom_utilisateur"] = $nom_utilisateur;

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta http-equiv="refresh" content="2;url=accueil.php">

<title>Inscription réussie</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f8fafc;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.success-box{
    background:white;
    padding:50px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    text-align:center;
    width:500px;
}

h1{
    color:#16a34a;
    margin-bottom:20px;
}

p{
    color:#334155;
    font-size:18px;
}

</style>

</head>

<body>

<div class="success-box">

    <h1>
        ✅ Inscription réussie
    </h1>

    <p>
        Nous allons vous rediriger vers l'accueil dans 2 secondes...
    </p>

</div>

</body>

</html>
