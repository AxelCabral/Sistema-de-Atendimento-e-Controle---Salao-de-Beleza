<?php
    include_once ("connection.php");
    include_once ("DAO/product_DAO.php");

    $id = $_GET['id'];

    $c = new connection();
    $conn = $c->connect();

    $p = new product_DAO();
    $p->product_delete($id, $conn);

    header("location:../products.php");
