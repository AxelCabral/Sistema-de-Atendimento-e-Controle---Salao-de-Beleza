<?php
    include_once ("connection.php");
    include_once ("classes/product.php");
    include_once ("DAO/product_DAO.php");

    if(isset($_POST['id'], $_POST['name'], $_POST['quantity'], $_POST['min'])&& $_POST['id'] != "" && 
    $_POST['name'] != "" && $_POST['quantity'] != "" && $_POST['min'] != ""){

        $id = $_POST['id'];

        $c = new connection();
        $conn = $c->connect();

        $p = new product();
        $p->setName($_POST['name']);
        $p->setQuantity($_POST['quantity']);
        $p->setMin($_POST['min']);

        $edit = new product_DAO();
        $result = $edit->edit_product($id, $p, $conn);

        if($result == true){
            $message = "Sucesso! O produto foi alterado com êxito.";
        }
        else if($result == false){
            $message = "Erro! Verifique se o servidor foi inicializado corretamente.";
        }
        else{
            $message = "Erro desconhecido! ".$result;
        }
    }
    else{
        $message = "Erro! As informações enviadas não são válidas, por favor tente novamente.";
    }
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
                <p><?=$message?></p>
                <a href="../products.php" target="_self" rel="prev">Voltar ao Estoque</a>
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