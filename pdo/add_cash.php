<?php

    include_once ("connection.php");
    include_once ("classes/sale.php");
    include_once ("classes/financial.php");
    include_once ("DAO/sale_DAO.php");
    include_once ("DAO/financial_DAO.php");

    if(isset($_POST['cash'], $_POST['current_cash'])&& $_POST['cash'] != "" && $_POST['current_cash'] != ""){

        $c = new connection();
        $conn = $c->connect();

        $s = new sale();

        $new_cash = $_POST['cash'];

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
        
        date_default_timezone_set('America/Sao_Paulo');
        $sale_date = date('Y-m-d');
        
        $s->setValue($new_cash);
        $s->setOrigin($check);
        $s->setSaleDate($sale_date);

        $insert = new sale_DAO();
        $stmt = $insert->insert_sale($s, $conn);

        $new_cash = $_POST['current_cash']+$_POST['cash'];

        $f = new financial();
        $f->setCashIncome($new_cash);

        $edit = new financial_DAO();
        $stmt = $edit->edit_cash_income($f, $conn);

        header("location: ../financial_data.php");
    }
    else{
        header("location: ../financial_data.php");
    }
