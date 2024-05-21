<?php
    session_start();
    if (!isset($_SESSION["auth"])) die(json_encode(['data' => ['err' => true, 'message' => "Session not set"]]));
    if (!$_SESSION["auth"]) die(json_encode(['data' =>['err' => true, 'message' => "Unauthorized user"]]));
    include_once '../../config/Database.php';
    include_once '../../models/Cars.php';
   

    $database = new Database();
    $db = $database->getConnection();
    $Cars = new Cars($db);
    switch ($_POST['query']) {
        case 1:
            echo $Cars->create($_POST);
        break;
        case 2:
            echo $Cars->read($_POST);
        break;
        case 3:
            echo $Cars->update($_POST);
        break;
        case 4:
            echo $Cars->delete($_POST);
        break;    
    }