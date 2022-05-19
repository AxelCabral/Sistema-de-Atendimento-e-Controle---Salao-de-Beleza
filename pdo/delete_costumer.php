<?php
    include_once ("connection.php");
    include_once ("DAO/costumer_DAO.php");

    $id = $_GET['id'];

    $c = new connection();
    $conn = $c->connect();

    $cos = new costumer_DAO();
    $cos->costumer_delete($id, $conn);

    header("location:../costumers.php");
