<?php
    include_once ("connection.php");
    include_once ("classes/service.php");
    include_once ("DAO/service_DAO.php");

    if(isset($_POST['service'], $_POST['price'])&& $_POST['service'] != "" && $_POST['price'] != ""){

        $c = new connection();
        $conn = $c->connect();

        $s = new service();
        $s->setService($_POST['service']);
        $s->setPrice($_POST['price']);

        $insert = new service_DAO();
        $result = $insert->insert_service($s, $conn);

        if($result == true){
            $message = "Sucesso! O serviço foi disponibilizado com êxito.";
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
<body class="list-main-section-form" id="background-type-service">
    <header>
        <div class="return">
            <a href="../services.php" title="Voltar" target="_self" rel="prev">
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
                <h1>Novo Serviço</h1>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out-form">
            <div class="form-style">
                <p><?=$message?></p>
                <a href="../new_service.php" target="_self" rel="prev">Registrar outro serviço</a>
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