<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Se connecter</title>

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
    width:500px;
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

button{
    width:100%;
    padding:15px;
    border:none;
    border-radius:10px;
    background:#0f172a;
    color:white;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#1e293b;
}

.error-input{
    border:2px solid red;
    background:#fff5f5;
}

.error-message{
    color:red;
    margin-bottom:20px;
    font-size:15px;
}

</style>

</head>

<body>

<div class="container">

    <div class="form-box">

        <h1>Se connecter</h1>

        <form action="traitement_connexion.php" method="POST">

            <input
                type="text"

                name="identifiant"

                placeholder="Nom, email ou numéro"

                value="<?php echo htmlspecialchars($_GET['identifiant'] ?? ''); ?>"

                class="<?php if(isset($_GET['erreur_identifiant'])) echo 'error-input'; ?>"

                required
            >

            <?php

            if(isset($_GET['erreur_identifiant'])){

                echo '
                <p class="error-message">
                    Nom d’utilisateur, email ou téléphone introuvable.
                </p>
                ';

            }

            ?>

            <input
                type="password"

                name="mot_de_passe"

                placeholder="Mot de passe"

                class="<?php if(isset($_GET['erreur_mdp'])) echo 'error-input'; ?>"

                required
            >

            <?php

            if(isset($_GET['erreur_mdp'])){

                echo '
                <p class="error-message">
                    Mot de passe incorrect.
                </p>
                ';

            }

            ?>

            <button type="submit">
                Se connecter
            </button>

        </form>

    </div>

</div>

</body>

</html>
