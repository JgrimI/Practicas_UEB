<?php
include_once('../persistencia/db.php');
$query = "SELECT VACANTE.cod_vacante,VACANTE.nombre_cargo, VACANTE.horario_disponibilidad, VACANTE.rango_salarial, EMPRESA.nombre, EMPRESA.logo FROM VACANTE, EMPRESA WHERE VACANTE.cod_empresa = EMPRESA.cod_empresa AND VACANTE.estado='PUBLICADO'";

$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($cod_vacante,$nombre_cargo,$horario_disponibilidad,$rango_salarial,$nombre,$logo);

$html='<table id="myTable" name="myTable"  class="display nowrap dataTable dtr-inline collapsed">
        <thead>
            <th>Empresa</th>
            <th>Puesto</th>
            <th>Horario</th>
            <th>Rango salarial</th>
            <th>Opciones</th>
        </thead>
        <tbody id="bodyTable" name="bodyTable">';
$entro=false;
while($stmt -> fetch()) {
    $entro=true;
    $html.='<tr>
                <td>
                    <div class="row text-center">
                        <div class="col-12">
                            <img src="assets/images/logos/'.$logo.'" alt="" class="thumb-sm rounded-circle mr-2" width="50px" height="50px">
                        </div>
                        <div class="col-12">
                            <p>'.$nombre.'</p>
                        </div>
                    </div>
                </td>
                <td>
                    '.$nombre_cargo.'
                </td>
                <td>
                    '.$horario_disponibilidad.'
                </td>
                <td>
                    '.$rango_salarial.'
                </td>
                <td>
                <div class="btn btn-success has-icon" onclick="openModal('.$cod_vacante.');">
                    <i class="mdi mdi-information"></i>Ver mas
                </div>                    
                </td>              
            </tr>';
}
$response=array();
if($entro){
    $html.='</tbody>
    </table>';
    $response = array(
        'vacants' => $html,
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
