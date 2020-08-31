<?php
include_once('../persistencia/db.php');
 require '../mailer/PHPMailer.php';
 require '../mailer/SMTP.php';

 require '../mailer/Exception.php';

function enviarCorreo($mail, $name)
{
    $PHPmail=new PHPMailer();
    $PHPmail->CharSet = 'UTF-8';
    $PHPmail->IsSMTP();
    $PHPmail->Host       = 'smtp.gmail.com';
    $PHPmail->SMTPSecure = 'tls';

    $PHPmail->Port       = 587;
    $PHPmail->SMTPDebug  = 0;
    $PHPmail->SMTPAuth   = true;
    $PHPmail->Username   = 'practicas.uelbosque@gmail.com';
    $PHPmail->Password   = 'PracticasUEB123';
    $PHPmail->SetFrom('practicas.uelbosque@gmail.com', "Practicas UEB");
    $PHPmail->Subject    = 'Confirma tu correo electrónico';
    
    $PHPmail->AddEmbeddedImage("..\assets\images\logos\logoMail.jpg", "logo");
    $PHPmail->MsgHTML('<div style="background-color: rgba(222,222,222,0.6); margin-left: 15%; margin-right: 15%;">
                        <div style="text-align: center;">
                        <img src=\'cid:logo\' alt="Universidad El Bosque" style=" max-width: 100%; max-height: 100%;
                        pointer-events: none;
                        cursor: default;">
                        </div>
                        <div style="margin-left: 10%; margin-right: 10%;">
                        <br>
                        <p>Te damos la bienvenida '.$name.' al portal de practicas de la Universidad El Bosque.</p>
                        <p>Para poder usar todos nuestros servicios por favor haz click en el siguiente boton para terminar tu proceso de registro.</p>
                        <br><br>
                        </div>
                        </div>');

    $PHPmail->AddAddress($mail, $name);
        
    if(!$PHPmail->Send())
    {
    echo "Error sending: " . $PHPmail->ErrorInfo;
    }
    else
    {
    echo "E-mail sent";
    }
}

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
    enviarCorreo($mail, $name);
    $response = array(
        'comment' => 'Se agregó satisfactoriamente',
        'status' => true
    );
}

$mysqli->close();

echo json_encode($response);

?>

