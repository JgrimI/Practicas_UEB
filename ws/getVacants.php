<?php
include_once('../persistencia/db.php');
session_start();

$query = "SELECT * from VACANTE where cod_empresa=".$_SESSION['id'];

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_vacante,$nombre_cargo,$descripcion_vacante,$educacion_base,$horario_disponibilidad,$rango_salarial,$estado,$cantidad_vacantes,$fecha_vacante,$cod_empresa);

$rta="";
$vacants=array();
$html=" <div class='row' style='float:right; margin-bottom:5%; margin-right:5%'>
            <a class='btn btn-warning' href='javascript:void(0)' onclick='openModal();'>Publicar</a>
        </div>
        <div class='row' style='margin-top:6%;'>";
$aux=0;
$entro=false;
while($stmt -> fetch()) {
    $entro=true;
    $aux=$aux+1;
    $margin=($aux==1) ? '' : 'margin-left:5%;';
    $aux=($aux==3) ? 0 : $aux;
    $html.='<div class="card" style="width: 30%; '.$margin.' margin-top:2%; background-image: linear-gradient(120deg,#00e795 0,#0095e2 100%);
    ">
                <div class="card-body" style="color:#fff">
                    <h4 class="text-center">'.$nombre_cargo.'</h4><br>
                    <h6 class="card-subtitle mb-2 text-center" >Cantidad Vacantes: '.$cantidad_vacantes.'</h6>
                    <center><label class="badge badge-dark">'.$estado.'</label></center>
                    <p class="card-text">
                        <strong>Rango salarial:</strong> '.$rango_salarial.'<br>
                        <strong>Horario:</strong> '.$horario_disponibilidad.'<br>
                        <strong>Fecha:</strong> '.$fecha_vacante.'<br>
                        <strong>Descripción:</strong> '.$descripcion_vacante.'<br>
                        <strong>Educación base:</strong> '.$educacion_base.'<br>
                    </p>
                </div>
            </div>';
}
$response=array();
if($entro){
    $response = array(
        'html' => $html.'</div>',
        'status' => 1
    );
}else{
    $response = array(
        'html' => "<div style='margin-top:3%;margin-left:15%;'>
                        <h1>Aun no has publicado ninguna vacante </h1><br>
                        <img src='assets/images/comencemos.png' width='600px' height='500px'>
                        <a class='btn btn-warning btn-lg' style='color:white;' href='javascript:void(0)' onclick='openModal();'>Comencemos!!</a>
                   </div>",
        'status' => 1
    );
}
$stmt->close();

echo json_encode($response);
?>