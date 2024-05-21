<?php
    session_start();
    include_once '../../config/Database.php';
    include_once '../../models/Users.php';
    $database = new Database();
    $db = $database->getConnection();
    $Users = new Users($db);
    echo $Users->read($_POST);
