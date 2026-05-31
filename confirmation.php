<?php
session_start();

$commande_id = $_SESSION['derniere_commande'] ?? null;

// Si aucune commande récente n'est trouvée en session, on redirige vers l'accueil
if (!$commande_id) {
    header("Location: catalogue.php");
    exit;
}

// Optionnel : Effacer l'ID de session pour que l'accès direct futur à cette page soit bloqué
unset($_SESSION['derniere_commande']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Confirmée ! - Mercato Nova</title>
    <style>
        * { 
		margin: 0; 
		padding: 0; 
		box-sizing: border-box; 
		font-family: Arial, sans-serif; 
		}
        body { 
		background-color: #f8fafc; 
		color: #0f172a; 
		display: flex; 
		flex-direction: column; 
		min-height: 100vh; 
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

        .success-container { 
		flex: 1; 
		max-width: 600px; 
		margin: 80px auto; 
		text-align: center; 
		background: white; 
		padding: 50px; 
		border-radius: 20px; 
		box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
		}
        
        .success-icon { 
		font-size: 72px; 
		color: #22c55e; 
		margin-bottom: 20px; 
		animation: pop 0.5s ease-out; 
		}
        
        h1 { 
		font-size: 32px; 
		margin-bottom: 15px; 
		color: #0f172a; 
		}
        p { 
		color: #64748b; 
		font-size: 16px; 
		line-height: 1.6; 
		margin-bottom: 30px; 
		}
        
        .order-badge { 
		display: inline-block; 
		background-color: #f0fdf4; 
		border: 1px solid #bbf7d0; 
		color: #166534; 
		padding: 12px 25px; 
		border-radius: 50px; 
		font-weight: bold; 
		font-size: 18px; 
		margin-bottom: 35px; 
		}
        
        .btn-home { 
		display: inline-block; 
		background-color: #0f172a; 
		color: white; 
		padding: 14px 30px; 
		text-decoration: none; 
		border-radius: 10px; 
		font-weight: bold; 
		transition: 0.3s; 
		}
        .btn-home:hover { 
		background-color: #38bdf8; 
		}

        footer { 
		background-color: #0f172a; 
		text-align: center; 
		padding: 25px; 
		color: white; 
		}

        @keyframes pop {
            0% { transform: scale(0); }
            80% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <nav>
        <a href="accueil.php" class="logo">Mercato Nova</a>
    </nav>

    <div class="success-container">
        <div class="success-icon">🎉</div>
        <h1>Merci pour votre commande !</h1>
        <p>Votre paiement a été accepté avec succès. Un e-mail de confirmation contenant votre facture et les détails de suivi vous a été envoyé.</p>
        
        <div class="order-badge">
            N° de commande : #<?= htmlspecialchars($commande_id) ?>
        </div>

        <div>
            <a href="catalogue.php" class="btn-home">Retourner au Catalogue</a>
        </div>
    </div>
    
    <footer>
        <p>© 2026 Mercato Nova - Tous droits réservés</p>
    </footer>

</body>
</html>
