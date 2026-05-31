<?php
// Démarrage de la session pour l'utilisateur connecté
session_start();

// CONNEXION MYSQL
$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion.");
}

// ID de l'utilisateur connecté (Utilise ta variable de session, ici 1 par défaut pour le test)
$utilisateur_id = $_SESSION['utilisateur_id'] ?? null;

// ==========================================
// LOGIQUE D'AJOUT AUX FAVORIS
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'add_favoris' && isset($_GET['produit_id'])) {
    $produit_id = intval($_GET['produit_id']);
    
    if ($utilisateur_id) {
        // On vérifie si ce produit n'est pas déjà dans les favoris de l'utilisateur
        $verif = $pdo->prepare("SELECT id FROM favoris WHERE utilisateur_id = ? AND produit_id = ?");
        $verif->execute([$utilisateur_id, $produit_id]);
        
        if ($verif->rowCount() == 0) {
            // Insertion du favori
            $insert = $pdo->prepare("INSERT INTO favoris (utilisateur_id, produit_id) VALUES (?, ?)");
            $insert->execute([$utilisateur_id, $produit_id]);
        }
        
        // Redirection propre pour vider l'URL de l'action
        header("Location: catalogue.php");
        exit;
    }
}

// INITIALISATION DES VARIABLES POUR LE HTML
$recherche = $_GET["recherche"] ?? "";
$prix_min = $_GET["prix_min"] ?? "";
$prix_max = $_GET["prix_max"] ?? "";
$categories = $_GET["categorie"] ?? [];
$etats = $_GET["etat"] ?? [];
$type_vente = $_GET["type_vente"] ?? [];

// REQUETE DE BASE
$sql = "SELECT * FROM produits WHERE 1";
$parametres = [];

if (!empty($recherche)) {
    $sql .= " AND nom LIKE ? ";
    $parametres[] = "%" . $recherche . "%";
}
if (!empty($categories) && is_array($categories)) {
    $placeholders = implode(',', array_fill(0, count($categories), '?'));
    $sql .= " AND categorie IN ($placeholders) ";
    foreach ($categories as $categorie) { $parametres[] = $categorie; }
}
if (!empty($etats) && is_array($etats)) {
    $placeholders = implode(',', array_fill(0, count($etats), '?'));
    $sql .= " AND etat IN ($placeholders) ";
    foreach ($etats as $etat) { $parametres[] = $etat; }
}
if (!empty($type_vente) && is_array($type_vente)) {
    $placeholders = implode(',', array_fill(0, count($type_vente), '?'));
    $sql .= " AND type_vente IN ($placeholders) ";
    foreach ($type_vente as $type) { $parametres[] = $type; }
}
if (!empty($prix_min)) {
    $sql .= " AND prix >= ? ";
    $parametres[] = $prix_min;
}
if (!empty($prix_max)) {
    $sql .= " AND prix <= ? ";
    $parametres[] = $prix_max;
}

$sql .= " ORDER BY date_publication DESC ";

$requete = $pdo->prepare($sql);
$requete->execute($parametres);
$produits = $requete->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catalogue - Mercato Nova</title>
<style>
*{ margin:0; padding:0; box-sizing:border-box; font-family:Arial, Helvetica, sans-serif; }
body{ background-color:#f8fafc; color:#0f172a; }
nav{ display:flex; justify-content:space-between; align-items:center; padding:20px 60px; background-color:#0f172a; border-bottom:1px solid #1e293b; }
.logo{ font-size:30px; font-weight:bold; color:#38bdf8; }
nav ul{ display:flex; list-style:none; gap:30px; }
nav ul li a{ text-decoration:none; color:white; transition:0.3s; font-size:17px; }
nav ul li a:hover{ color:#38bdf8; }
.top-bar{ display:flex; justify-content:space-between; align-items:center; padding:30px 60px; background-color:white; border-bottom:1px solid #e2e8f0; }
.search-box{ width:65%; display:flex; gap:10px; }
.search-box input{ width:100%; padding:15px; border-radius:10px; border:1px solid #cbd5e1; font-size:16px; }
.search-btn{ padding:15px 25px; background-color:#0f172a; color:white; border:none; border-radius:10px; cursor:pointer; transition:0.3s; }
.search-btn:hover{ background-color:#1e293b; }
.icons{ display:flex; gap:20px; font-size:28px; }
.icon-link{ text-decoration:none; color:#0f172a; font-size:18px; font-weight:bold; transition:0.3s; }
.icon-link:hover{ color:#0284c7; }
.catalogue-container{ display:flex; padding:40px 60px; gap:40px; }
.filters{ width:260px; background-color:white; padding:25px; border-radius:15px; height:fit-content; box-shadow:0 3px 10px rgba(0,0,0,0.08); }
.filters h2{ margin-bottom:25px; }
.filter-group{ margin-bottom:30px; }
.filter-group h3{ margin-bottom:15px; }
.filter-group label{ display:block; margin-bottom:10px; cursor:pointer; }
.filter-section{ margin-top:35px; margin-bottom:50px; }
.price-filter{ display:flex; flex-direction:column; gap:12px; }
.price-filter input{ padding:12px; border:1px solid #cbd5e1; border-radius:10px; }
.price-btn{ padding:12px; border:none; border-radius:10px; background:#0f172a; color:white; font-weight:bold; cursor:pointer; }
.products{ flex:1; }
.products-title{ margin-bottom:30px; font-size:35px; }
.product-grid{ display:grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:30px; }
.product-card{ background:white; border-radius:15px; overflow:hidden; box-shadow:0 3px 10px rgba(0,0,0,0.08); transition:0.3s; }
.product-card:hover{ transform:translateY(-5px); }
.product-card img{ width:100%; height:220px; object-fit:cover; }
.product-info{ padding:20px; }
.product-info h3{ margin-bottom:10px; }
.price{ color:#0284c7; font-size:22px; font-weight:bold; margin-bottom:20px; }
.product-buttons{ display:flex; gap:10px; }
.product-buttons a{ flex:1; text-decoration: none; }
.btn{ padding:12px; border:none; border-radius:10px; cursor:pointer; font-weight:bold; width: 100%; text-align: center;}
.btn-view{ background:#38bdf8; color:white; display: block; height: 55px;}
.btn-view:hover{ background:#0ea5e9; }
.btn-fav{ background:#e2e8f0; color:red; font-size:18px; display: flex; align-items: center; justify-content: center; height: 55px;}
.btn-fav:hover{ background:#cbd5e1; }
footer{ background:#0f172a; text-align:center; padding:25px; color:white; margin-top:50px; }
@media(max-width:900px){ .catalogue-container{ flex-direction:column; } .filters{ width:100%; } .top-bar{ flex-direction:column; gap:20px; } .search-box{ width:100%; } }
@media(max-width:768px){ nav{ flex-direction:column; gap:20px; } nav ul{ flex-wrap:wrap; justify-content:center; } }
</style>
</head>
<body>

<nav>
    <div class="logo">Mercato Nova</div>
    <ul>
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="catalogue.php">Catalogue</a></li>
        <li><a href="encheres.php">Enchères</a></li>
        <li><a href="mes_annonces.php">Mes annonces</a></li>
        <?php if (isset($_SESSION['nom_utilisateur'])): ?>
                <li style="color: #38bdf8; font-weight: bold; font-size: 17px; display: flex; align-items: center; gap: 8px;">
                    👤 <?= htmlspecialchars($_SESSION['nom_utilisateur']); ?>
                    <a href="deconnexion.php" style="color: #ef4444; font-size: 13px; text-decoration: none;" onclick="return confirm('Voulez-vous vous déconnecter ?');">(Déconnexion)</a>
                </li>
            <?php else: ?>
                <li><a href="connexion.html">Connexion</a></li>
            <?php endif; ?>
    </ul>
</nav>

<section class="top-bar">
    <form class="search-box" method="GET" action="catalogue.php">
        <input type="text" name="recherche" placeholder="Rechercher un produit..." value="<?= htmlspecialchars($recherche) ?>">
        <button class="search-btn">Rechercher</button>
    </form>
    <div class="icons">
        <a href="favoris.php" class="icon-link">❤ Favoris</a>
        <a href="panier.php" class="icon-link">🛒 Panier</a>
        <a href="vendre.php" class="icon-link">➕ Vendre</a>
    </div>
</section>

<section class="catalogue-container">

    <aside class="filters">
        <form method="GET" action="catalogue.php">
            <h2>Filtres</h2>
            <div class="filter-group">
                <h3>Catégories</h3>
                <label><input type="checkbox" name="categorie[]" value="Gaming" <?= in_array("Gaming", $categories) ? "checked" : "" ?>> Gaming</label>
                <label><input type="checkbox" name="categorie[]" value="Smartphones" <?= in_array("Smartphones", $categories) ? "checked" : "" ?>> Smartphones</label>
                <label><input type="checkbox" name="categorie[]" value="Informatique" <?= in_array("Informatique", $categories) ? "checked" : "" ?>> Informatique</label>
                <label><input type="checkbox" name="categorie[]" value="Audio" <?= in_array("Audio", $categories) ? "checked" : "" ?>> Audio</label>
            </div>
            
            <div class="filter-group">
                <h3>État</h3>
                <label><input type="checkbox" name="etat[]" value="Neuf" <?= in_array('Neuf', $etats) ? 'checked' : '' ?>> Neuf</label>
                <label><input type="checkbox" name="etat[]" value="Très bon état" <?= in_array('Très bon état', $etats) ? 'checked' : '' ?>> Très bon état</label>
                <label><input type="checkbox" name="etat[]" value="Bon état" <?= in_array('Bon état', $etats) ? 'checked' : '' ?>> Bon état</label>
                <label><input type="checkbox" name="etat[]" value="Occasion" <?= in_array('Occasion', $etats) ? 'checked' : '' ?>> Occasion</label>
            </div>

            <div class="filter-section">
                <h3>Prix personnalisé</h3>
                <div class="price-filter">
                    <input type="number" name="prix_min" placeholder="Min €" value="<?= htmlspecialchars($prix_min) ?>">
                    <input type="number" name="prix_max" placeholder="Max €" value="<?= htmlspecialchars($prix_max) ?>">
                </div>
            </div>

            <div class="filter-group">
                <h3>Type de vente</h3>
                <label><input type="checkbox" name="type_vente[]" value="Achat immédiat" <?= in_array("Achat immédiat", $type_vente) ? "checked" : "" ?>> Achat immédiat</label>
                <label><input type="checkbox" name="type_vente[]" value="Enchères" <?= in_array("Enchères", $type_vente) ? "checked" : "" ?>> Enchères</label>
                <label><input type="checkbox" name="type_vente[]" value="Négociation" <?= in_array("Négociation", $type_vente) ? "checked" : "" ?>> Négociation</label>
            </div>

            <button class="price-btn">Appliquer les filtres</button>
        </form>
    </aside>

    <div class="products">
        <h1 class="products-title">Catalogue des produits</h1>
        <div class="product-grid">
            <?php foreach($produits as $produit){ ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
                    <div class="product-info">
                        <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                        <p class="price"><?= htmlspecialchars($produit['prix']) ?>€</p>
                        <div class="product-buttons">
                            <a href="produit.php?id=<?= urlencode($produit['id']) ?>">
                                <button class="btn btn-view">Voir</button>
                            </a>
                            <a href="catalogue.php?action=add_favoris&produit_id=<?= $produit['id'] ?>">
                                <button class="btn btn-fav">❤️</button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</section>

<footer>
    <p>© 2026 Mercato Nova - Tous droits réservés</p>
</footer>

</body>
</html>
