<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscription</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f8fafc;
}

.container{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}

.form-box{
    background:white;
    width:550px;
    padding:50px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

h1{
    margin-bottom:30px;
    text-align:center;
    color:#0f172a;
}

input{
    width:100%;
    padding:15px;
    margin-bottom:20px;
    border-radius:10px;
    border:1px solid #cbd5e1;
    font-size:16px;
}

.checkbox{
    margin-bottom:20px;
    color:#334155;
    line-height:1.5;
}

.checkbox input{
    width:auto;
    margin-right:10px;
}

.checkbox a{
    color:#0284c7;
    text-decoration:none;
}

.checkbox a:hover{
    text-decoration:underline;
}

button{
    width:100%;
    padding:15px;
    border:none;
    border-radius:10px;
    background:#38bdf8;
    color:white;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#0ea5e9;
}
.error-input{
    border:2px solid #dc2626;
    background:#fef2f2;
}

.error-message{
    color:#dc2626;
    margin-top:-10px;
    margin-bottom:15px;
    font-size:14px;
}

.error-checkbox{
    color:#dc2626;
}

</style>

</head>

<body>

<div class="container">

    <div class="form-box">

        <h1>S'inscrire</h1>

        <form action="traitement_inscription.php" method="POST">

    <!-- NOM UTILISATEUR -->

    <input 
		type="text"
		name="nom_utilisateur"
		placeholder="Nom d'utilisateur"
		value="<?php echo htmlspecialchars($_GET['nom_utilisateur'] ?? ''); ?>"
		class="<?php if(isset($_GET['erreur_nom'])) echo 'error-input'; ?>"
		required
	>

    <?php
    if(isset($_GET['erreur_nom'])){
        echo '<p class="error-message">
        Ce nom d’utilisateur existe déjà.
        </p>';
    }
    ?>

    <!-- EMAIL -->

    <input 
		type="email"
		name="email"
		placeholder="Adresse email"
		value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>"
		class="<?php if(isset($_GET['erreur_email'])) echo 'error-input'; ?>"
		required
	>

    <?php
    if(isset($_GET['erreur_email'])){
        echo '<p class="error-message">
        Cette adresse email existe déjà.
        </p>';
    }
    ?>

    <!-- TELEPHONE -->

    <input 
		type="tel"
		name="telephone"
		placeholder="Numéro de téléphone"
		value="<?php echo htmlspecialchars($_GET['telephone'] ?? ''); ?>"
		class="<?php if(isset($_GET['erreur_telephone'])) echo 'error-input'; ?>"
		required
	>
    <?php
    if(isset($_GET['erreur_telephone'])){
        echo '<p class="error-message">
        Ce numéro est déjà utilisé.
        </p>';
    }
    ?>

    <!-- MOT DE PASSE -->

    <input 
        type="password"
        name="mot_de_passe"
        placeholder="Mot de passe"
        required
    >

    <input 
        type="password"
        name="confirmation_mot_de_passe"
        placeholder="Confirmer le mot de passe"
        class="<?php if(isset($_GET['erreur_mdp'])) echo 'error-input'; ?>"
        required
    >

    <?php
    if(isset($_GET['erreur_mdp'])){
        echo '<p class="error-message">
        Les mots de passe ne correspondent pas.
        </p>';
    }
    ?>

    <!-- CASES -->

    <div class="checkbox <?php if(isset($_GET['erreur_conditions'])) echo 'error-checkbox'; ?>">

    <label>

        <input 
			type="checkbox"
			name="confidentialite"

			<?php
			if(
				isset($_GET['nom_utilisateur']) ||
				isset($_GET['email']) ||
				isset($_GET['telephone'])
			){
				echo 'checked';
			}
			?>
		>

        J'atteste avoir lu la
        <a href="politique_de_confidentialite.html">
            politique de confidentialité
        </a>
        de la plateforme.

    </label>

</div>

<div class="checkbox <?php if(isset($_GET['erreur_conditions'])) echo 'error-checkbox'; ?>">

    <label>

        <input 
			type="checkbox"
			name="majeur"

			<?php
			if(
				isset($_GET['nom_utilisateur']) ||
				isset($_GET['email']) ||
				isset($_GET['telephone'])
			){
				echo 'checked';
			}
			?>
		>

        J'atteste avoir plus de 18 ans.

    </label>

</div>

<?php

if(isset($_GET['erreur_conditions'])){

    echo '
    <p class="error-message">
        Vous devez accepter les conditions.
    </p>
    ';

}

?>

    <button type="submit">
        Créer mon compte
    </button>

</form>

    </div>

</div>

</body>

</html>
