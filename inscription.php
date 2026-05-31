<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <title>Inscription - MercaTech</title>
	
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            background-color: #0f172a;
            width: 100%;
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
            color: #38bdf8;
        }
        
        nav ul {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #38bdf8;
        }

        .main-content {
            flex: 1; /* Prend tout l'espace disponible sous la nav */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 24px;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #475569;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; color: #0f172a; }

        input:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            gap: 8px;
        }

        .checkbox-group label {
            font-size: 13px;
            font-weight: normal;
            margin-bottom: 0;
            cursor: pointer;
        }

        .checkbox-group input {
            margin-top: 2px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #16a34a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #15803d;
        }

        .error-message {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #fca5a5;
        }

        .success-message {
            background-color: #dcfce7;
            color: #16a34a;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #86efac;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">MercaTech</div>
        <ul>
            <li><a href="Acceuil_MT.html">Accueil</a></li>
            <li><a href="catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="container">
            <h2 id="titre-page">Inscription MercaTech</h2>

            <div id="message-container"></div>

            <form id="form-inscription" action="traitement_inscription.php" method="POST">
                
                <div class="form-group">
                    <label for="nom_utilisateur">Nom d'utilisateur</label>
                    <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
                </div>

                <div class="form-group">
                    <label for="email">Adresse E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="telephone">Numéro de téléphone</label>
                    <input type="tel" id="telephone" name="telephone" required>
                </div>

                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                </div>

                <div class="form-group">
                    <label for="confirmation_mot_de_passe">Confirmer le mot de passe</label>
                    <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="confidentialite" name="confidentialite" required>
                    <label for="confidentialite">J'accepte la politique de confidentialité.</label>
                </div>

                <button type="submit" class="btn-submit">Valider l'inscription</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const params = new URLSearchParams(window.location.search);
            const messageContainer = document.getElementById("message-container");
            const formInscription = document.getElementById("form-inscription");
            const titrePage = document.getElementById("titre-page");

            if (params.has('nom_utilisateur')) document.getElementById('nom_utilisateur').value = params.get('nom_utilisateur');
            if (params.has('email')) document.getElementById('email').value = params.get('email');
            if (params.has('telephone')) document.getElementById('telephone').value = params.get('telephone');

            if (params.has('success')) {
                titrePage.classList.add('hidden');
                formInscription.classList.add('hidden');
				
                messageContainer.innerHTML = `
                    <div class="success-message">
                        ✅ Inscription réussie !<br><br>
                        <span style="font-size: 14px; font-weight: normal; color: #475569;">
                            Redirection vers l'accueil dans 2 secondes...
                        </span>
                    </div>
                `;
                setTimeout(() => {
                    window.location.href = 'Acceuil_MT.html'; 
                }, 2000);
                return;
            }

            let errorMessage = "";
            if (params.has('erreur')) {
                errorMessage = "Erreur de connexion à la base de données.";
            } else if (params.has('erreur_conditions')) {
                errorMessage = "Vous devez accepter les conditions et confirmer être majeur.";
            } else if (params.has('erreur_mdp')) {
                errorMessage = "Les mots de passe ne correspondent pas.";
            } else if (params.has('erreur_nom')) {
                errorMessage = "Ce nom d'utilisateur est déjà pris.";
            } else if (params.has('erreur_email')) {
                errorMessage = "Cet email est déjà utilisé.";
            } else if (params.has('erreur_telephone')) {
                errorMessage = "Ce numéro de téléphone est déjà enregistré.";
            }

            if (errorMessage !== "") {
                messageContainer.innerHTML = `<div class="error-message">${errorMessage}</div>`;
            }
        });
    </script>
</body>
</html>
