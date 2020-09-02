<?php
include('tenders/persistencia/util/Conexion.php');

$obj=new Conexion();
$conexion=$obj->conectarBD();


$name="";
$categoria="";

$busqueda = '';
$criteria = $_POST["search"];
if($_POST["pais"]==""){
    $pais="";
}elseif($_POST["pais"]=="Todos"){
    $pais="";
} else{
    $pais =  " AND pais LIKE  '%".$_POST["pais"]."%' ";
}

if (!empty($criteria)) {
foreach ($criteria as $criterio) {
   $criterio = explode(" ", $criterio);
    foreach ($criteria as $value) {
        $value = utf8_decode($value);
        if(substr( $value, 0, 4 ) === "#Cat"){
            $value = ltrim($value, '#Cat');
            $busqueda .= "( nom_categoria LIKE  '%".$value."%' ) AND";
        }else{
            $busqueda .= "(cod_licitacion LIKE '%".$value."%'  OR nom_comprador LIKE  '%".$value."%'  OR nom_categoria LIKE  '%".$value."%'   OR descripcion LIKE   '%".$value."%' ) AND";
        }
    }
}

    $busqueda = substr($busqueda, 0, -4);
    $fecha=date("Y-m-d");
    $sentencia=" SELECT cod_licitacion, nom_licitacion, nom_comprador, fecha_cierre, pais, nom_categoria, descripcion, nom_respon_contrato, DATEDIFF(fecha_cierre,'$fecha') AS dRestantes, nom_respon_pago, email_respon_pago, email_respon_contrato,telefono_respon_contrato, telephone, celular,email
    FROM licitacion l JOIN comprador co ON co.cod_comprador = l.cod_comprador JOIN categoria ca ON ca.cod_categoria = l.cod_categoria
    WHERE ".$busqueda." $pais ORDER BY dRestantes ASC;";
    if (!$result = mysqli_query($conexion, $sentencia)) {
        die();
    }
    $json = [];
    $response = [];
    while ($row = mysqli_fetch_array($result)) {
        $restantes="";
        if($row["dRestantes"]>=0){
            if($row["dRestantes"]==1){
                $restantes="La licitación se cierra en ".$row["dRestantes"]." día";
            }else{
                $restantes="La licitación se cierra en ".$row["dRestantes"]." días";
            }
            if($row["descripcion"]==""){
                    $row["descripcion"]=$row["nom_licitacion"];
                }
                $responsable="";
                $correo="";
                
                $numeros="";
                if($row['pais']=="Chile"){
                    $responsable=$row["nom_respon_contrato"];
                    if ($row["email_respon_contrato"]!="") {
                        if(!preg_match('([a-zA-Z])', $responsable)){
                            $responsable=$row["nom_respon_pago"];
                            $correo=$row["email_respon_pago"];
                            $numeros="";
                        }else{
                            $correo=$row["email_respon_contrato"];
                        }
                    }else{
                        $correo="No entregan correo";
                    }
                    if (!preg_match('([0-9])', $row['telefono_respon_contrato'])) {
                        $numeros="No entregan número telefónico";
                    }else{
                        $numeros="+".$row['telefono_respon_contrato'];
                    }
                }elseif($row['pais']=="Colombia"){
                    $responsable=$row["nom_comprador"];
                    if( $row["email"]!=""){
                        $correos = explode(" ", $row["email"]);
                        foreach ($correos as $co) {
                            $correo.=$co."<br>";
                        }
                    }else{
                        $correo="No entregan correo";
                    }
                    if ($row['telephone']=="" && $row['celular']=="") {
                        $numeros="No entregan número telefónico";
                    }elseif($row['telephone']!="" && $row['celular']==""){
                        if ($row['telephone']!="000") {
                            $numeros="+57 ".$row['telephone'];
                        }
                    }elseif($row['telephone']=="" && $row['celular']!=""){
                            $numeros="+57 ".$row['celular'];
                    }else{
                        $tel = explode("-", $row["telephone"]);
                        
                        foreach($tel as $val){
                            if(strlen($val)>3){
                            $numeros.="+57 ".$val."<br>";
                            }
                        }
                        $numeros.="+57 ".$row['celular'];
                        
                    }
                }
            
            

                if($row['pais']=="Colombia"){
                
                }
                $response[] = array(
                    '   <div class="row text-center">
                        <div class="col-12">
                            <p>'.$row["cod_licitacion"],'</p>
                        </div>
                    </div>  
                    <div class="row text-center">
                        <div class="col-12">
                            <p>'.ucwords(mb_strtolower($row["descripcion"]), "."),'</p>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-12">
                            <p>'.wordwrap($restantes, 10, " <br>", false),'</p>
                        </div>
                    </div>  
                    <div class="row text-center">
                        <div class="col-12">
                            <p>'.$row["pais"],'</p>
                        </div>
                    </div>  
                    <div class="row text-center">
                        <div class="col-12">
                            <p>'.wordwrap($row["nom_categoria"], 30, " <br>", false),'</p>
                        </div>
                    </div>  
                    <div class="row text-center">
                        <div class="col-12">
                            <p>'.wordwrap(ucwords(mb_strtolower($responsable)), 20, " <br>", false),'</p>
                        </div>
                    </div> 
                    <div class=" row text-center ">
                        <div class="col-12">
                            <p>'.wordwrap($correo, 20, " <br>", false),'</p>
                        </div>
                    </div> 
                    <div class="row text-center">
                        <div class="col-12">
                            <p>'.$numeros,'</p>
                        </div>
                    </div> 
                    <div class="row text-center">
                        <div class="col-12">
                            <button type="button" onclick="openModal(\''.$row["cod_licitacion"].'\',\''.$row["pais"].'\');" class="modalShow btn btn-primary"
                            data-toggle="modal">Ver Detalles</button>									
                        </div>
                    </div>  
                        '
                    );
          }
    }
    if (count($response) == 0) {
        $json = array(
            "response" => 0
        );
    } else {
        $json = array(
            "response" => 1,
            "json" => $response
        );
    }
    echo json_encode($json);
}
