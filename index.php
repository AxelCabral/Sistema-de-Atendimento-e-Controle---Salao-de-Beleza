<?php
    include_once ("pdo/connection.php");
    include_once ("pdo/DAO/financial_DAO.php");
    include_once ("pdo/DAO/product_DAO.php");
    include_once ("pdo/classes/financial.php");
    
    //Notificações
    $notify1 = false; //Meta semanal não atingida
    $notify2 = false; //Caixa com dinheiro negativo
    $notify3 = false; //Problemas no estoque (produtos em falta)

    //Conferir se já se passou 1 semana, para atualizar atuomáticamente os dados semanais

    $c = new connection();
    $conn = $c->connect();

    $select = new financial_DAO();
    $stmt = $select->get_financial_data($conn);

    foreach($stmt as $i){
        $last_day = $i->ultimo_dia;
        $w_goal = $i->meta_semanal;
        $w_cash_income = $i->entrada_semanal;
        $w_cash_outflow = $i->saida_semanal;
    }

    date_default_timezone_set('America/Sao_Paulo');

    $days = date('d', strtotime($last_day));
    $months = date('m', strtotime($last_day));
    $years = date('Y', strtotime($last_day));
    $last_week = ($years*365)+($months*30)+$days;

    $this_days = date('d');
    $this_months = date('m');
    $this_years = date('Y');
    $this_week = ($this_years*365)+($this_months*30)+($this_days);

    if($this_week-7 >= $last_week){
        $last_date = strtotime($last_day);
        $new_date = strtotime("+7 day", $last_date);
        $new_date = date('Y-m-d', $new_date);
        
        $new_date = new DateTime($new_date);
        $str_date = $new_date->format('Y-m-d');

        $f = new financial();
        $f->setLastDate($str_date);
        $f->setCashOutflow(0);
        $f->setCashIncome(0);

        $stmt = $select->reset_information($f, $conn);
    }
    ///////////////////////////////////////////////

    //Notificação 1 (Meta não atingida faltando 1 dia para finalizar)
    $w_cash = $w_cash_income-$w_cash_outflow;

    if($this_week-6 >= $last_week && $w_cash<$w_goal){
        $notify1 = true;
    }
    ///////////////////////////////////////////////

    //Notificação 2 (Caixa negativo)
    if($w_cash_income < $w_cash_outflow){
        $notify2 = true;
    }
    ///////////////////////////////////////////////

    //Notificação 3 (Problemas de estoque)
    $c = new connection();
    $conn = $c->connect();

    $select = new product_DAO();
    $p_stmt = $select->get_product_problems($conn);

    if($p_stmt != null){
        $notify3 = true;
    }
    ///////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" />
    <link rel="icon" href="img/logo.png">
    <!-- Plugin JQuery Select2 -->
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="js/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="js/select2.min.js"></script>
    <!-- ----------------------- -->  
    <script src="js/lord-icon.js"></script>
    <title>Lucia Reis | Página Inicial</title>
</head>
<body>
    <header class="menu">
        <section>
            <div id="logo-outside">
                <img id="index-logo" src="img/logo-full.png" alt="Espaço da Beleza Lucia Reis">
            </div>
            <nav class="menu-options">
                <h2>Menu</h2>
                <div class="options">
                    <a href="products.php" id="product" target="_self" rel="next">Estoque
                        <lord-icon id="product-anim" src="css/icons/box.json"
                        trigger="none"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:auto;padding-bottom:5px;">
                        </lord-icon>
                    </a>
                </div>
                <div class="options">
                    <a href="financial_data.php" id="financial" target="_self" rel="next">Financeiro
                        <lord-icon id="financial-anim" src="css/icons/econom.json"
                        trigger="none"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:auto;padding-bottom:5px;">
                        </lord-icon>
                    </a>
                </div>
                <div class="options">
                    <a href="treatments.php" id="treatment" target="_self" rel="next">Atendimentos
                        <lord-icon id="treatment-anim" src="css/icons/demand.json"
                        trigger="none"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:auto;padding-bottom:5px;">
                        </lord-icon>
                    </a>
                </div>
                <div class="options">
                    <a href="costumers.php" id="costumer" target="_self" rel="next">Clientes
                        <lord-icon id="costumer-anim" src="css/icons/female-costumer.json"
                        trigger="none"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:auto;padding-bottom:5px;">
                        </lord-icon>
                    </a>
                </div>
                <div class="options"> 
                    <a href="services.php" id="service" target="_self" rel="next">Serviços
                        <lord-icon id="service-anim" src="css/icons/placa.json"
                        trigger="none"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:auto;padding-bottom:5px;">
                        </lord-icon>
                    </a>
                </div>
                <div class="options">
                    <a href="backup.php" id="backup" target="_blank" rel="next">Backup
                        <lord-icon id="backup-anim" src="css/icons/data-server.json"
                        trigger="none"
                        colors="primary:#ffffff,secondary:#ffffff"
                        style="width:40px;height:auto">
                        </lord-icon>
                    </a>
                </div>
            </nav>
        </section>
    </header>
    <main>
        <section id="main-section">
            <img id="main-image" src="img/fundo-index.jpg" alt="imagem-pricipal">
            <div id="notify-text">
                <div id="popup-notify">
                    <p id="close-notify">X</p>
                    <?php
                        $notify_count = 0;
                        if($notify1 == true){
                            $notify_count ++;
                    ?>
                        <p class="single-notify">Notificação: A sua meta semanal ainda não foi atingida.</p>
                    <?php
                        }
                        if($notify2 == true){
                            $notify_count ++;
                    ?>
                        <p class="single-notify">Notificação: O seu caixa semanal está com dinheiro negativo.</p>
                    <?php
                        }
                        if($notify3 == true){
                            foreach($p_stmt as $prob){
                                $notify_count ++;
                                $p_id = $prob->id;
                                $p_name = $prob->nome;
                    ?>
                        <p>Notificação: O seu estoque apresenta problemas. O produto <?=$p_id;?>: <?=$p_name?>,
                        excedeu o mínimo de quantidade em estoque, compre para repor. 
                        <a href="products.php">Ir para o estoque</a></p>
                        <br>
                        <hr>
                        <br>
                    <?php
                            }
                        }
                        if($notify_count > 4){
                            $notify_count = '4';
                        }
                        if($notify_count < 1){
                            $notify_count = '';
                    ?>
                        <p>Você não possui Notificações.</p>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="inside-options">
                <h1>Espaço da Beleza Lucia Reis</h1>
                <div class="inside-option">
                    <div class="button">
                        <a href="new_treatment.php" id="new-treatment" target="_self" rel="next">Novo Atendimento
                            <lord-icon id="new-treatment-anim" src="css/icons/plus.json"
                            trigger="none"
                            colors="primary:#ffffff,secondary:#ffffff"
                            style="width:40px;height:auto">
                            </lord-icon>
                        </a>
                    </div>
                    <div class="button">
                        <a id="open-notify">Notificações
                            <img id="lord-icon" src="img/bell-icon-<?=$notify_count;?>.png" alt="icon">
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p id="footer-text">Espaço da Beleza Lucia Reis - Santana do Livramento, RS 
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
            $('#costumer').mouseover(function(){
                $('#costumer-anim').attr("trigger", "loop");
            });
            $('#costumer').mouseleave(function(){
                $('#costumer-anim').attr("trigger", "none");
            });
            $('#treatment').mouseover(function(){
                $('#treatment-anim').attr("trigger", "loop");
            });
            $('#treatment').mouseleave(function(){
                $('#treatment-anim').attr("trigger", "none");
            });
            $('#backup').mouseover(function(){
                $('#backup-anim').attr("trigger", "loop");
            });
            $('#backup').mouseleave(function(){
                $('#backup-anim').attr("trigger", "none");
            });
            $('#service').mouseover(function(){
                $('#service-anim').attr("trigger", "loop");
            });
            $('#service').mouseleave(function(){
                $('#service-anim').attr("trigger", "none");
            });
            $('#financial').mouseover(function(){
                $('#financial-anim').attr("trigger", "loop");
            });
            $('#financial').mouseleave(function(){
                $('#financial-anim').attr("trigger", "none");
            });
            $('#product').mouseover(function(){
                $('#product-anim').attr("trigger", "loop");
            });
            $('#product').mouseleave(function(){
                $('#product-anim').attr("trigger", "none");
            });
            $('#open-notify').click(function(){
                $('#notify-text').css('display', 'inherit');
                $('.inside-options').css('display', 'none');
            });
            $('#close-notify').click(function(){
                $('#notify-text').css('display', 'none');
                $('.inside-options').css('display', 'inherit');
            });
        });
    </script>
</body>
</html>