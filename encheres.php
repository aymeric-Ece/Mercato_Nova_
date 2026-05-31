<?php
session_start();

$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion base de données.");
}

$utilisateur_id = $_SESSION['utilisateur_id'] ?? null;
$erreur_enchere = "";
$produit_erreur_id = 0;

// TRAITEMENT D'UNE ENCHÈRE EN POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_encherir'])) {
    $enchere_id = intval($_POST['produit_id']);
    $montant_propose = floatval($_POST['montant_enchere']);
    $produit_erreur_id = $enchere_id;

    // Récupération des données fondamentales de l'enchère
    $req_prod = $pdo->prepare("SELECT prix_depart, date_fin FROM encheres WHERE id = ?");
    $req_prod->execute([$enchere_id]);
    $info_prod = $req_prod->fetch(PDO::FETCH_ASSOC);

    if (!$info_prod) {
        $erreur_enchere = "Cette enchère n'existe pas.";
    } elseif (strtotime($info_prod['date_fin']) < time()) {
        $erreur_enchere = "Désolé, cette enchère est déjà terminée !";
    } else {
        // Obtenir la meilleure offre actuelle
        $req_max = $pdo->prepare("SELECT MAX(montant) AS max_montant FROM offres_encheres WHERE enchere_id = ?");
        $req_max->execute([$enchere_id]);
        $max_offre = $req_max->fetch(PDO::FETCH_ASSOC)['max_montant'];
        
        $mise_actuelle = $max_offre ? floatval($max_offre) : floatval($info_prod['prix_depart']);

        // Application stricte des paliers d'augmentation demandés
        if ($mise_actuelle < 10) {
            $pas_minimum = 0.10;
        } elseif ($mise_actuelle <= 250) {
            $pas_minimum = 1.00;
        } else {
            $pas_minimum = 10.00;
        }

        $seuil_minimal = $mise_actuelle + $pas_minimum;

        if ($montant_propose < $seuil_minimal) {
            $erreur_enchere = "Mettez un nombre plus grand (Minimum attendu : " . number_format($seuil_minimal, 2, ',', ' ') . " €)";
        } else {
            try {
                $ins = $pdo->prepare("INSERT INTO offres_encheres (enchere_id, utilisateur_id, montant) VALUES (?, ?, ?)");
                $ins->execute([$enchere_id, $utilisateur_id, $montant_propose]);
                header("Location: encheres.php");
                exit;
            } catch (PDOException $e) {
                $erreur_enchere = "Erreur lors du traitement de votre offre.";
            }
        }
    }
}

// FILTRAGE ET RECHERCHE
$recherche = $_GET['recherche'] ?? "";
$sql_cond = "";
if (!empty($recherche)) {
    $sql_cond = " WHERE nom LIKE " . $pdo->quote("%".$recherche."%");
}

// Sélection de toutes les enchères dont la date de fin n'est pas dépassée
$req_liste = $pdo->query("SELECT * FROM encheres $sql_cond ORDER BY date_fin ASC");
$liste_encheres = $req_liste->fetchAll(PDO::FETCH_ASSOC);
$nb_actives = count($liste_encheres);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enchères - Mercato Nova</title>
    <style>
        *{ margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body{ background-color: #f8fafc; color: #0f172a; }
        nav{ display: flex; justify-content: space-between; align-items: center; padding: 20px 60px; background-color: #0f172a; }
        .logo{ font-size: 30px; font-weight: bold; color: #38bdf8; }
        nav ul{ display: flex; list-style: none; gap: 30px; }
        nav ul li a{ text-decoration: none; color: white; }
        .hero{ background: linear-gradient(to right, #0f172a, #1e3a8a); color: white; padding: 50px 60px; text-align: center; }
        .top-bar{ display: flex; justify-content: space-between; align-items: center; padding: 30px 60px; background: white; border-bottom: 1px solid #e2e8f0; }
        .search-box{ width: 70%; display: flex; gap: 10px; }
        .search-box input{ width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; }
        .search-btn{ padding: 12px 25px; background: #0f172a; color: white; border: none; border-radius: 10px; cursor: pointer; }
        .auction-info{ font-weight: bold; color: #0284c7; font-size: 18px; }
        .auctions-section{ padding: 60px; }
        .auction-grid{ display: grid; grid-template-columns: repeat(auto-fit, minmax(320px,1fr)); gap: 30px; }
        .auction-card{ background: white; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; flex-direction: column; }
        .auction-card img{ width: 100%; height: 230px; object-fit: cover; }
        .auction-content{ padding: 25px; display: flex; flex-direction: column; flex-grow: 1; }
        .current-price{ font-size: 24px; font-weight: bold; color: #0284c7; margin: 10px 0; }
        .timer{ color: #ef4444; font-weight: bold; font-size: 16px; margin-bottom: 15px; }
        .bid-wrapper { display: flex; flex-direction: column; gap: 5px; }
        .bid-section{ display: flex; gap: 10px; width: 100%; align-items: center; }
        .bid-section input{ height: 48px; flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; }
        .bid-btn{ height: 48px; padding: 0 20px; background: #0f172a; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .view-btn{ height: 48px; padding: 0 15px; background: #38bdf8; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: bold; }
        .error-msg { color: #ef4444; font-size: 13px; font-weight: bold; margin-top: 5px; }
        footer{ background: #0f172a; text-align: center; padding: 25px; color: white; margin-top: 60px; }
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
			<li><a href="notification.php">🔔 Notifications</a></li>
			<?php if (isset($_SESSION['nom_utilisateur'])): ?>
                <li style="color: #38bdf8; font-weight: bold; font-size: 17px; display: flex; align-items: center; gap: 8px;">
                    👤 <?= htmlspecialchars($_SESSION['nom_utilisateur']); ?>
                    <a href="deconnexion.php" style="color: #ef4444; font-size: 13px; text-decoration: none;" onclick="return confirm('Voulez-vous vous déconnecter ?');">(Déconnexion)</a>
                </li>
            <?php else: ?>
                <li><a href="seconnecter.php">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <section class="hero">
        <h1>Enchères en direct 🔥</h1>
        <p>Participez aux meilleures enchères du moment.</p>
    </section>

    <section class="top-bar">
        <form class="search-box" method="GET" action="encheres.php">
            <input type="text" name="recherche" placeholder="Rechercher une enchère..." value="<?= htmlspecialchars($recherche) ?>">
            <button type="submit" class="search-btn">Rechercher</button>
        </form>
        <div class="auction-info">⏳ <?= $nb_actives ?> enchère(s) active(s)</div>
    </section>

    <section class="auctions-section">
        <div class="auction-grid">
            <?php if (empty($liste_encheres)): ?>
                <div style="grid-column: 1/-1; text-align: center; color: #64748b;">Aucune enchère en cours.</div>
            <?php else: ?>
                <?php foreach ($liste_encheres as $enc): 
                    $s_max = $pdo->prepare("SELECT MAX(montant) AS max_m FROM offres_encheres WHERE enchere_id = ?");
                    $s_max->execute([$enc['id']]);
                    $res_max = $s_max->fetch(PDO::FETCH_ASSOC)['max_m'];
                    $prix_courant = $res_max ? floatval($res_max) : floatval($enc['prix_depart']);
                ?>
                    <div class="auction-card">
                        <img src="<?= htmlspecialchars($enc['image'] ?? 'uploads/default.jpg') ?>" alt="image">
                        <div class="auction-content">
                            <h2><?= htmlspecialchars($enc['nom']) ?></h2>
                            <p style="color:#64748b; margin-top:8px; flex-grow:1;"><?= nl2br(htmlspecialchars($enc['description'])) ?></p>
                            
                            <div class="current-price">Mise actuelle : <?= number_format($prix_courant, 2, ',', ' ') ?> €</div>
                            <div class="timer" data-date="<?= $enc['date_fin'] ?>">⏳ Synchronisation...</div>

                            <div class="bid-wrapper">
                                <form class="bid-section" method="POST" action="encheres.php">
                                    <input type="hidden" name="produit_id" value="<?= $enc['id'] ?>">
                                    <input type="number" name="montant_enchere" step="0.01" placeholder="Offre (€)" required>
                                    <button type="submit" name="action_encherir" class="bid-btn">Enchérir</button>
                                    <a href="produit.php?id=<?= $enc['id'] ?>&provenance=enchere" class="view-btn">Voir</a>
                                </form>
                                
                                <?php if ($erreur_enchere !== "" && $produit_erreur_id === intval($enc['id'])): ?>
                                    <div class="error-msg">❌ <?= htmlspecialchars($erreur_enchere) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <footer><p>© 2026 Mercato Nova - Tous droits réservés</p></footer>

    <script>
        function updateTimers() {
            document.querySelectorAll('.timer').forEach(timer => {
                const targetStr = timer.getAttribute('data-date');
                if (!targetStr) return;
                
                // Remplacement compatible Safari/Chrome pour le parsing de date
                const targetDate = new Date(targetStr.replace(/-/g, "/")).getTime();
                const diff = targetDate - new Date().getTime();

                if (diff <= 0) {
                    timer.innerHTML = "⏳ Enchère terminée !";
                    timer.style.color = "#64748b";
                    return;
                }

                const j = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                timer.innerHTML = `⏳ Fin dans : ${j}j ${h}h ${m}min ${s}s`;
            });
        }
        setInterval(updateTimers, 1000);
        window.onload = updateTimers;
    </script>
</body>
</html>
