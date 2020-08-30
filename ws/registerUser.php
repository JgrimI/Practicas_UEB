<?php
include_once('../persistencia/db.php');
$mail=$_POST['mail'];
$name=$_POST['name'];
$pass=$_POST['pass'];
$program=$_POST['program'];

$response = [];
$sql = "CALL p_add_student('".$name."', '".$pass."', '".$mail."', ".$program.")";
if (!$mysqli->query($sql)) {
    if($mysqli->errno == 1062){
        $response = array(
            'error' => 1062,
            'status' => false
        );
    }else{
        $response = array(
            'error' => "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error,
            'status' => false
        );
    }
}else{
    $response = array(
        'comment' => 'Se agregó satisfactoriamente',
        'status' => true
    );
}

$mysqli->close();

echo json_encode($response);

?>