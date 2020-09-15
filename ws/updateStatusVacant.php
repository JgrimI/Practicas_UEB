<?php
include_once('../persistencia/db.php');
date_default_timezone_set("America/Bogota");
session_start();

$fecha = date('Y-m-d H:i:s');


$e=$_POST['cod_estudiante'];
$c=$_POST['cod_vacante'];
$est=$_POST['estado'];



$response = [];
$sql = "UPDATE DETALLE SET estado='".$est."' WHERE cod_vacante=".$c." AND cod_estudiante=".$e;
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
    if(isset($_POST['motivos'])){
        $aDoor = $_POST['motivos'];
        if(!empty($aDoor)){
            $N = count($aDoor);
            for($i=0; $i < $N; $i++){
                $otros=($aDoor[$i]==5) ? $_POST['otrosTxt'] : '';
                $add="INSERT INTO DETALLE_RECHAZO VALUES (".$c.",".$e.",".$aDoor[$i].",'".$otros."');";
                $mysqli2->query($add);

            }
            $response = array(
                'comment' => "Se agregó satisfactoriamente",
                'status' => 1
                );
        }
    }else{
        $response = array(
        'comment' => "Se agregó satisfactoriamente x",
        'status' => 1
        );
    }
}

$mysqli->close();
$mysqli2->close();

echo json_encode($response);

?>
