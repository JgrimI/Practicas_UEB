<?php
include_once('../persistencia/db.php');
$query = "SELECT ((SELECT count(cod_estudiante) FROM ESTUDIANTE)) AS num_estudiantes, ((SELECT count(cod_empresa) FROM EMPRESA )) as num_empresas;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_estudiantes, $num_empresas);


$rta="";
$usuarios=array();
while($stmt -> fetch()) {
    $aux=1;
    $usuario=array(
        "num_estudiantes"=>$num_estudiantes,
        "num_empresas"=>$num_empresas

    );
    array_push($usuarios,$usuario);
}

$response=array();
if(count($usuarios)>0){
    $response = array(
        'usuarios' => $usuarios,
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