<?php
    include_once ("connection.php");
    include_once ("DAO/treatment_DAO.php");

    $id = $_GET['id'];

    $c = new connection();
    $conn = $c->connect();

    $t = new treatment_DAO();
    $t->treatment_delete($id, $conn);

    header("location:../treatments.php");
