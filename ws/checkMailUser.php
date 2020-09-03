<?php
include_once('../persistencia/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Bogota");

$username = $_POST["username"];
$password = $_POST["password"];
$fecha = date('Y-m-d');
$response = [];

$query = "SELECT cod_estudante, estado from ESTUDIANTE";

$r=$mysqli->query($query);
$respuesta=0;

if($row=$r-> fetch_assoc()){
    $respuesta=$row["isLogged"];
}

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod,$nom);

$rta="";
$programs=array();
while($stmt -> fetch()) {
    $aux=1;
    $program=array(
        "cod_programa"=>$cod,
        "nom_programa"=>$nom
    );
    array_push($programs,$program);
}
$response=array();
if(count($programs)>0){
    $response = array(
        'programs' => $programs,
        'status' => 1
    );
}else{
    $response = array(
        'html' => "error",
        'status' => 0
    );
}

$stmt->close();
echo json_encode($response);

?>