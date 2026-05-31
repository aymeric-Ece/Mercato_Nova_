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
    die("Erreur connexion base de données.");
}

// ID de l'utilisateur connecté (Lier à votre session, de test = 1)
$utilisateur_id = $_SESSION['utilisateur_id'] ?? null;

// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if (!$utilisateur_id) {
    header("Location: connexion.html");
    exit();
}

$message = "";

// ==========================================
// ACTION : SUPPRIMER UNE ANNONCE
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_annonce_a_supprimer = intval($_GET['id']);
    
    try {
        // Sécurité : Vérifie que le produit appartient bien à l'utilisateur connecté avant de supprimer
        $suppression = $pdo->prepare("DELETE FROM produits WHERE id = ? AND utilisateur_id = ?");
        $suppression->execute([$id_annonce_a_supprimer, $utilisateur_id]);
        
        $message = "L'annonce a été supprimée avec succès.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression de l'annonce.";
    }
}

// ==========================================
// RECUPERATION DES ANNONCES DE L'UTILISATEUR AVEC LES NÉGOCIATIONS
// ==========================================
try {
    $requete = $pdo->prepare("
        SELECT p.*, 
               n.montant_propose AS prix_negocie, 
               n.statut AS statut_nego
        FROM produits p
        LEFT JOIN negotiations n ON p.id = n.produit_id 
             AND n.id = (SELECT MAX(id) FROM negotiations WHERE produit_id = p.id)
        WHERE p.utilisateur_id = ? 
        ORDER BY p.date_publication DESC
    ");
    $requete->execute([$utilisateur_id]);
    $mes_annonces = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération de vos annonces.");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes annonces - Mercato Nova</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f8fafc;
            color:#0f172a;
        }

        /* HEADER */
        nav{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 60px;
            background:#0f172a;
        }

        .logo{
            font-size:30px;
            font-weight:bold;
            color:#38bdf8;
        }

        nav ul{
            display:flex;
            list-style:none;
            gap:30px;
        }

        nav ul li a{
            text-decoration:none;
            color:white;
            transition:0.3s;
        }

        nav ul li a:hover{
            color:#38bdf8;
        }

        /* PAGE TITLE */
        .page-title{
            padding:60px 60px 20px;
        }

        .page-title h1{
            font-size:48px;
            margin-bottom:10px;
        }

        .page-title p{
            color:#64748b;
            font-size:18px;
        }

        /* TOP ACTIONS */
        .top-actions{
            padding:0 60px 30px;
            display:flex;
            justify-content:flex-end;
        }

        .sell-btn{
            background:#38bdf8;
            color:white;
            text-decoration:none;
            padding:15px 25px;
            border-radius:12px;
            font-weight:bold;
            transition:0.3s;
        }

        .sell-btn:hover{
            background:#0ea5e9;
        }

        /* ANNOUNCEMENTS */
        .annonces-container{
            padding:20px 60px 80px;
            display:flex;
            flex-direction:column;
            gap:30px;
        }

        .annonce-card{
            background:white;
            border-radius:20px;
            padding:25px;
            display:flex;
            gap:25px;
            align-items:center;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
            transition:0.3s;
        }

        .annonce-card:hover{
            transform:translateY(-5px);
        }

        .annonce-card img{
            width:240px;
            height:180px;
            object-fit:cover;
            border-radius:15px;
        }

        .annonce-info{
            flex:1;
        }

        .annonce-info h2{
            margin-bottom:12px;
        }

        .annonce-info p{
            color:#64748b;
            line-height:1.6;
            margin-bottom:15px;
        }

        .price{
            font-size:30px;
            font-weight:bold;
            color:#0284c7;
            margin-bottom:15px;
        }

        .status{
            display:inline-block;
            background:#dcfce7;
            color:#166534;
            padding:8px 15px;
            border-radius:20px;
            font-size:14px;
            font-weight:bold;
        }

        /* ALERT MESSAGE */
        .alert {
            margin: 0 60px 20px;
            padding: 15px;
            background-color: #fef08a;
            color: #854d0e;
            border: 1px solid #fde047;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        /* BUTTONS */
        .actions{
            display:flex;
            flex-direction:column;
            gap:15px;
        }

        .btn{
            display: inline-block;
            text-align: center;
            text-decoration: none;
            padding:14px 20px;
            border:none;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
            min-width:200px;
        }

        .btn-view{
            background:#0f172a;
            color:white;
        }

        .btn-view:hover{
            background:#1e293b;
        }

        .btn-delete{
            background:#ef4444;
            color:white;
        }

        .btn-delete:hover{
            background:#dc2626;
        }

        /* FOOTER */
        footer{
            background:#0f172a;
            color:white;
            text-align:center;
            padding:25px;
        }

        /* RESPONSIVE */
        @media(max-width:950px){
            .annonce-card{
                flex-direction:column;
                text-align:center;
            }
            .annonce-card img{
                width:100%;
                height:250px;
            }
            .actions{
                width:100%;
            }
            .btn{
                width:100%;
            }
        }

        @media(max-width:768px){
            nav{
                flex-direction:column;
                gap:20px;
            }
            nav ul{
                flex-wrap:wrap;
                justify-content:center;
            }
            .page-title,
            .top-actions,
            .annonces-container, .alert{
                padding-left:25px;
                padding-right:25px;
                margin-left: 25px;
                margin-right: 25px;
            }
            .page-title h1{
                font-size:38px;
            }
        }
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

    <section class="page-title">
        <h1>Mes annonces 📦</h1>
        <p>Gérez tous les produits que vous avez mis en vente sur Mercato Nova.</p>
    </section>

    <div class="top-actions">
        <a href="vendre.php" class="sell-btn">➕ Ajouter une annonce</a>
    </div>

    <?php if(!empty($message)): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <section class="annonces-container">
        <?php if(empty($mes_annonces)): ?>
            <div class="empty-state">
                <h2>Vous n'avez publié aucune annonce pour le moment.</h2>
            </div>
        <?php else: ?>
            <?php foreach($mes_annonces as $annonce): ?>
                <div class="annonce-card">
                    <img src="<?= htmlspecialchars($annonce['image'] ?? 'uploads/default.jpg') ?>" alt="<?= htmlspecialchars($annonce['nom']) ?>">

                    <div class="annonce-info">
                        <h2><?= htmlspecialchars($annonce['nom']) ?></h2>
                        <p><?= nl2br(htmlspecialchars($annonce['description'])) ?></p>
                        <div class="price">
    <?= number_format($annonce['prix'], 0, ',', ' ') ?>€
    
    <?php if (!empty($annonce['prix_negocie'])): ?>
        <div style="font-size: 16px; color: #f59e0b; margin-top: 5px;">
            <?php if ($annonce['statut_nego'] === 'en_attente'): ?>
                ⏳ Offre proposée : <strong><?= number_format($annonce['prix_negocie'], 0, ',', ' ') ?>€</strong>
            <?php elseif ($annonce['statut_nego'] === 'accepte'): ?>
                🤝 Prix négocié accepté : <strong style="color: #10b981;"><?= number_format($annonce['prix_negocie'], 0, ',', ' ') ?>€</strong>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
                        <div class="status">
                            <?= htmlspecialchars($annonce['statut'] ?? '✅ En ligne') ?>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="modifier.php?id=<?= $annonce['id'] ?>" class="btn btn-view">
                            ⚙ Gérer l'annonce
                        </a>

                        <a href="mes_annonces.php?action=delete&id=<?= $annonce['id'] ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette annonce ?');">
                            ❌ Supprimer
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <footer>
        <p>© 2026 Mercato Nova - Tous droits réservés</p>
    </footer>

</body>
</html>
