<?php
// Démarrage de la session pour suivre l'utilisateur connecté
session_start();

// 1. VERIFICATION DE LA CONNEXION
// Si l'utilisateur n'est pas connecté, redirection immédiate vers connexion.html
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: connexion.html");
    exit();
}

$utilisateur_id = $_SESSION['utilisateur_id'];

// 2. CONNEXION À LA BASE DE DONNÉES MYSQL
$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// 3. RÉCUPÉRATION DES NOTIFICATIONS DE FAVORIS
// Compte combien de personnes ont mis en favoris les articles mis en vente par l'utilisateur connecté
try {
    $sql_favoris = "SELECT p.id AS produit_id, p.nom, p.image, COUNT(f.id) AS nb_favoris 
                    FROM produits p
                    INNER JOIN favoris f ON p.id = f.produit_id
                    WHERE p.utilisateur_id = ?
                    GROUP BY p.id";
    $stmt_favoris = $pdo->prepare($sql_favoris);
    $stmt_favoris->execute([$utilisateur_id]);
    $notifs_favoris = $stmt_favoris->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $notifs_favoris = [];
}

// 4. RÉCUPÉRATION DES PROPOSITIONS D'OFFRES / ENCHÈRES
try {
    $sql_offres = "SELECT o.montant, o.date_offre, u.nom_utilisateur AS acheteur_nom, e.nom AS enchere_nom
                   FROM offres o
                   INNER JOIN utilisateurs u ON o.acheteur_id = u.id
                   INNER JOIN encheres e ON o.enchere_id = e.id
                   WHERE e.vendeur_id = ?
                   ORDER BY o.date_offre DESC";
    $stmt_offres = $pdo->prepare($sql_offres);
    $stmt_offres->execute([$utilisateur_id]);
    $notifs_offres = $stmt_offres->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $notifs_offres = [];
}
// 5. RÉCUPÉRATION DES PROPOSITIONS DE NÉGOCIATIONS (PRIX INFÉRIEUR)
try {
    $sql_negos = "SELECT n.id AS nego_id, n.montant_propose, n.statut, n.date_proposition, 
                         u.nom_utilisateur AS acheteur_nom, p.nom AS produit_nom, p.id AS produit_id
                  FROM negotiations n
                  INNER JOIN utilisateurs u ON n.acheteur_id = u.id
                  INNER JOIN produits p ON n.produit_id = p.id
                  WHERE p.utilisateur_id = ?
                  ORDER BY n.date_proposition DESC";
    $stmt_negos = $pdo->prepare($sql_negos);
    $stmt_negos->execute([$utilisateur_id]); // Corrigé avec la flèche (->)
    $notifs_negos = $stmt_negos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $notifs_negos = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Mercato Nova</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background-color: #f8fafc;
            color: #0f172a;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            background-color: #0f172a;
            border-bottom: 1px solid #1e293b;
        }
        .logo {
            font-size: 30px;
            font-weight: bold;
            color: #38bdf8;
            text-decoration: none;
        }
        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }
        nav ul li a {
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }
        nav ul li a:hover {
            color: #38bdf8;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        h1 {
            margin-bottom: 30px;
            color: #0f172a;
            font-size: 28px;
        }
        .notif-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 20px;
            color: #1e293b;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
        .notif-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #38bdf8;
            border-radius: 10px;
            margin-bottom: 15px;
            background: #f8fafc;
        }
        .notif-content {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .notif-text {
            font-size: 15px;
            color: #334155;
        }
        .notif-date {
            font-size: 12px;
            color: #94a3b8;
        }
        .badge-fav {
            background: #e0f2fe;
            color: #0369a1;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-offer {
            background: #d1fae5;
            color: #065f46;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .empty-msg {
            color: #64748b;
            font-style: italic;
            text-align: center;
            padding: 20px 0;
        }
        footer {
            background-color: #0f172a;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <nav>
        <a href="Accueil.php" class="logo">Mercato Nova</a>
        <ul>
            <li><a href="Accueil.php">Accueil</a></li>
            <li><a href="Catalogue.php">Catalogue</a></li>
            <li><a href="vendre.php">Vendre</a></li>
            <li><a href="encheres.php">Enchères</a></li>
            <li><a href="notification.php">🔔 Notifications</a></li>
            <li><a href="mes_annonces.php">Mes Annonces</a></li>
			<?php if (isset($_SESSION['nom_utilisateur'])): ?>
                <!-- Affiche le nom de l'utilisateur connecté et un lien de déconnexion -->
                <li style="color: #38bdf8; font-weight: bold; font-size: 17px; display: flex; align-items: center; gap: 8px;">
                    👤 <?= htmlspecialchars($_SESSION['nom_utilisateur']); ?>
                    <a href="deconnexion.php" style="color: #ef4444; font-size: 13px; text-decoration: none;" onclick="return confirm('Voulez-vous vous déconnecter ?');">(Déconnexion)</a>
                </li>
            <?php else: ?>
                <!-- Lien classique si visiteur anonyme -->
                <li><a href="connexion.html">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <section class="container">
        <h1>Vos Notifications</h1>

        <div class="notif-section">
            <h2 class="section-title">❤️ Intérêt pour vos produits</h2>
            <?php if (!empty($notifs_favoris)): ?>
                <?php foreach ($notifs_favoris as $fav): ?>
                    <div class="notif-card">
                        <div class="notif-content">
                            <p class="notif-text">
                                Votre produit <strong><?= htmlspecialchars($fav['nom']) ?></strong> a été ajouté <strong><?= $fav['nb_favoris'] ?></strong> fois aux favoris d'autres utilisateurs !
                            </p>
                        </div>
                        <span class="badge-fav">Populaire</span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">Aucun de vos articles n'a encore été mis en favoris.</p>
            <?php endif; ?>
        </div>

        <div class="notif-section">
            <h2 class="section-title">💰 Propositions des acheteurs</h2>
            <?php if (!empty($notifs_offres)): ?>
                <?php foreach ($notifs_offres as $offre): ?>
                    <div class="notif-card" style="border-left-color: #10b981;">
                        <div class="notif-content">
                            <p class="notif-text">
                                L'utilisateur <strong><?= htmlspecialchars($offre['acheteur_nom']) ?></strong> a fait une proposition d'achat de <strong><?= number_format($offre['montant'], 2, ',', ' ') ?> €</strong> sur votre enchère <strong><?= htmlspecialchars($offre['enchere_nom']) ?></strong>.
                            </p>
                            <div class="notif-date">Le <?= date('d/m/Y à H:i', strtotime($offre['date_offre'])) ?></div>
                        </div>
                        <span class="badge-offer">Nouvelle offre</span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">Aucune proposition d'achat ou mise n'a été soumise sur vos ventes pour le moment.</p>
            <?php endif; ?>
        </div>
		<div class="notif-section">
            <h2 class="section-title">🤝 Négociations en cours</h2>
            <?php if (!empty($notifs_negos)): ?>
                <?php foreach ($notifs_negos as $nego): ?>
                    <div class="notif-card" style="border-left-color: #f59e0b;">
                        <div class="notif-content">
                            <p class="notif-text">
                                <strong><?= htmlspecialchars($nego['acheteur_nom']) ?></strong> propose un prix de 
                                <strong><?= number_format($nego['montant_propose'], 0, ',', ' ') ?> €</strong> 
                                pour votre produit <strong><?= htmlspecialchars($nego['produit_nom']) ?></strong>.
                            </p>
                            <div class="notif-date">
                                Statut actuel : <strong><?= htmlspecialchars($nego['statut']) ?></strong> – Le <?= date('d/m/Y à H:i', strtotime($nego['date_proposition'])) ?>
                            </div>
                        </div>
                        
                        <?php if ($nego['statut'] === 'en_attente'): ?>
                            <div style="display: flex; gap: 10px;">
                                <a href="traitement_negociation.php?action=accepter&id=<?= $nego['nego_id'] ?>" class="badge-offer" style="background: #10b981; color: white; text-decoration: none;">Accepter</a>
<a href="traitement_negociation.php?action=refuser&id=<?= $nego['nego_id'] ?>" class="badge-fav" style="background: #ef4444; color: white; text-decoration: none;">Refuser</a>
                            </div>
                        <?php else: ?>
                            <span class="badge-offer" style="background: #e2e8f0; color: #475569;">Traité</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">Aucune proposition de négociation de prix reçue pour le moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>© 2026 Mercato Nova - Tous droits réservés</p>
    </footer>

</body>
</html>
