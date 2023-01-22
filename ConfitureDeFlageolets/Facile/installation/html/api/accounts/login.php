<?php
    session_start();
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


    $query = "select username from accounts where username='".$username."' and password=crypt('".$pass."',password)";

    $result = pg_query($db, $query);

    if(!$result) {
        $log_array = array(
            "status"=>false,
            "message"=>"L'exécution de la requête SQL a échoué."
            );
        die(json_encode($log_array));
    }

    $rows = pg_num_rows($result);

    if($rows === 1){
        $row = pg_fetch_row($result);
        $log_array = array(
            "status"=>true,
            "user"=>$row[0],
            "message"=>"Succès."
        );
        $_SESSION["name"] = $username;
    }
    else{
        $log_array = array(
            "status"=>false,
            "message"=>"Nom d'utilisateur ou mot de passe incorrect."
        );
    }

    echo json_encode($log_array);
    // envoie les données au navigateur
?>
