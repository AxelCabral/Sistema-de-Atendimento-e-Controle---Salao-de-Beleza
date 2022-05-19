<?php
    include_once ('DAO/costumer_DAO.php');
    include_once ('DAO/treatment_DAO.php');
    include_once ('connection.php');
    
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d');
    $this_month = date('m');
    $assiduity = 0;

    $id = $_GET['id'];
    if(isset($id)){

        $disc = [false, false];

        $c = new connection();
        $conn = $c->connect();

        $disc = new costumer_DAO();
        $stmt = $disc->verify_disc($conn, $id);

        foreach($stmt as $costumer){
            if($date == $costumer->data_nasc){
                $disc[0] = true;
            }
        }

        $disc2 = new treatment_DAO();
        $stmt = $disc2->verify_disc($conn, $id);

        foreach($stmt as $assid){
            $m = date('m', strtotime($assid->data_atendimento));
            if($this_month == $m || $this_month-1 == $m){
                $assiduity++;
            }
        }
        if($assiduity > 4){
            $disc[1] = true;
        }

        return true;
    }
    else{
        return false;
    }
