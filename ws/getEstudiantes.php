<?php
include_once('../persistencia/db.php');
$query = "SELECT nombre_completo, correo_estudiante, numero_solicitudes, nom_programa, semestre, estado, num_ingresos, cod_HV from ESTUDIANTE,PROGRAMA WHERE ESTUDIANTE.cod_programa = PROGRAMA.cod_programa";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($nombre,$correo,$num_solicitudes,$programa,$semestre,$estado,$num_ingresos,$HV);

$rta="";
$estudiantes=array();
while($stmt -> fetch()) {
    $aux=1;
    $estudiante=array(
        "nombre_completo"=>$nombre,
        "correo_estudiante"=>$correo,
        "numero_solicitudes"=>$num_solicitudes,
        "nom_programa"=>$programa,
        "semestre"=>$semestre,
        "estado"=>$estado,
        "num_ingresos"=>$num_ingresos,
        "cod_HV"=>$HV
    );
    array_push($estudiantes,$estudiante);
}
$response=array();
if(count($estudiantes)>0){
    $response = array(
        'estudiantes' => $estudiantes,
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
