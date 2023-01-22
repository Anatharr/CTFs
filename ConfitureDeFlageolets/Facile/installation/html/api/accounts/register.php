<?php
    session_start();
    // include database and object files
    include_once '../config/database.php';

    // Handle CORS Policy errors
    header("Access-Control-Allow-Origin: *");
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }


    if ($_SERVER['REQUEST_METHOD']!='POST') {
        $log_array = array(
            "status"=>false,
            "message"=>"Méthode non authorisée."
        );
        die(json_encode($log_array));
    }

    $_POST = json_decode(file_get_contents('php://input'), true);

    if ($_POST === null) {
        $log_array = array(
            "status"=>false,
            "message"=>"JSON Invalide."
        );
        die(json_encode($log_array));
    }
    if (!isset($_POST['username']) or empty($_POST['username'])){
        $log_array = array(
            "status"=>false,
            "message"=>"Champ username vide.",
            );
        die(json_encode($log_array));
    }
    if (!isset($_POST['password']) or empty($_POST['password'])){
        $log_array = array(
            "status"=>false,
            "message"=>"Champ password vide."
            );
        die(json_encode($log_array));
    }

    // get database connection
    $db = (new Database())->getConnection();

    $username = $_POST['username'];
    $pass     = $_POST['password']; // Il faudrait chiffrer le mot de passe avant de l'envoyer


    $check_account_query = "select * from accounts where username=$1";
    $check_account_result = pg_prepare($db,'check_account_query', $check_account_query);

    if(!$check_account_result) {
        $log_array = array(
            "status"=>false,
            "message"=>"La création de la requête SQL a échoué."
            );
        die(json_encode($log_array));
    }

    $check_account_result = pg_execute($db, 'check_account_query', array($username));
    $rows = pg_num_rows($check_account_result);

    if($rows >= 1){
        $log_array = array(
            "status"=>false,
            "message"=>"Ce nom d'utilisateur existe déjà."
        );
        die(json_encode($log_array));
    }
    else{
        $query = "insert into accounts values ($1,crypt($2, gen_salt('".'bf'."')))";
        $result = pg_prepare($db,'register_query', $query);

        if(!$result) {
            $log_array = array(
                "status"=>false,
                "message"=>"La création de la requête SQL a échoué."
            );
            die(json_encode($log_array));
        }

        $result = pg_execute($db, 'register_query', array($username, $pass));


        if($result){
            $log_array = array(
                "status"=>true,
                "user"=>$username,
                "message"=>"Success."
            );
        }
        else{
            $log_array = array(
                "status"=>false,
                "message"=>"Error."
            );
        }

        echo json_encode($log_array);
    }
?>
