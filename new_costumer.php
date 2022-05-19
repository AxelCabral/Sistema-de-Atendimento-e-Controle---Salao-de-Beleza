<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" />
    <script src="js/lord-icon.js"></script>
    <script src="js/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src='js/jquery.maskedinput.js'></script>
    <link rel="icon" href="img/logo.png">
    <title>Lucia Reis | Clientes</title>
</head>
<body class="list-main-section-form" id="background-type-costumer">
    <header>
        <div class="return">
            <a href="costumers.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="css/icons/return.json"
                    trigger="hover"
                    delay="1000"
                    colors="primary:#000,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;padding-left:5px;">
                </lord-icon>
            </a>
        </div>
        <div class="title-form" id="costumer-title">
            <div class="main-text-title">
                <h1>Nova Cliente</h1>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out-form">
            <div class="form-style">
                <form action="pdo/confirm_costumer.php" method="post">
                    <label for="name">Nome:</label>
                    <input type="text" name="name" placeholder="Nome do cliente" required>

                    <label for="phone_number">Celular:</label>
                    <input id="phone" type="text" name="phone_number" placeholder="Número de celular" required>

                    <label for="bdate">Data de Nascimento:</label>
                    <input type="date" name="bdate" required>

                    <input id="button-color-costumer" type="submit" value="Confirmar">
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
    <script>
        $(document).ready(function() {
            $('#phone').mask("99 99999-9999");
        });
    </script>
</body>
</html>