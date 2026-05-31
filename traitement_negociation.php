<?php
session_start();

if (!isset($_SESSION['utilisateur_id']) || !isset($_GET['action']) || !isset($_GET['id'])) {
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

$vendedor_id = $_SESSION['utilisateur_id'];
$nego_id = intval($_GET['id']);
$action = $_GET['action'];

// Sécurité : On vérifie que la négociation concerne bien un produit appartenant au vendeur connecté
$verif = $pdo->prepare("SELECT n.* FROM negotiations n INNER JOIN produits p ON n.produit_id = p.id WHERE n.id = ? AND p.utilisateur_id = ?");
$verif->execute([$nego_id, $vendedor_id]);
$nego = $verif->fetch();

if ($nego) {
    $nouveau_statut = ($action === 'accepter') ? 'accepte' : 'refuse';
    
    // Mise à jour du statut de la proposition
    $update = $pdo->prepare("UPDATE negotiations SET statut = ? WHERE id = ?");
    $update->execute([$nouveau_statut, $nego_id]);
}

header("Location: notification.php");
exit();