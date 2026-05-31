<?php
session_start();

if (!isset($_SESSION['utilisateur_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: connexion.html");
    exit();
}

$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion.");
}

$acheteur_id = $_SESSION['utilisateur_id'];
$produit_id = intval($_POST['produit_id']);
$prix_propose = floatval($_POST['prix_propose']);

// Vérifier que le prix proposé est bien inférieur au prix actuel du produit
$req_prod = $pdo->prepare("SELECT prix FROM produits WHERE id = ?");
$req_prod->execute([$produit_id]);
$prod = $req_prod->fetch();

if ($prod && $prix_propose < $prod['prix']) {
    // Insérer la proposition de négociation
    $ins = $pdo->prepare("INSERT INTO negotiations (produit_id, acheteur_id, montant_propose, statut, date_proposition) VALUES (?, ?, ?, 'en_attente', NOW())");
    $ins->execute([$produit_id, $acheteur_id, $prix_propose]);
    
    header("Location: produit.php?id=" . $produit_id . "&nego=success");
    exit();
} else {
    die("Le prix proposé doit être inférieur au prix initial de l'article.");
}