<?php

    include_once ("connection.php");
    include_once ("classes/product.php");
    include_once ("DAO/product_DAO.php");

    if(isset($_POST['unitys'], $_POST['id'], $_POST['current_unitys'])&& $_POST['unitys'] != "" 
    && $_POST['id'] != "" && $_POST['current_unitys'] != ""){

        $id = $_POST['id'];

        $c = new connection();
        $conn = $c->connect();

        $new_unitys = $_POST['current_unitys']+$_POST['unitys'];

        $p = new product();
        $p->setQuantity($new_unitys);

        $edit = new product_DAO();
        $stmt = $edit->edit_product_unitys($id, $p, $conn);

        header("location: ../products.php");
    }
    else{
        header("location: ../products.php");
    }
