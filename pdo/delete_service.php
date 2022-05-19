<?php
    include_once ("connection.php");
    include_once ("DAO/service_DAO.php");

    $id = $_GET['id'];

    $c = new connection();
    $conn = $c->connect();

    $ser = new service_DAO();
    $ser->service_delete($id, $conn);

    header("location:../services.php");
