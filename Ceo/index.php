<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceo</title>
    <link rel="stylesheet" type="text/css" href="Assets/css/stile.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .product {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            width: calc(50% - 20px);
            box-sizing: border-box;
            transition: transform 0.3s ease-in-out;
            display: inline-block;
            /* Cambio importante */
            vertical-align: top;
            /* Alineación superior */
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-title {
            color: #333;
            margin-bottom: 10px;
        }

        .product-btn {
            display: block;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }

        .product-btn:hover {
            background-color: #2980b9;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c0392b;
        }

        .product-info h4 {
            color: #333;
            margin-bottom: 10px;
            text-decoration: none;
            /* Elimina el subrayado */
        }
    </style>
</head>

<body>

    <h1><a class="btn btn-primary" href="../index.php">Bienvenido-Ceo</a></h1>

    <section class="container">


        <div class="product">
            <div class="product-info">
                <h4 class="product-title">Empresa</h4>
                <a class="product-btn" href="empresa.php">Ingresar</a>
            </div>
        </div>

        <div class="product">
            <div class="product-info">
                <h4 class="product-title">Licencia</h4>
                <a class="product-btn" href="licencia.php">Ingresar</a>
            </div>
        </div>
    </section>
</body>

</html>