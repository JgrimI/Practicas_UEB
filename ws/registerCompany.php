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

$razon = $_POST["nameCp"];
$nit = $_POST["nitCp"];
$logo = '';
$mail = $_POST["mailCp"];
$descripcion = $_POST["desCp"];
$cc='';
$pass = $_POST["passCp"];

if($_FILES["logo"]["name"]){
    $logo = removeAccents(str_replace(' ', '', $razon)) . ".png";
    $img = "../assets/images/logos/" . removeAccents(str_replace(' ', '', $razon)) . ".png";
    file_put_contents($img, file_get_contents($_FILES["logo"]["tmp_name"]));
}

if($_FILES["cc"]["name"]){
    $cc = removeAccents(str_replace(' ', '', $razon)) . ".pdf";
    $img = "../assets/images/cc/" . removeAccents(str_replace(' ', '', $razon)) . ".pdf";
    file_put_contents($img, file_get_contents($_FILES["cc"]["tmp_name"]));
}

$response = [];
$sql = "CALL p_add_company('".$nit."', '".$razon."', '".$pass."', '".$mail."','".$logo."','".$descripcion."','".$cc."')";
if (!$mysqli->query($sql)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => false
        );
    }else{
        $response = array(
            'error' => "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => false
        );
    }
}else{
    $response = array(
        'comment' => 'Se agregó satisfactoriamente',
        'status' => true
    );
}

$mysqli->close();

echo json_encode($response);

?>