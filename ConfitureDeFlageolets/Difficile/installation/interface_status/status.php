<?php
session_start();

    //IP and PORT of the server that provide the status of the cameras
    $SEVER_IP = '127.0.0.1';
    $SERVER_PORT = '1234';
    $password = 'azerty';


    if(isset($_GET['camera_name']) && !empty($_GET['camera_name']) && isset($_GET['password']) && $_GET['password'] == $password ){
        
        $query = 'echo "'.$_GET['camera_name'].'" | nc '.$SEVER_IP.' '.$SERVER_PORT.' ';

        $status = system($query, $res);
        echo $status;
    }

?>