<?php
include_once('../persistencia/db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Bogota");

$username = $_POST["username"];
$fecha = date('Y-m-d');
$aux= 0;
$response = [];

$query = "SELECT e.cod_estudiante, e.nombre_completo, e.correo_estudiante, e.numero_solicitudes, p.nom_programa, e.semestre, e.cod_HV from ESTUDIANTE e, PROGRAMA p where e.correo_estudiante ='".$username."' and e.cod_programa=p.cod_programa";
$stmt = $mysqli->prepare($query);
$stmt -> execute();
$stmt -> bind_result($id,$nombre,$correo,$numero_solicitudes,$programa,$semestre,$cod_hv);

while($stmt -> fetch()) {
    session_start();
    $aux=1;
    $_SESSION['id']=$id;
    $_SESSION['nombre']=$nombre;
    $_SESSION['correo']=$correo;
    $_SESSION['numero_solicitudes']=$numero_solicitudes;
    $_SESSION['programa']=$programa;
    $_SESSION['semestre']=$semestre;
    $_SESSION['cod_hv']=$cod_hv;
    $_SESSION['redirect']='studentHome.php';
    $primer_nombre=explode(' ',$nombre);
    $response = array(
        'comment' => 'Bienvenido '.$primer_nombre[0].'!!',
        'redirect' =>'studentHome.php',
        'status' => true
    );
}
$stmt->close();

if($aux==0){
    $query = "SELECT e.cod_empresa, e.NIT, e.nombre, e.correo_empresa, e.logo, e.estado from EMPRESA e where e.correo_empresa ='".$username."'";
    $stmt = $mysqli->prepare($query);
    $stmt -> execute();
    $stmt -> bind_result($id,$nit,$nombre,$correo,$logo,$estado);
    while($stmt -> fetch()) {
        session_start();
        $aux=1;
        $_SESSION['id']=$id;
        $_SESSION['nombre']=$nombre;
        $_SESSION['correo']=$correo;
        $_SESSION['nit']=$nit;
        $_SESSION['logo']=$logo;
        $_SESSION['estadi']=$estado;
        $_SESSION['redirect']='companyHome.php';
        $primer_nombre=explode(' ',$nombre);
        $response = array(
            'comment' => 'Bienvenido '.$primer_nombre[0].'!!',
            'redirect' =>'companyHome.php',
            'status' => true
        );
    }
    $stmt->close();


}
if($aux==0){
    $query = "SELECT a.id, a.nombre from ADMINISTRADOR a where a.username ='".$username."'";
    $stmt = $mysqli->prepare($query);
    $stmt -> execute();
    $stmt -> bind_result($id,$nombre);
    while($stmt -> fetch()) {
        session_start();
        $aux=1;
        $_SESSION['id']=$id;
        $_SESSION['nombre']=$nombre;
        $_SESSION['redirect']='adminHome.php';
        $primer_nombre=explode(' ',$nombre);
        $response = array(
            'comment' => 'Bienvenido '.$primer_nombre[0].'!!',
            'redirect' =>'adminHome.php',
            'status' => true
        );
    }
    $stmt->close();
}
if($aux==0){
    $response = array(
        'comment' => 'No se encuentran registradas las credenciales en el sistema',
        'redirect' =>'index.php',
        'status' => false
    );
}
echo json_encode($response);

?>