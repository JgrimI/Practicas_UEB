<?php
include_once('../persistencia/db.php');
/**$query = "SELECT cod_programa, nom_programa from PROGRAMA";

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
$stmt->close();*/
$response = array(
    'html' => "<div style='margin-top:3%;margin-left:15%;'>
                    <h1>Aun no has publicado ninguna vacante </h1><br>
                    <img src='assets/images/comencemos.png' width='400px' height='500px'>
                    <button type='button' class='btn btn-primary btn-lg'>Comencemos!!</button>
               </div>",
    'status' => 1
);
echo json_encode($response);
?>