<?php
include_once('../persistencia/db.php');
date_default_timezone_set("America/Bogota");
session_start();

$fecha = date('Y-m-d H:i:s');


$e=$_POST['cod_estudiante'];
$c=$_POST['cod_vacante'];
$est=$_POST['estado'];



$response = [];
if($est=='ACEPTADA'){
    $sql = "UPDATE DETALLE SET estado='RECHAZADA' WHERE cod_estudiante=".$e.";";  
    $mysqli->query($sql); 
}
$sql2 = "UPDATE DETALLE SET estado='".$est."' WHERE cod_vacante=".$c." AND cod_estudiante=".$e;
if (!$mysqli2->query($sql2)) {
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
$mysqli2->close();

echo json_encode($response);

?>
