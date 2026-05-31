<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes annonces - MercaTech</title>

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

        <!-- boutons d'actions -->

        .actions{
            display:flex;
            flex-direction:column;
            gap:15px;
        }

        .btn{
            padding:14px 20px;
            border:none;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
            min-width:200px;
        }

        .btn-edit{
            background:#0f172a;
            color:white;
        }

        .btn-edit:hover{
            background:#1e293b;
        }

        .btn-view{
            background:#38bdf8;
            color:white;
        }

        .btn-view:hover{
            background:#0ea5e9;
        }

        .btn-delete{
            background:#ef4444;
            color:white;
        }

        .btn-delete:hover{
            background:#dc2626;
        }

        footer{
            background:#0f172a;
            color:white;
            text-align:center;
            padding:25px;
        }

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
            .annonces-container{
                padding-left:25px;
                padding-right:25px;
            }

            .page-title h1{
                font-size:38px;
            }
        }

    </style>

</head>

<body>

<nav>
        <div class="logo">
            MercaTech
        </div>

        <ul>
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
			<li><a href="mes_annonces.html">Mes annonces</a></li>
            <li><a href="connexion.html">Connexion</a></li>
        </ul>
    </nav>

    <section class="page-title">

        <h1>Mes annonces 📦</h1>

        <p>
            Gérez tous les produits que vous avez mis en vente sur MercaTech.
        </p>

    </section>

    <!-- boutons d'actions -->

    <div class="top-actions">

        <a href="vendre.html" class="sell-btn">
            ➕ Ajouter une annonce ➕
        </a>

    </div>


    <section class="annonces-container">

        <!-- PRODUCT 1 -->
        <div class="annonce-card">

            <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=1170&auto=format&fit=crop" alt="PS5">

            <div class="annonce-info">

                <h2>PlayStation 5</h2>

                <p>
                    Console nouvelle génération avec SSD ultra rapide et graphismes 4K.
                </p>

                <div class="price">
                    499€
                </div>

                <div class="status">
                    ✅ En ligne
                </div>

            </div>

            <div class="actions">

                <a href="modifier.html">
					<button class="btn btn-view">
						⚙ Gérer l'annonce
					</button>
				</a>

                <button class="btn btn-delete">
                    ❌ Supprimer
                </button>
            </div>
        </div>

        <!-- PRODUCT 2 -->
        <div class="annonce-card">

            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=1170&auto=format&fit=crop" alt="iPhone">

            <div class="annonce-info">

                <h2>iPhone 15 Pro</h2>

                <p>
                    Smartphone Apple premium avec écran ProMotion et appareil photo avancé.
                </p>

                <div class="price">
                    1299€
                </div>

                <div class="status">
                    🔥 En négociation
                </div>
            </div>

            <div class="actions">

				 <a href="modifier.html">
					<button class="btn btn-view">
						⚙ Gérer l'annonce
					</button>
				</a>

                <button class="btn btn-delete">
                    ❌ Supprimer
                </button>

            </div>
        </div>

        <!-- PRODUCT 3 -->
        <div class="annonce-card">

            <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?q=80&w=1170&auto=format&fit=crop" alt="PC Gamer">

            <div class="annonce-info">

                <h2>PC Gamer RTX</h2>

                <p>
                    Configuration gaming ultra performante idéale pour le streaming et les jeux AAA.
                </p>

                <div class="price">
                    1599€
                </div>

                <div class="status">
                    ⏳ En attente
                </div>

            </div>

            <div class="actions">
                <a href="modifier.html">
					<button class="btn btn-view">
						⚙ Gérer l'annonce
					</button>
				</a>

                <button class="btn btn-delete">
                    ❌ Supprimer
                </button>
            </div>

        </div>

    </section>

    <footer>
        <p>
            © 2026 MercaTech - Tous droits réservés
        </p>
    </footer>

</body>
</html>
