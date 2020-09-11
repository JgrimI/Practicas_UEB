<?php

$query = "SELECT count(cod_estudiante) as num_estudiantes FROM ESTUDIANTE;";
$query2 = "SELECT count(cod_empresa) as num_empresas FROM EMPRESA;";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($num_estudiantes);

$stmt2 = $mysqli->prepare($query2);
$stmt2 -> execute();
$stmt2 -> bind_result($num_empresas);

$rta="";
$usuarios=array();
while($stmt -> fetch()) {
    $aux=1;
    $usuario=array(
        "num_estudiantes"=>$num_estudiantes,
        
    );
    array_push($usuarios,$program);
}
while($stmt2 -> fetch()) {
    $aux2=1;
    $program=array(
        "num_empresas"=>$num_empresas,        
    );
    array_push($usuarios,$program);
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