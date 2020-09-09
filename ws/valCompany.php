<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once('../persistencia/db.php');


$response = [];

//info per

$id = $_POST["nitVal"];
$estado = $_POST["VEstado"];


$sql = "UPDATE EMPRESA SET estado = '".$estado."' WHERE NIT=".$id." ";

if (!$mysqli->query($sql)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => 0
        );
    }else{
        $response = array(
            'error' => "Falló valcompani CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => 0
        );
    }
}else{
        
    $response = array(
        'comment' => "Se actualizo satisfactoriamente",
        'status' => 1
    );
     
}

$mysqli->close();

echo json_encode($response);

?>