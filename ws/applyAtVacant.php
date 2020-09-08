<?php
include_once('../persistencia/db.php');
date_default_timezone_set("America/Bogota");
session_start();

$fecha = date('Y-m-d H:i:s');


$cod=$_POST['cod'];

$response = [];
$sql = "CALL p_add_detail(".$cod.", ".$_SESSION['id'].", 'ENVIADA', '".$fecha."')";
if (!$mysqli->query($sql)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => 0
        );
    }else{
        $response = array(
            'error' => "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => 0
        );
    }
}else{
    $response = array(
    'comment' => "Se agregó satisfactoriamente",
    'status' => 1
    );
}

$mysqli->close();

echo json_encode($response);

?>
