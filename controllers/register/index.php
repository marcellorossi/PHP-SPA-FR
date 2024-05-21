<?php
   
    include_once '../../config/Database.php';
    include_once '../../models/Users.php';
    $database = new Database();
    $db = $database->getConnection();
    $Users = new Users($db);
    $_SESSION["register"] = $Users->create($_POST);
    echo $_SESSION["register"];