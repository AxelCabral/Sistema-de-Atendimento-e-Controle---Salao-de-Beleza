<?php

    include_once ("connection.php");
    include_once ("classes/financial.php");
    include_once ("DAO/financial_DAO.php");

    if(isset($_POST['new_goal'])&& $_POST['new_goal'] != ""){

        $c = new connection();
        $conn = $c->connect();

        $f = new financial();
        $f->setWeeklyGoal($_POST['new_goal']);

        $edit = new financial_DAO();
        $stmt = $edit->edit_goal($f, $conn);

        header("location: ../financial_data.php");
    }
    else{
        header("location: ../financial_data.php");
    }
