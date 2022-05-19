<?php

    include_once ("connection.php");
    include_once ("classes/expense.php");
    include_once ("classes/financial.php");
    include_once ("DAO/expense_DAO.php");
    include_once ("DAO/financial_DAO.php");

    if(isset($_POST['cash'], $_POST['current_cash'])&& $_POST['cash'] != "" && $_POST['current_cash'] != ""){

        $c = new connection();
        $conn = $c->connect();

        $e = new expense();

        $new_cash = $_POST['cash'];
        if(isset($_POST['description'])&& $_POST['description'] !=""){
            $description = $_POST['description'];
        }
        else{
            $description = "-";
        }

        date_default_timezone_set('America/Sao_Paulo');
        $expense_date = date('Y-m-d');

        $e->setCash($new_cash);
        $e->setDescription($description);
        $e->setExpenseDate($expense_date);

        $insert = new expense_DAO();
        $stmt = $insert->insert_expense($e, $conn);

        $new_cash = $_POST['current_cash']+$_POST['cash'];

        $f = new financial();
        $f->setCashOutflow($new_cash);

        $edit = new financial_DAO();
        $stmt = $edit->edit_cash_outflow($f, $conn);

        header("location: ../financial_data.php");
    }
    else{
        header("location: ../financial_data.php");
    }
