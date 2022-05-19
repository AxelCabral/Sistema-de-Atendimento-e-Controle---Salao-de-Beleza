<?php

    include_once ("connection.php");
    include_once ("DAO/product_DAO.php");

    $id = $_GET['id'];

    $c = new connection();
    $conn = $c->connect();

    $p = new product_DAO();
    $stmt = $p->edit_product_info($id, $conn);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/fonts.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet" />
    <script src="../js/lord-icon.js"></script>
    <link rel="icon" href="../img/logo.png">
    <title>Lucia Reis | Estoque</title>
</head>
<body class="list-main-section-form" id="background-type-product">
    <header>
        <div class="return">
            <a href="../products.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="../css/icons/return.json"
                    trigger="hover"
                    delay="1000"
                    colors="primary:#000,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;padding-left:5px;">
                </lord-icon>
            </a>
        </div>
        <div class="title-form" id="product-title">
            <div class="main-text-title">
                <h1>Edição de Produto</h1>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out-form">
            <div class="form-style">
                <form action="confirm_edit_product.php" method="post">
                    <?php
                        foreach($stmt as $info){
                    ?>
                        <label for="name">Nome:</label>
                        <input type="text" name="name" value="<?=$info->nome?>" required>

                        <label for="quantity">Quantidade:</label>
                        <input type="number" name="quantity" value="<?=$info->quantidade?>" required>

                        <label for="min">Mínimo de unidades:</label>
                        <input type="number" name="min" value="<?=$info->min?>" required>

                        <input type="hidden" name="id" value="<?=$info->id?>">
                        
                        <input id="button-color-product" type="submit" value="Confirmar">
                    <?php
                        }
                    ?>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>Espaço da Beleza Lucia Reis - Santana do Livramento, RS 
        <lord-icon src="../css/icons/local.json"
                    trigger="loop"
                    delay="1000"
                    colors="primary:#ffffff,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;">
        </lord-icon>
        | &copy; Todos os direitos reservados.</p>
    </footer>
</body>
</html>