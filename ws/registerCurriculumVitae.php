<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../persistencia/db.php');

function removeAccents($input){
    $output = "";
    $output = str_replace("á", "a", $input);
    $output = str_replace("é", "e", $output);
    $output = str_replace("í", "i", $output);
    $output = str_replace("ï", "i", $output);
    $output = str_replace("ì", "i", $output);
    $output = str_replace("ó", "o", $output);
    $output = str_replace("ú", "u", $output);
    $output = str_replace("ñ", "n", $output);
    $output = str_replace("Á", "a", $output);
    $output = str_replace("É", "e", $output);
    $output = str_replace("Í", "i", $output);
    $output = str_replace("Ó", "o", $output);
    $output = str_replace("Ú", "u", $output);
    $output = str_replace("Ñ", "n", $output);
    $output = str_replace("ü", "u", $output);
    return $output;
}

$response = [];
$residence = $_POST["residence"];
$ppro = $_POST["ppro"];
$document = $_POST["document"];
$dId = $_POST["document_id"];
$semester = $_POST["semester"];
$courses = $_POST["courses"];
$expAca = $_POST["expAca"];
$expLab = $_POST["cargo"];
$ref = $_POST["references"];

$sql = "INSERT INTO HOJA_VIDA (lugar_de_residencia, perfil_profesional, tipo_documento, numero_documento, educacion, informacion_complementaria, experiencia_laboral, experiencia_academica, referencias )
 VALUES ('".$residence."', '".$ppro."', '".$document."', '".$dId."','".$semester."','".$courses."','".$expLab."','".$expAca."','".$ref."')";
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