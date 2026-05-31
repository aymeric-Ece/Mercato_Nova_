<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Sécurisé - MercaTech</title>


        .checkout-container { 
		display: flex; 
		max-width: 1200px; 
		margin: 40px auto; 
		gap: 40px; 
		padding: 0 20px; 
		}
        
        /* Formulaire de gauche */
        .payment-form { 
		flex: 1.4; 
		background: white; 
		padding: 40px; 
		border-radius: 18px; 
		box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
		}
        .payment-form h1 { 
		font-size: 28px; 
		margin-bottom: 25px; 
		display: flex; 
		align-items: center; 
		gap: 10px; 
		}
        .form-section { 
		margin-bottom: 30px; 
		}
        .form-section h3 { 
		font-size: 18px; 
		margin-bottom: 15px; 
		color: #334155; 
		border-bottom: 2px solid #f1f5f9; 
		padding-bottom: 8px; 
		}
        
        .form-group { 
		margin-bottom: 15px; 
		}
        .form-row { 
		display: flex; gap: 15px; 
		}
        .form-row .form-group { 
		flex: 1; 
		}
        
        label { 
		display: block; 
		font-size: 14px; 
		font-weight: bold; 
		margin-bottom: 6px; 
		color: #475569; 
		}
        input[type="text"], input[type="email"] { 
		width: 100%; 
		padding: 12px; 
		border: 1px solid #cbd5e1; 
		border-radius: 8px; 
		font-size: 15px; 
		transition: 0.3s; 
		}
        input:focus { 
		outline: none; 
		border-color: #38bdf8; 
		box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); 
		}
        
        .alert-error { 
		background-color: #fef2f2; 
		color: #ef4444; 
		padding: 12px; 
		border-radius: 8px; 
		margin-bottom: 20px; 
		font-weight: bold; 
		border-left: 4px solid #ef4444; 
		}
        
        .pay-btn { 
		width: 100%; 
		background-color: #0f172a; 
		color: white; 
		padding: 16px; 
		border: none; 
		border-radius: 12px; 
		font-size: 18px; 
		font-weight: bold; 
		cursor: pointer; 
		transition: 0.3s; 
		margin-top: 10px; 
		}
        .pay-btn:hover { 
		background-color: #1e293b; 
		}

        /* Récapitulatif de droite */
        .order-summary { 
		flex: 1; 
		background: white; 
		padding: 30px; 
		border-radius: 18px; 
		height: fit-content; 
		box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
		position: sticky; 
		top: 20px; 
		}
        .order-summary h2 { 
		font-size: 20px; 
		margin-bottom: 20px; 
		color: #0f172a; 
		}
        
        .summary-item { 
		display: flex; 
		align-items: center; 
		gap: 15px; 
		padding: 15px 0; 
		border-bottom: 1px solid #f1f5f9; 
		}
        .summary-item img { 
		width: 60px; 
		height: 60px; 
		object-fit: cover; 
		border-radius: 8px; 
		}
        .item-details { 
		flex: 1; 
		}
        .item-details h4 { 
		font-size: 15px; 
		color: #1e293b; 
		margin-bottom: 4px; 
		}
        .item-details p { 
		font-size: 13px; 
		color: #64748b; 
		}
        .item-price { 
		font-weight: bold; 
		color: #0f172a; 
		}
        
        .price-line { 
		display: flex; 
		justify-content: space-between; 
		margin-top: 15px; 
		font-size: 16px; 
		color: #475569; 
		}
        .price-line.total { 
		border-top: 2px dashed #e2e8f0; 
		padding-top: 15px; 
		font-size: 22px; 
		font-weight: bold; 
		color: #0284c7; 
		}
        
        footer { 
		background-color: #0f172a; 
		text-align: center; 
		padding: 25px; 
		color: white; 
		margin-top: 80px; 
		}
        
        @media (max-width: 900px) { 
			.checkout-container { 
			flex-direction: column-reverse; 
			} 
			.order-summary { 
			position: static; 
			} 
		}
    </style>
</head>

<body>

    <nav>
        <a href="accueil.php" class="logo">MercaTech</a>
    </nav>

    <footer>
        <p>© 2026 MercaTech - Tunnel de paiement de démonstration</p>
    </footer>

</body>
</html>
