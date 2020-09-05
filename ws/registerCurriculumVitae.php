<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
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
$nombre = $_POST["name"];
$id = $_POST["cod_estu"];
$residence = $_POST["residence"];
$ppro = $_POST["ppro"];
$document = $_POST["document"];
$dId = $_POST["document_id"];
$semester = $_POST["semester"];
$courses = $_POST["courses"];
$expAca = $_POST["expAca"];
$expLab = $_POST["cargo"];
$ref = $_POST["references"];
$foto = '';

// $image= ($FILES['photo']['name']==null) ? imageDefecto.png :  $FILES['photo']['name'];
if($_FILES["photo"]["name"]){
    $foto = removeAccents(str_replace(' ', '', $nombre)) . ".png";
    $img = "../assets/images/profile/" . removeAccents(str_replace(' ', '', $nombre)) . ".png";
    file_put_contents($img, file_get_contents($_FILES["photo"]["tmp_name"]));
}

$sql = "INSERT INTO HOJA_VIDA (lugar_de_residencia, perfil_profesional, tipo_documento, numero_documento, educacion, informacion_complementaria, experiencia_laboral, experiencia_academica, referencias ) 
VALUES ('".$residence."', '".$ppro."', '".$document."', '".$dId."','".$semester."','".$courses."','".$expLab."','".$expAca."','".$ref."');";

$sql2="UPDATE ESTUDIANTE SET cod_hv=LAST_INSERT_ID(), semestre='".$semester."' ,estado='INSCRITO', foto='".$foto."' WHERE cod_estudiante=75;";

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
}elseif (!$mysqli->query($sql2)) {
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
    
    $_SESSION['redirect']="studentHome.php";
    $response = array(
        'comment' => "Se agregó satisfactoriamente",
        'status' => 1
    );
     
}

$mysqli->close();

echo json_encode($response);

?>