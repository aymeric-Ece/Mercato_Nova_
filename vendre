<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendre un produit - Mercato Nova</title>

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

        /* FORM */

        .container{
            display:flex;
            justify-content:center;
            align-items:center;
            padding:60px 20px;
        }

        .form-box{
            background:white;
            width:700px;
            padding:50px;
            border-radius:20px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }

        h1{
            text-align:center;
            margin-bottom:15px;
            font-size:42px;
        }

        .subtitle{
            text-align:center;
            color:#64748b;
            margin-bottom:40px;
        }

        label{
            display:block;
            margin-bottom:10px;
            font-weight:bold;
            margin-top:20px;
        }

        input,
        textarea,
        select{
            width:100%;
            padding:15px;
            border-radius:10px;
            border:1px solid #cbd5e1;
            font-size:16px;
        }

        textarea{
            resize:none;
            height:140px;
        }

        .price-box{
            display:flex;
            gap:20px;
        }

        .price-box div{
            flex:1;
        }

        button{
            width:100%;
            padding:18px;
            margin-top:35px;
            border:none;
            border-radius:12px;
            background:#38bdf8;
            color:white;
            font-size:18px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#0ea5e9;
        }

        /* FOOTER */

        footer{
            background:#0f172a;
            color:white;
            text-align:center;
            padding:25px;
            margin-top:50px;
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

            .form-box{
                padding:30px;
            }

            .price-box{
                flex-direction:column;
                gap:0;
            }
        }

    </style>

</head>

<body>

    <!-- HEADER -->

    <nav>

        <div class="logo">
            Mercato Nova
        </div>

        <ul>
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
			<li><a href="mes_annonces.html">Mes annonces</a></li>
            <li><a href="connexion.html">Connexion</a></li>
        </ul>

    </nav>

    <!-- FORM -->

    <section class="container">

        <div class="form-box">

            <h1>Vendre un produit</h1>

            <p class="subtitle">
                Publiez votre produit sur Mercato Nova en quelques minutes.
            </p>

            <form action="catalogue.html">

                <label>Nom du produit</label>
                <input type="text" placeholder="Ex : PlayStation 5" required>

                <label>Catégorie</label>

                <select required>
                    <option>Gaming</option>
                    <option>Smartphones</option>
                    <option>Informatique</option>
                    <option>Audio</option>
                </select>

                <label>Description</label>

                <textarea placeholder="Décrivez votre produit..." required></textarea>

                <div class="price-box">

                    <div>

                        <label>Prix (€)</label>
                        <input type="number" placeholder="499">

                    </div>

                    <div>

                        <label>Type de vente</label>

                        <select>
                            <option>Vente classique</option>
                            <option>Enchère</option>
                            <option>Négociation</option>
                        </select>

                    </div>

                </div>

                <label>Ajouter une image</label>

                <input type="file">

                <button type="submit">
                    Publier le produit
                </button>

            </form>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>

        <p>
            © 2026 Mercato Nova - Tous droits réservés
        </p>

    </footer>

</body>

</html>
