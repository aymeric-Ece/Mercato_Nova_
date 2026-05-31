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

// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if (!$utilisateur_id) {
    header("Location: connexion.html");
    exit();
}
$message = "";
$message_type = ""; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $nom = trim($_POST['nom'] ?? '');
    $categorie = $_POST['categorie'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $type_vente = $_POST['type_vente'] ?? '';
    
    if (empty($nom) || empty($categorie) || empty($description) || $prix <= 0 || empty($type_vente)) {
        $message = "Veuillez remplir tous les champs obligatoires.";
        $message_type = "error";
    } else {
        // GESTION DE L'IMAGE
        $chemin_image = "uploads/default.jpg";
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }
            $nom_fichier = $_FILES['image']['name'];
            $extension = strtolower(pathinfo($nom_fichier, PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $nouveau_nom = uniqid('prod_', true) . "." . $extension;
                $destination = "uploads/" . $nouveau_nom;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $chemin_image = $destination;
                }
            }
        }
        
        // INSERTION SELON LE TYPE DE VENTE
        try {
            if ($type_vente === 'Enchères') {
                // Calcul de la date de fin
                $jours = intval($_POST['duree_jours'] ?? 0);
                $heures = intval($_POST['duree_heures'] ?? 0);
                $minutes = intval($_POST['duree_minutes'] ?? 0);
                $secondes = intval($_POST['duree_secondes'] ?? 0);
                
                $interval_str = "+{$jours} days +{$heures} hours +{$minutes} minutes +{$secondes} seconds";
                $date_fin = date('Y-m-d H:i:s', strtotime($interval_str));

                $sql = "INSERT INTO encheres (utilisateur_id, nom, description, categorie, prix_depart, image, date_fin) 
                        VALUES (:utilisateur_id, :nom, :description, :categorie, :prix, :image, :date_fin)";
                $requete = $pdo->prepare($sql);
                $requete->execute([
                    ':utilisateur_id' => $utilisateur_id,
                    ':nom' => $nom,
                    ':description' => $description,
                    ':categorie' => $categorie,
                    ':prix' => $prix,
                    ':image' => $chemin_image,
                    ':date_fin' => $date_fin
                ]);
                $redirect = "encheres.php";
            } else {
                // Mapping des types pour la table produits d'origine
                $type_db = ($type_vente === 'Achat immédiat') ? 'achat' : 'negociation';
                $sql = "INSERT INTO produits (utilisateur_id, nom, description, categorie, prix, image, type_vente) 
                        VALUES (:utilisateur_id, :nom, :description, :categorie, :prix, :image, :type_vente)";
                $requete = $pdo->prepare($sql);
                $requete->execute([
                    ':utilisateur_id' => $utilisateur_id,
                    ':nom' => $nom,
                    ':description' => $description,
                    ':categorie' => $categorie,
                    ':prix' => $prix,
                    ':image' => $chemin_image,
                    ':type_vente' => $type_db
                ]);
                $redirect = "catalogue.php";
            }
            
            $message = "Votre annonce a bien été publiée !";
            $message_type = "success";
            header("Refresh: 2; URL=" . $redirect);
        } catch (PDOException $e) {
            $message = "Erreur lors de la publication : " . $e->getMessage();
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendre un produit - Mercato Nova</title>
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }
        body{ background:#f8fafc; color:#0f172a; }
        nav{ display:flex; justify-content:space-between; align-items:center; padding:20px 60px; background:#0f172a; }
        .logo{ font-size:30px; font-weight:bold; color:#38bdf8; }
        nav ul{ display:flex; list-style:none; gap:30px; }
        nav ul li a{ text-decoration:none; color:white; transition:0.3s; }
        nav ul li a:hover{ color:#38bdf8; }
        .container{ display:flex; flex-direction: column; justify-content:center; align-items:center; padding:60px 20px; }
        .form-box{ background:white; width:700px; padding:50px; border-radius:20px; box-shadow:0 5px 15px rgba(0,0,0,0.08); }
        h1{ text-align:center; margin-bottom:15px; font-size:42px; }
        .subtitle{ text-align:center; color:#64748b; margin-bottom:40px; }
        label{ display:block; margin-bottom:10px; font-weight:bold; margin-top:20px; }
        input, textarea, select{ width:100%; padding:15px; border-radius:10px; border:1px solid #cbd5e1; font-size:16px; background-color: #fff; }
        textarea{ resize:none; height:140px; }
        .price-box, .duration-box{ display:flex; gap:20px; }
        .price-box div, .duration-box div{ flex:1; }
        .alert { width: 700px; padding: 15px; margin-bottom: 20px; border-radius: 10px; font-weight: bold; text-align: center; }
        .alert-success { background-color: #bbf7d0; color: #166534; border: 1px solid #86efac; }
        .alert-error { background-color: #fecaca; color: #991b1b; border: 1px solid #fca5a5; }
        button{ width:100%; padding:18px; margin-top:35px; border:none; border-radius:12px; background:#38bdf8; color:white; font-size:18px; font-weight:bold; cursor:pointer; transition:0.3s; }
        button:hover{ background:#0ea5e9; }
        footer{ background:#0f172a; color:white; text-align:center; padding:25px; margin-top:50px; }
        #bloc-duree { display: none; }
        @media(max-width:768px){ .form-box, .alert{ width: 100%; padding:30px; } .price-box, .duration-box{ flex-direction:column; gap:0; } }
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
                <li><a href="connexion.html">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <section class="container">
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="form-box">
            <h1>Vendre un produit</h1>
            <p class="subtitle">Publiez votre produit sur Mercato Nova en quelques minutes.</p>

            <form action="vendre.php" method="POST" enctype="multipart/form-data">
                <label for="nom">Nom du produit / Enchère</label>
                <input type="text" id="nom" name="nom" required>

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <option value="Gaming">Gaming</option>
                    <option value="Smartphones">Smartphones</option>
                    <option value="Informatique">Informatique</option>
                    <option value="Audio">Audio</option>
                </select>

                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>

                <div class="price-box">
                    <div>
                        <label id="label-prix" for="prix">Prix (€)</label>
                        <input type="number" id="prix" name="prix" min="0" step="0.01" required>
                    </div>
                    <div>
                        <label for="type_vente">Type de vente</label>
                        <select id="type_vente" name="type_vente" onchange="toggleDuree()" required>
                            <option value="Achat immédiat">Achat immédiat</option>
                            <option value="Négociation">Négociation</option>
                            <option value="Enchères">Enchères</option>
                        </select>
                    </div>
                </div>

                <div id="bloc-duree">
                    <label>Durée de l'enchère</label>
                    <div class="duration-box">
                        <div>
                            <input type="number" name="duree_jours" min="0" value="7" placeholder="Jours">
                            <small>Jours</small>
                        </div>
                        <div>
                            <input type="number" name="duree_heures" min="0" max="23" value="0" placeholder="Heures">
                            <small>Heures</small>
                        </div>
                        <div>
                            <input type="number" name="duree_minutes" min="0" max="59" value="0" placeholder="Min">
                            <small>Min</small>
                        </div>
                        <div>
                            <input type="number" name="duree_secondes" min="0" max="59" value="0" placeholder="Sec">
                            <small>Sec</small>
                        </div>
                    </div>
                </div>

                <label for="image">Ajouter une image</label>
                <input type="file" id="image" name="image" accept="image/*">

                <button type="submit">Publier</button>
            </form>
        </div>
    </section>

    <script>
        function toggleDuree() {
            const type = document.getElementById('type_vente').value;
            const blocDuree = document.getElementById('bloc-duree');
            const labelPrix = document.getElementById('label-prix');
            
            if(type === 'Enchères') {
                blocDuree.style.display = 'block';
                labelPrix.innerText = "Prix de départ (€)";
            } else {
                blocDuree.style.display = 'none';
                labelPrix.innerText = "Prix (€)";
            }
        }
    </script>
</body>
</html>
