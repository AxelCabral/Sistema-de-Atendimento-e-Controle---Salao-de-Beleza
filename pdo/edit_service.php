<?php

    include_once ("connection.php");
    include_once ("DAO/service_DAO.php");

    $id = $_GET['id'];

    $c = new connection();
    $conn = $c->connect();

    $p = new service_DAO();
    $stmt = $p->edit_service_info($id, $conn);

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
    <title>Lucia Reis | Serviços</title>
</head>
<body class="list-main-section-form" id="background-type-service">
    <header>
        <div class="return">
            <a href="services.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="../css/icons/return.json"
                    trigger="hover"
                    delay="1000"
                    colors="primary:#000,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;padding-left:5px;">
                </lord-icon>
            </a>
        </div>
        <div class="title-form" id="service-title">
            <div class="main-text-title">
                <h1>Edição de Serviço</h1>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out-form">
            <div class="form-style">
                <form action="confirm_edit_service.php" method="post">
                    <?php
                        foreach($stmt as $info){
                    ?>
                        <label for="service">Serviço:</label>
                        <input type="text" name="service" value="<?=$info->servico?>" required>

                        <label for="price">Valor:</label>
                        <input type="number" step=".01" name="price" value="<?=number_format($info->valor, 2)?>" required>

                        <input type="hidden" name="id" value="<?=$info->id?>">
                        
                        <input id="button-color-service" type="submit" value="Confirmar">
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