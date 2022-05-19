<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" />
    <script src="js/lord-icon.js"></script>
    <link rel="icon" href="img/logo.png">
    <title>Lucia Reis | Estoque</title>
</head>
<body class="list-main-section-form" id="background-type-product">
    <header>
        <div class="return">
            <a href="products.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="css/icons/return.json"
                    trigger="hover"
                    delay="1000"
                    colors="primary:#000,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;padding-left:5px;">
                </lord-icon>
            </a>
        </div>
        <div class="title-form" id="product-title">
            <div class="main-text-title">
                <h1>Novo Produto</h1>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out-form">
            <div class="form-style">
                <form action="pdo/confirm_product.php" method="post">
                    <label for="name">Nome:</label>
                    <input type="text" name="name" placeholder="Nome do produto" required>

                    <label for="quantity">Quantidade:</label>
                    <input type="number" name="quantity" placeholder="Unidades" required>

                    <label for="min">Mínimo de unidades:</label>
                    <input type="number" name="min" placeholder="Mínimo de unidades em estoque" required>

                    <input id="button-color-product" type="submit" value="Confirmar">
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>Espaço da Beleza Lucia Reis - Santana do Livramento, RS 
        <lord-icon src="css/icons/local.json"
                    trigger="loop"
                    delay="1000"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;">
        </lord-icon>
        | &copy; Todos os direitos reservados.</p>
    </footer>
</body>
</html>