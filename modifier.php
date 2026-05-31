<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une annonce - MercaTech</title>

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
            background:#0f172a;
            color:white;
            font-size:18px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#1e293b;
        }

 
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
    <nav>

        <div class="logo">
            MercaTech
        </div>

        <ul>
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
            <li><a href="mes_annonces.html">Mes annonces</a></li>
        </ul>

    </nav>

    <section class="container">

        <div class="form-box">

            <h1>Modifier l'annonce</h1>

            <p class="subtitle">
                Modifiez les informations de votre produit.
            </p>

            <form action="mes_annonces.html">

                <label>Nom du produit</label>

                <input 
                    type="text"
                    value="PlayStation 5"
                    required
                >

                <label>Catégories</label>

                <select required>

                    <option selected>
                        Gaming
                    </option>

                    <option>
                        Smartphones
                    </option>

                    <option>
                        Informatique
                    </option>

                    <option>
                        Audio
                    </option>

                </select>

                <label>Description</label>

                <textarea required>Console nouvelle génération avec SSD ultra rapide et graphismes 4K.</textarea>

                <div class="price-box">

                    <div>

                        <label>Prix (€)</label>

                        <input 
                            type="number"
                            value="499"
                            required
                        >

                    </div>

                    <div>
                        <label>Type de vente</label>
                        <select>
                            <option selected>
                                Vente classique
                            </option>

                            <option>
                                Enchère
                            </option>

                            <option>
                                Négociation
                            </option>
                        </select>
                    </div>

                </div>

                <label>Modifier l'image</label>

                <input type="file">

                <button type="submit">
                    💾 Enregistrer les changements effectués
                </button>

            </form>

        </div>

    </section>

    <footer>
        <p>
            © 2026 MercaTech - Tous droits réservés
        </p>
    </footer>

</body>
</html>
