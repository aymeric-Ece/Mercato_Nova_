<?php
session_start();

// Supprime toutes les variables de session
$_SESSION = array();

// Détruit la session
session_destroy();

// Redirige vers la page de connexion ou le catalogue
header("Location: catalogue.php");
exit();
