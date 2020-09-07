<?php
include_once('../persistencia/db.php');
$query = "SELECT nombre_cargo, descripcion_vacante, educacion_base, horario_disponibilidad, rango_salarial, estado, fecha_vacante, cod_empresa from VACANTE";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($nombre_cargo,$descripcion_vacante,$educacion_base,$horario_disponibilidad,$rango_salarial,$estado,
    $fecha_vacante,$cod_empresa);

$rta="";
$vacants=array();
while($stmt -> fetch()) {
    $aux=1;
    $vacant=array(
        "nombre_cargo"=>$nombre_cargo,
        "descripcion_vacante"=>$descripcion_vacante,
        "educacion_base"=>$educacion_base,
        "horario_disponibilidad"=>$horario_disponibilidad,
        "rango_salarial"=>$rango_salarial,
        "estado"=>$estado,
        "fecha_vacante"=>$fecha_vacante,
        "cod_empresa"=>$cod_empresa
    );
    array_push($vacants,$vacant);
}
$response=array();
if(count($vacants)>0){
    $response = array(
        'vacants' => $vacants,
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
