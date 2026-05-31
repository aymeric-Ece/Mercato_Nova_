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

$utilisateur_id = $_SESSION['utilisateur_id'] ?? 1;
$id_item = intval($_GET['id'] ?? 0);
$type_item = $_GET['type'] ?? 'classique'; // 'classique' ou 'enchere'

if ($id_item <= 0) { die("ID manquant."); }

// RÉCUPÉRATION SELON LA TABLE CIBLE
if ($type_item === 'enchere') {
    $requete = $pdo->prepare("SELECT id, nom, description, categorie, prix_depart AS prix, image, date_fin FROM encheres WHERE id = ? AND utilisateur_id = ?");
} else {
    $requete = $pdo->prepare("SELECT * FROM produits WHERE id = ? AND utilisateur_id = ?");
}
$requete->execute([$id_item, $utilisateur_id]);
$item = $requete->fetch(PDO::FETCH_ASSOC);

if (!$item) { die("Cette annonce n'existe pas ou ne vous appartient pas."); }

$message = "";
$message_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $categorie = $_POST['categorie'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    
    if (empty($nom) || empty($categorie) || empty($description) || $prix <= 0) {
        $message = "Veuillez remplir correctement tous les champs.";
        $message_type = "error";
    } else {
        $chemin_image = $item['image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $nom_fichier = $_FILES['image']['name'];
            $extension = strtolower(pathinfo($nom_fichier, PATHINFO_EXTENSION));
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                $nouveau_nom = uniqid('prod_', true) . "." . $extension;
                $destination = "uploads/" . $nouveau_nom;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $chemin_image = $destination;
                }
            }
        }
        
        try {
            if ($type_item === 'enchere') {
                // recalcul de la durée optionnelle lors de la modification
                $jours = intval($_POST['duree_jours'] ?? 0);
                $heures = intval($_POST['duree_heures'] ?? 0);
                $minutes = intval($_POST['duree_minutes'] ?? 0);
                $secondes = intval($_POST['duree_secondes'] ?? 0);
                
                $interval_str = "+{$jours} days +{$heures} hours +{$minutes} minutes +{$secondes} seconds";
                $date_fin = date('Y-m-d H:i:s', strtotime($interval_str));

                $maj = $pdo->prepare("UPDATE encheres SET nom = ?, categorie = ?, description = ?, prix_depart = ?, image = ?, date_fin = ? WHERE id = ? AND utilisateur_id = ?");
                $maj->execute([$nom, $categorie, $description, $prix, $chemin_image, $date_fin, $id_item, $utilisateur_id]);
            } else {
                $maj = $pdo->prepare("UPDATE produits SET nom = ?, categorie = ?, description = ?, prix = ?, image = ? WHERE id = ? AND utilisateur_id = ?");
                $maj->execute([$nom, $categorie, $description, $prix, $chemin_image, $id_item, $utilisateur_id]);
            }
            
            $message = "L'annonce a été modifiée avec succès !";
            $message_type = "success";
            header("Refresh: 2; URL=mes_annonces.php");
            
            $item['nom'] = $nom; $item['categorie'] = $categorie; $item['description'] = $description; $item['prix'] = $prix; $item['image'] = $chemin_image;
        } catch (PDOException $e) {
            $message = "Erreur lors de l'enregistrement.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une annonce - Mercato Nova</title>
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }
        body{ background:#f8fafc; color:#0f172a; }
        nav{ display:flex; justify-content:space-between; align-items:center; padding:20px 60px; background:#0f172a; }
        .logo{ font-size:30px; font-weight:bold; color:#38bdf8; }
        nav ul{ display:flex; list-style:none; gap:30px; }
        nav ul li a{ text-decoration:none; color:white; }
        .container{ display:flex; flex-direction: column; justify-content:center; align-items:center; padding:60px 20px; }
        .form-box{ background:white; width:700px; padding:50px; border-radius:20px; box-shadow:0 5px 15px rgba(0,0,0,0.08); }
        h1{ text-align:center; margin-bottom:15px; font-size:42px; }
        label{ display:block; margin-bottom:10px; font-weight:bold; margin-top:20px; }
        input, textarea, select{ width:100%; padding:15px; border-radius:10px; border:1px solid #cbd5e1; font-size:16px; }
        textarea { resize:none; height:140px; }
        .duration-box { display:flex; gap:20px; }
        .duration-box div { flex:1; }
        button{ width:100%; padding:18px; margin-top:35px; border:none; border-radius:12px; background:#0f172a; color:white; font-size:18px; font-weight:bold; cursor:pointer; }
        .alert { width: 700px; padding: 15px; margin-bottom: 20px; border-radius: 10px; font-weight: bold; text-align: center; }
        .alert-success { background-color: #bbf7d0; color: #166534; }
        .alert-error { background-color: #fecaca; color: #991b1b; }
    </style>
</head>
<body>
    <nav><div class="logo">Mercato Nova</div>
        <ul><li><a href="mes_annonces.php">Mes annonces</a></li></ul>
    </nav>
    <section class="container">
        <?php if (!empty($message)): ?><div class="alert alert-<?= $message_type ?>"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <div class="form-box">
            <h1>Modifier l'annonce</h1>
            <form action="modifier.php?id=<?= $id_item ?>&type=<?= $type_item ?>" method="POST" enctype="multipart/form-data">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($item['nom']) ?>" required>

                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <option value="Gaming" <?= $item['categorie'] === 'Gaming' ? 'selected' : '' ?>>Gaming</option>
                    <option value="Smartphones" <?= $item['categorie'] === 'Smartphones' ? 'selected' : '' ?>>Smartphones</option>
                    <option value="Informatique" <?= $item['categorie'] === 'Informatique' ? 'selected' : '' ?>>Informatique</option>
                    <option value="Audio" <?= $item['categorie'] === 'Audio' ? 'selected' : '' ?>>Audio</option>
                </select>

                <label for="description">Description</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($item['description']) ?></textarea>

                <label for="prix"><?= $type_item === 'enchere' ? 'Prix de départ (€)' : 'Prix (€)' ?></label>
                <input type="number" id="prix" name="prix" value="<?= htmlspecialchars($item['prix']) ?>" required>

                <?php if($type_item === 'enchere'): ?>
                    <label>Ajouter du temps à la durée de fin (Optionnel)</label>
                    <div class="duration-box">
                        <div><input type="number" name="duree_jours" min="0" value="0"><small>Jours</small></div>
                        <div><input type="number" name="duree_heures" min="0" max="23" value="0"><small>Heures</small></div>
                        <div><input type="number" name="duree_minutes" min="0" max="59" value="0"><small>Min</small></div>
                    </div>
                <?php endif; ?>

                <label for="image">Modifier l'image (Optionnel)</label>
                <input type="file" id="image" name="image" accept="image/*">

                <button type="submit">💾 Enregistrer les changements</button>
            </form>
        </div>
    </section>
</body>
</html>
