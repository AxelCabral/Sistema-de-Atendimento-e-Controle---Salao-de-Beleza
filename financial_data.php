<?php
    include_once ("pdo/connection.php");
    include_once ("pdo/DAO/financial_DAO.php");

    $c = new connection();
    $conn = $c->connect();

    $select = new financial_DAO();
    $stmt = $select->get_financial_data($conn);

    $cash =  0;
    $goal_verification = false;

    foreach($stmt as $i){
        $cash += $i->entrada_semanal;
        $cash -= $i->saida_semanal;
        $goal = $i->meta_semanal;
        $remove_cash = $i->saida_semanal;
        $add_cash = $i->entrada_semanal;
        if($cash >= $i->meta_semanal){
            $goal_verification = true;
        }
    }

    date_default_timezone_set('America/Sao_Paulo');
    $this_year = date('Y');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" />
    <script src="js/lord-icon.js"></script>
    <!-- Plugin JQuery Select2 -->
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="js/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="js/select2.min.js"></script>
    <!-- ----------------------- -->  
    <link rel="icon" href="img/logo.png">
    <title>Lucia Reis | Financeiro</title>
</head>
<body class="list-main-section-form" id="background-type-financial">
    <section id="popups">
        <div class="popup" id="open-remove-popup">
            <div class="popup-area">
                <p class="close-popup" id="close-remove-popup">X</p>
                <h2 class="popup-title">Pagar</h2>
                <form action="pdo/remove_cash.php" method="post">
                    <label for="cash">Valor: R$</label>
                    <input type="number" step=".01" name="cash" required>

                    <label id="solo-label" for="description">Descrição: </label>
                    <textarea name="description" cols="20" rows="2"></textarea>

                    <input type="hidden" name="current_cash" value="<?=$remove_cash;?>">

                    <input type="submit" value="Confirmar">
                </form>
            </div>
        </div>
        <div class="popup" id="open-add-popup">
            <div class="popup-area">
                <p class="close-popup" id="close-add-popup">X</p>
                <h2 class="popup-title">Receber</h2>
                <form action="pdo/add_cash.php" method="post">
                    <span>Origem:</span>
                    <input type="checkbox" id="lingerie" name="lingerie" value="Lingerie">
                    <label for="lingerie">Lingerie</label>

                    <input type="checkbox" id="purse" name="purse" value="Bolsas">
                    <label for="purse">Bolsas</label>
                    <br/>
                    <label for="other">Outro: </label>
                    <input type="text" name="other">

                    <label for="cash">Valor: R$</label>
                    <input type="number" step=".01" name="cash" required>

                    <input type="hidden" name="current_cash" value="<?=$add_cash;?>">

                    <input type="submit" value="Confirmar">
                </form>
            </div>
        </div>
        <div class="popup" id="open-change-popup">
            <div class="popup-area">
                <p class="close-popup" id="close-change-popup">X</p>
                <h2 class="popup-title">Mudar Meta</h2>
                <form action="pdo/change_goal.php" method="post">
                    <label for="new_goal">Nova meta: R$</label>
                    <input type="number" step=".01" name="new_goal" required>
                    <input type="submit" value="Confirmar">
                </form>
            </div>
        </div>
    </section>
    <header>
        <div class="return">
            <a href="index.php" title="Voltar" target="_self" rel="prev">
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
                <h1>Financeiro</h1>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out-financial">
            <div class="goal">
                <div>
                    <h2>Caixa Semanal</h2>
                    <p class="goal-value">R$<?=number_format($cash,2,',');?></p>
                </div>
                <div>
                    <p class="fake-button" id="show-add-popup">Receber</p>
                    <p class="fake-button" id="show-remove-popup">Pagar</p>
                </div>
            </div>
            <hr>
            <div class="goal">
                <h2>Meta Semanal</h2>
                <p class="goal-value">R$<?=number_format($goal,2,',');?></p>
                <?php
                    if($goal_verification == true){
                ?>
                        <span id="goal-plus">Meta alcançada!</span>
                <?php
                    }
                    else{
                ?>
                        <span id="goal-less">Meta não alcançada</span>
                <?php
                    }
                ?>
                <p class="fake-button" id="show-change-popup">Mudar meta</p>
            </div>
        </section>
        <div class="title-form" id="product-title">
            <div class="main-text-title">
                <h1>Gerar Relatório</h1>
            </div>
        </div>
        <section class="list-out-financial">
            <div class="form-style">
                <h2>Relatório Mensal</h2>
                <form action="generate_data.php" method="post">
                    <label id="solo-label" for="month">Mês:</label>
                    <select name="month" class="selectSearch" required>
                        <option></option>
                        <option value="Janeiro">Janeiro</option>
                        <option value="Fevereiro">Fevereiro</option>
                        <option value="Março">Março</option>
                        <option value="Abril">Abril</option>
                        <option value="Maio">Maio</option>
                        <option value="Junho">Junho</option>
                        <option value="Julho">Julho</option>
                        <option value="Agosto">Agosto</option>
                        <option value="Setembro">Setembro</option>
                        <option value="Outubro">Outubro</option>
                        <option value="Novembro">Novembro</option>
                        <option value="Dezembro">Dezembro</option>
                    </select>
                    <label id="solo-label-secondary" for="year">Ano:</label>
                    <input type="number" value="<?=$this_year;?>" name="year" required>
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
        | &copy; 2021 Todos os direitos reservados.</p>
    </footer>
    <script>
        $(document).ready(function() {
            $('.selectSearch').select2();
            $('#show-add-popup').click(function(){
                $('#open-add-popup').css('display', 'inherit');
            });
            $('#close-add-popup').click(function(){
                $('#open-add-popup').css('display', 'none');
            });
            $('#show-remove-popup').click(function(){
                $('#open-remove-popup').css('display', 'inherit');
            });
            $('#close-remove-popup').click(function(){
                $('#open-remove-popup').css('display', 'none');
            });
            $('#show-change-popup').click(function(){
                $('#open-change-popup').css('display', 'inherit');
            });
            $('#close-change-popup').click(function(){
                $('#open-change-popup').css('display', 'none');
            });
        });
    </script>
</body>
</html>