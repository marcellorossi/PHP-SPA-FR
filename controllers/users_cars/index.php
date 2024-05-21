<?php
    session_start();
    if (!isset($_SESSION["auth"])) die(json_encode(['data' => ['err' => true, 'message' => "Session not set"]]));
    if (!$_SESSION["auth"]) die(json_encode(['data' =>['err' => true, 'message' => "Unauthorized user"]]));
    include_once '../../config/Database.php';
    include_once '../../models/Users_Cars.php';
   

    $database = new Database();
    $db = $database->getConnection();
    $users_cars = new users_cars($db);
    switch ($_POST['query']) {
        case 1:
            echo $users_cars->create($_POST);
        break;
        case 2:
            echo $users_cars->read($_POST);
        break;
        case 3:
            echo $users_cars->update($_POST);
        break;
        case 3:
            echo $users_cars->delete($_POST);
        break;
        case 4:
            $create = $users_cars->create($_POST);
            if (isset($create['data']['error'])) {
                echo $create['data']['error'];
            } else {
                echo  $users_cars->read($_POST);
            }
        break;
        case 5:
            $create = $users_cars->delete($_POST);
            if (isset($create['data']['error'])) {
                echo $create['data']['error'];
            } else {
                echo  $users_cars->read($_POST);
            }
        break;        
    }
    




    

