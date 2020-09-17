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

//info per
$nombre = $_POST["name"];
$id = $_POST["cod_estu"];
$document = $_POST["document"];
$dId = $_POST["document_id"];
$telephone = $_POST["telephone"];
$residence = $_POST["residence"];
$address = $_POST["address"];
$residence = $residence.'<br>'.$address;
$foto = '';

//perfil profe
$ppro = $_POST["ppro"];

//formacion academica
$semester = $_POST["semester"];
$startDateAca = $_POST["startDateAca"];

//formacion compelmentaria
$languages = $_POST["languages"];
$courses = $_POST["courses"];
$courses = $courses.'<br>'.$languages;

//experiencia academica
$tituloP = $_POST["tituloP"];
$materia = $_POST["materia"];
$periodo = $_POST["periodo"]; // REGEX [0-9]{4}(-|)[0]{1}[1-2]{1}

$expAca = $_POST["expAca"];

$expAcademica = $tituloP."<br>".$materia."<br>".$periodo."<br>".$expAca;

//experiencia laboral
$cargo = $_POST["cargo"];
$company = $_POST["company"];
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];
$functions = $_POST["functions"];

$expLaboral = $cargo."<br>".$company."<br>".$startDate."<br>".$endDate."<br>".$functions;

//referencias
$nomR1 = $_POST["nombreRef1"];
$carR1 = $_POST["cargoRef1"];
$numR1 = $_POST["numeroRef1"];

$nomR2 = $_POST["nombreRef2"];
$carR2 = $_POST["cargoRef2"];
$numR2 = $_POST["numeroRef2"];

$Referencias = $nomR1."<br>".$carR1."<br>".$numR1."<br>".$nomR2."<br>".$carR2."<br>".$numR1;

   
$sql = "INSERT INTO HOJA_VIDA (lugar_de_residencia, perfil_profesional,numero_telefono, tipo_documento, numero_documento, educacion, informacion_complementaria, experiencia_laboral, experiencia_academica, referencias ) 
VALUES ('".$residence."', '".$ppro."', '".$telephone."', '".$document."', '".$dId."','".$startDateAca."','".$courses."','".$expLaboral."','".$expAcademica."','".$Referencias."');";

$sql2="UPDATE ESTUDIANTE SET cod_hv=LAST_INSERT_ID(), semestre='".$semester."' ,estado='INSCRITO', foto='".$foto."' WHERE cod_estudiante=".$_SESSION['id'].";";

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