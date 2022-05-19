<?php
    include_once ("pdo/connection.php");
    include_once ("pdo/DAO/costumer_DAO.php");
    include_once ("pdo/DAO/service_DAO.php");
    include_once ("pdo/DAO/product_DAO.php");
    include_once ("pdo/DAO/treatment_DAO.php");

    $c = new connection();
    $conn = $c->connect();

    $select = new costumer_DAO();
    $stmt = $select->costumers_list($conn);

    $select = new service_DAO();
    $stmt2 = $select->services_list($conn);

    $select = new product_DAO();
    $stmt3 = $select->product_list($conn);

    $select = new treatment_DAO();
    $stmt4 = $select->treatments_list($conn);
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
    <script src="js/jquery.maskedinput.js"></script>
    <link rel="icon" href="img/logo.png">
    <title>Lucia Reis | Atendimentos</title>
    <script> 
        var ids = [];
        var i = 0;
        var discount1 = false;
        var discount2 = false;
    </script>
</head>
<body class="list-main-section-form" id="background-type-treatment">
    <header>
        <div class="return">
            <a href="treatments.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="css/icons/return.json"
                    trigger="hover"
                    delay="1000"
                    colors="primary:#000,secondary:#ffffff"
                    style="width:30px;height:auto;padding-bottom:10px;padding-left:5px;">
                </lord-icon>
            </a>
        </div>
        <div class="title-form" id="treatment-title">
            <div class="main-text-title">
                <h1>Novo Atendimento</h1>
            </div>
        </div>
    </header>
    <main>
        <section class="list-out-form">
            <div class="form-style">
                <form action="pdo/confirm_treatment.php" method="post">
                    <h2>Cliente Existente</h2>
                    <label id="solo-label" for="costumer_name">Nome:</label> 
                    <select name="costumer" id="costumer" class="selectSearch">
                        <option value="null"></option>
                        <?php
                            foreach($stmt as $c){
                        ?>
                            <option value="<?=$c->id;?>"><?=$c->nome;?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <hr>
                    <h2>Nova Cliente</h2>

                    <div id="new_costumer">
                        <label for="c_name">Nome:</label>
                        <input type="text" name="c_name" placeholder="Nome do cliente">

                        <label for="phone_number">Celular:</label>
                        <input id="phone" type="text" name="phone_number" placeholder="Número de celular">

                        <label for="bdate">Data de Nascimento:</label>
                        <input type="date" name="bdate">
                    </div>
                    <hr>
                    <h2>Descontos</h2>
                    <p class="fake-button" id="discount-verificator">Verificar descontos</p>
                    <div id="discounts">
                        <p class="fake-label" id="discount1"></p><p class="fake-button" id="apply1"></p>
                        <p class="fake-label" id="discount2"></p><p class="fake-button" id="apply2"></p>
                        <div id="invisible-parm1">
                            <input type='hidden' name='birthday' value='Não'>
                        </div>
                        <div id="invisible-parm2">
                            <input type='hidden' name='assiduity' value='Não'>
                        </div>
                    </div>
                    <?php
                    
                    // Verificar clientes que possuem descontos -----------------------------

                    date_default_timezone_set('America/Sao_Paulo');
                    $this_day = date('d');
                    $this_month = date('m');
                    
                    foreach($stmt as $costumer){
                        $costumer_day = date('d',  strtotime($costumer->data_nasc));
                        $costumer_month = date('m', strtotime($costumer->data_nasc));
                        $assiduity = 0;
                        $discount1 = 'false';
                        $discount2 = 'false';
                        $activating = 'false';

                        if($this_day == $costumer_day && $this_month == $costumer_month){
                            $discount1 = 'true';
                            $activating = 'true';
                        }

                        foreach($stmt4 as $assid){
                            if($assid->id_cliente == $costumer->id){
                                $treatment_month = date('m', strtotime($assid->data_atendimento));

                                if($this_month == $treatment_month || $this_month-1 == $treatment_month){
                                    $assiduity++;
                                }
                            }
                        }

                        if($assiduity >  4){
                            $discount2 = 'true';
                            $activating = 'true';
                        }

                        if($activating == 'true'){
                        ?>
                            <script> 
                                ids[i] = c_list = [<?=$costumer->id;?>, <?=$discount1;?>, <?=$discount2;?>];
                                i += 1;
                            </script>
                        <?php
                        }
                    }

                    // ------------------------------------------------------------------------
                    ?>
                    <hr>
                    <h2>Serviços</h2>
                    <select id="services" name="services[]" class="selectSearch" multiple="multiple">
                        <?php
                            foreach($stmt2 as $s){
                        ?>
                            <option value="<?=$s->id;?>"><?=$s->servico;?>: R$ 
                            <?=number_format($s->valor, 2, ',');?>.</option>
                        <?php
                            }
                        ?>
                    </select>
                    
                    <div id="invisible-list">
                        <?php
                        // Lista invisivel de serviços para cálculo do valor final do atendimento

                            foreach($stmt2 as $serv){
                        ?>
                                <p id="service<?=$serv->id;?>" value="<?=$serv->valor;?>"></p>
                        <?php
                            }
                        
                        ?>
                    </div>
                    <hr>
                    <h2>Redução de estoque</h2>
                    <select name="products[]" class="selectSearch" multiple="multiple">
                        <?php
                            foreach($stmt3 as $p){
                        ?>
                            <option value="<?=$p->id;?>"><?=$p->nome;?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <hr>
                    <h2>Vendas Adicionais</h2>
                    <p class="fake-button" id="hide-sale-form"><a href="#cancel-sale" target="_self" >Não</a></p>
                    <p class="fake-button" id="show-sale-form">Sim</p>
                    <div id="confirm-sale">
                        <span>Origem:</span>
                        <input type="checkbox" id="lingerie" name="lingerie" value="Lingerie">
                        <label for="lingerie">Lingerie</label>

                        <input type="checkbox" id="purse" name="purse" value="Bolsas">
                        <label for="purse">Bolsas</label>
                        <br/>
                        <label for="other">Outro: </label>
                        <input type="text" name="other">

                        <label for="cash">Valor: R$</label>
                        <input id="sale-price" type="number" step=".01" name="cash">
                    </div>
                    <hr>
                    <h2 id="cancel-sale">Promoção</h2>
                    <p class="fake-button" id="hide-discount-form">
                        <a href="#cancel-discount" target="_self" >Não</a>
                    </p>
                    <p class="fake-button" id="show-discount-form">Sim</p>
                    <div id="confirm-discount">
                        <input id="off-percent" type="number" name="off_percent" placeholder="10">
                        <label for="off_percent">% OFF</label>
                        <p>ou</p>
                        <input id="off-value" type="number" step=".01" name="off_value" placeholder="20">
                        <label for="off_value">R$ OFF</label>
                    </div>
                    <hr>
                    <h2 id="cancel-discount">Método de pagamento</h2>
                    <select id="payment" name="payment" class="selectSearch">
                        <option value="Dinheiro">Dinheiro</option>
                        <option value="Pix">Pix</option>
                        <option value="Débito">Débito</option>
                        <option value="Crédito 1x">Crédito 1x</option>
                        <option value="Crédito 2x">Crédito 2x</option>
                        <option value="Crédito 3x">Crédito 3x</option>
                        <option value="Crédito 4x">Crédito 4x</option>
                        <option value="Crédito 5x">Crédito 5x</option>
                        <option value="Crédito 6x">Crédito 6x</option>
                        <option value="Crédito 7x">Crédito 7x</option>
                        <option value="Crédito 8x">Crédito 8x</option>
                        <option value="Crédito 9x">Crédito 9x</option>
                        <option value="Crédito 10x">Crédito 10x</option>
                    </select>
                    <hr>
                    <div id="#final-form">
                        <h2>Valor do Atendimento</h2>
                        <p id="final-price"></p>
                        <p class="fake-button" id="generate-final-price">Gerar valor do atendimento</p>
                        <input id="t-final-price" type="hidden" name="final_price" value="0">
                    </div>
                    <hr>
                    <br/>
                    <input id="button-color-treatment" type="submit" value="Finalizar Atendimento">
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
            $('#apply1').hide();
            $('#apply2').hide();
            $('.selectSearch').select2();
            $('#show-sale-form').click(function(){
                $('#confirm-sale').css('display', 'inherit');
            });
            $('#hide-sale-form').click(function(){
                $('#confirm-sale').css('display', 'none');
            });
            $('#show-discount-form').click(function(){
                $('#confirm-discount').css('display', 'inherit');
            });
            $('#hide-discount-form').click(function(){
                $('#confirm-discount').css('display', 'none');
            });
            $('#discount-verificator').click(function(){
                $('#discounts').css('display', 'inherit');
                var verifId = $('#costumer').children("option:selected").val();
                var verifText1 = 0;
                var verifText2 = 0;
                for(count = 0; count < i; count++){
                    if(verifId == ids[count][0]){
                        if(ids[count][1] == true){
                            $('#discount1').text('Desconto de aniversário: Disponível');
                            $('#discount1').css('color', 'black');
                            $('#apply1').show();
                            $('#apply1').text('Aplicar');
                            verifText1 = 1;
                        }
                        if(ids[count][2] == true){
                            $('#discount2').text('Desconto de assiduidade: Disponível');
                            $('#discount2').css('color', 'black');
                            $('#apply2').show();
                            $('#apply2').text('Aplicar');
                            verifText2 = 1;
                        }
                    }
                }
                if(verifText1 == 0){
                    $('#discount1').text('Desconto de aniversário: Indisponível');
                    $('#discount1').css('color', 'red');
                }
                if(verifText2 == 0){
                    $('#discount2').text('Desconto de assiduidade: Indisponível');
                    $('#discount2').css('color', 'red');
                }
            });
            $('#apply1').click(function(){
                discount1 = true;
                $('#discount1').text('Desconto de aniversário: Aplicado');
                $('#discount1').css('color', 'green');
                $('#apply1').hide();
                $('#invisible-parm1').html("<input type='hidden' name='birthday' value='Sim'>");
            });
            $('#apply2').click(function(){
                discount2 = true;
                $('#discount2').text('Desconto de assiduidade: Aplicado');
                $('#discount2').css('color', 'green');
                $('#apply2').hide();
                $('#invisible-parm2').html("<input type='hidden' name='assiduity' value='Sim'>");
            });
            $('#generate-final-price').click(function(){
                var finalPrice = 0.00;
                var servicesIds = $('#services').val();
                var servicesPrice = 0;
                var salesPrice = parseFloat($('#sale-price').val());
                var offPercent = $('#off-percent').val();
                var offValue = $('#off-value').val();
                var payment = $('#payment').children('option:selected').val();

                for(count = 0; count < servicesIds.length; count++){
                    servicesPrice += parseFloat($('#service'+servicesIds[count]).attr('value'));
                }
                if(Number.isNaN(salesPrice)){
                    salesPrice = 0;
                }
                if(offPercent == ""){
                    offPercent = 0;
                }
                if(offValue == ""){
                    offValue = 0;
                }
                if(payment == "Pix" || payment == "Débito" || payment == "Crédito 1x" || payment == "Dinheiro"){
                    var tax = 0;
                }
                else if(payment == "Crédito 2x" || payment == "Crédito 3x" || payment == "Crédito 4x" ||
                payment == "Crédito 5x" || payment == "Crédito 6x"){
                    var tax = 5;
                }
                else if(payment == "Crédito 7x" || payment == "Crédito 8x" || payment == "Crédito 9x" ||
                payment == "Crédito 10x"){
                    var tax = 6;
                }
                if(discount1 == true){
                    servicesPrice -= servicesPrice*0.1;
                }
                if(discount2 == true){
                    servicesPrice -= servicesPrice*0.05;
                }
                finalPrice += servicesPrice;
                finalPrice -= finalPrice*(offPercent/100);
                finalPrice -= offValue;
                finalPrice += salesPrice;
                finalPrice += finalPrice*(tax/100);
                if(finalPrice < 0){
                    finalPrice = 0;
                }
                $('#final-price').text('R$ '+finalPrice.toFixed(2).replace(".", ","));
                $('#t-final-price').val(finalPrice);
            });
        });
    </script>
</body>
</html>