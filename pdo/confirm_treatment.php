<?php
    include_once ("connection.php");
    include_once ("classes/treatment.php");
    include_once ("DAO/treatment_DAO.php");
    include_once ("classes/costumer.php");
    include_once ("DAO/costumer_DAO.php");
    include_once ("classes/sale.php");
    include_once ("DAO/sale_DAO.php");
    include_once ("classes/financial.php");
    include_once ("DAO/financial_DAO.php");
    include_once ("classes/product.php");
    include_once ("DAO/product_DAO.php");

    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d');

    $c = new connection();
    $conn = $c->connect();

    $user_verificator = false;

    $acess = new costumer_DAO();

    $t = new treatment();

    if($_POST['costumer'] != 'null'){

        $user_verificator = true;

        $t->setCostumerId($_POST['costumer']);

        $costumer_name = $acess->get_costumer_name($conn, $_POST['costumer']);

        foreach($costumer_name as $c_name){
            $t->setCostumerName($c_name->nome);   
        }
    }
    else{
        if(isset($_POST['c_name'])&& $_POST['c_name'] != ""){

            $user_verificator = true;

            $cos = new costumer();
            $cos->setName($_POST['c_name']);
            $cos->setNumber($_POST['phone_number']);
            $cos->setBDate($_POST['bdate']);

            $result = $acess->insert_costumer($cos, $conn);

            $costumer_id = $acess->get_last_id($conn);
            foreach($costumer_id as $c_id){
                $id = $c_id->id;
            }

            $t->setCostumerName($_POST['c_name']);
            $t->setCostumerId($id);
        }   
    }

    $t->setBirthday($_POST['birthday']);
    $t->setAssiduity($_POST['assiduity']);

    if($_POST['off_percent'] == ""){
        $t->setPercentPromotion(0);
    }
    else{
        $t->setPercentPromotion($_POST['off_percent']);
    }

    if($_POST['off_value'] == ""){
        $t->setValuePromotion(0);
    }
    else{
        $t->setValuePromotion($_POST['off_value']);
    }

    $t->setPaymentMethod($_POST['payment']);
    $t->setTreatmentPrice($_POST['final_price']);
    $t->setTreatmentDate($date);

    if($user_verificator == true){
        $insert = new treatment_DAO();
        $result = $insert->insert_treatment($t, $conn);
    }

    $select = new treatment_DAO();
    $treatment_id = $select->get_last_id($conn);

    foreach($treatment_id as $id){
        $t_id = $id->id;
    }

    if(isset($_POST['products'])){
        foreach($_POST['products'] as $products){
            $fill = $insert->insert_treatment_products($products, $t_id, $conn);

            $select = new product_DAO();
            $stmt = $select->decrease_product_unity($conn, $products);
        }
    }
    if(isset($_POST['services'])){
        foreach($_POST['services'] as $services){
            $fill = $insert->insert_treatment_services($services, $t_id, $conn);
        }
    }

    if(isset($_POST['cash'])&& $_POST['cash'] != ""){
        $s = new sale();

        $sale_cash = $_POST['cash'];

        $check = '';
        $itens = 0;
        
        if(empty($_POST['lingerie']) && empty($_POST['purse']) && empty($_POST['other'])){
            $check = 'Não especificado';
        }
        else{
            if(isset($_POST['lingerie'])){
                $check = 'Lingerie';
                $itens += 1;
            }
            if(isset($_POST['purse'])){
                if($itens>0){
                    $check = $check.', Bolsas';
                    $itens += 1;
                }
                else{
                    $check = 'Bolsas';
                    $itens += 1;
                }
            }
            if(isset($_POST['other'])&& $_POST['other'] != ""){
                if($itens>0){
                    $check = $check.', '.$_POST['other'];
                    $itens += 1;
                }
                else{
                    $check = $_POST['other'];
                    $itens += 1;
                }
            }
        }
        
        $s->setValue($sale_cash);
        $s->setOrigin($check);
        $s->setSaleDate($date);

        $sale_insert = new sale_DAO();
        $stmt = $sale_insert->insert_sale($s, $conn);

        $select = new sale_DAO();
        $sale_id = $select->get_last_id($conn);

        foreach($sale_id as $sales){
            $fill = $insert->insert_treatment_sales($sales->id, $t_id, $conn);
        }
    }
    else{
        $sale_cash = 0;
    }
    $select = new financial_DAO();
    $current_cash = $select->get_financial_data($conn);

    foreach($current_cash as $cash){
        $weekly_cash = $cash->entrada_semanal;
    }

    $payment = $_POST['payment'];

    if($payment == "Pix" || $payment == "Débito"){
        $tax = 1;
    }
    else if($payment == "Crédito 1x"){
        $tax = 4;
    }
    else if($payment == "Dinheiro"){
        $tax = 0;
    }
    else{
        $tax = 5;
    }

    $final_cash = $_POST['final_price'];
    $final_cash -= ($final_cash*($tax/100));

    $new_cash = $weekly_cash+$final_cash;

    $f = new financial();
    $f->setCashIncome($new_cash);

    $edit = new financial_DAO();
    $stmt = $edit->edit_cash_income($f, $conn);

    if(empty($result)){
        $result = 2;
    }

    if($result == 1){
        $message = "Sucesso! O Atendimento foi registrado com êxito.";
    }
    else if($result == 0){
        $message = "Erro! Verifique se o servidor foi inicializado corretamente.";
    }
    else if($result == 2){
        $message = "Erro desconhecido! Verifique um possível problema e tente novamente.";
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
    <title>Lucia Reis | Atendimentos</title>
</head>
<body class="list-main-section-form" id="background-type-treatment">
    <header>
        <div class="return">
            <a href="../treatments.php" title="Voltar" target="_self" rel="prev">
                <lord-icon src="../css/icons/return.json"
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
                <p><?=$message?></p>
                <a href="../new_treatment.php" target="_self" rel="prev">Registrar outro atendimento</a>
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