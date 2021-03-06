<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../persistencia/db.php');

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';


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
$nit = $_POST["nit"];
$razon = $_POST["razonSocial"];
$logo = '';
$email = $_POST["email"];
$descripcion = $_POST["descrip"];
$pass = $_POST["pass_1"];
$logo='';

if( $_FILES["logo"]["name"]){
    $logo = removeAccents(str_replace(' ', '', $razon)) . ".png";
    $img = "../assets/images/logos/".removeAccents(str_replace(' ', '', $razon)).".png";
    file_put_contents($img, file_get_contents($_FILES["logo"]["tmp_name"]));
}
$response = [];
$addLogo=($logo=='') ? '' :', logo="'.$logo.'"';
$sql = "UPDATE EMPRESA  SET  nombre='".$razon."', correo_empresa='".$email."' , descripcion_empresa='".$descripcion."', password_empresa='".$pass."' ".$addLogo." WHERE NIT = '".$nit."' ;";
$_SESSION['nombre']=$razon;
$_SESSION['correo']=$email;
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
        'comment' => "Se Actualizo satisfactoriamente",
        'status' => 1
    );
  
     
}

$mysqli->close();

echo json_encode($response);

?>