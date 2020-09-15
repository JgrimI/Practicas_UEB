<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$codigo=$_GET["codigo"];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
    <!-- plugins:css -->
    
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src="estilos_tp2/vendor/jquery-easing/jquery.easing.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css">
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout style -->
    <link rel="stylesheet" href="assets/css/demo_1/style.css">
    <!-- Layout style -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- Dropify file input -->
    <script src="assets/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" href="assets/dist/css/dropify.min.css">


  </head>


<style>
.t-header .t-header-brand-wrapper a .logo {
  width:150px;
  height:50px;
}
.display-avatar.animated-avatar:before {
  background-color: orange;
  background-image: linear-gradient(19deg, orange 0%, red 100%)
}
.navbar-dropdown .dropdown-body .dropdown-grid {
  width:40%;
  margin-left:8%;
}

</style>

<script>
   window.onload=function(){   
    getStudents();

  };
  
  function verifyPass(){
    var pass=document.getElementById('pass').value;
    var verify=document.getElementById('verify').value;
    if(pass==verify && pass!='' && verify!=''){
      $('#alert_pw').css('display','none');
      return true;
    }
    else if(pass!=verify && pass!='' && verify!=''){
      $('#alert_pw').css('display','block');
    }else{
      $('#alert_pw').css('display','none');
    }
    return false;
  }
   function modCompany(){
    if(verifyPass()){
      $.ajax({
        type: "POST",
        url: "ws/modCompany.php",
        data: new FormData($('#mod')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"] == 1) {
              $('.dropify-clear').click();
              Swal.fire(
                  'Bien hecho!',
                  'Se ha modificado la empresa de forma exitosa!!!',
                  'success'
                ).then(function(){
                  window.location='adminCompany.php';
                })
            }else{
              if(data['error'] == 1062){
                Swal.fire(
                  'Error!',
                  data['error'],
                  'error'
                )
              }
            }
        },
        error: function (data) {
            console.log(data);
        },
    });
    }
  }

 function getPrograma(nom_programa,html){
   $.ajax({
     type: "POST",
     url: "ws/getPrograms.php",
     success: function (data) {
      data = JSON.parse(data);
            if (data["status"] == 1) {
                data = data["programs"];
                var options;
                for(let i in data){
                    if (nom_programa == data[i]["nom_programa"]){
                        options += '<option value="'+data[i]["cod_programa"]+'" selected>'+data[i]["nom_programa"]+'</option>'
                    }
                    else
                        options += '<option value="'+data[i]["cod_programa"]+'">'+data[i]["nom_programa"]+'</option>'
                }
                $('#insertar').html(html);
                $('#program').html(options);
            }
          },
        error: function (data) {
            console.log(data);
        }
   });
 }

  function getStudents(){
    $.ajax({
        type: "POST",
        url: "ws/getEstudiantes.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["estudiantes"];   
                var i=0;
                var econtro = false;
                var nom_programa;
                var estados = ['INSCRITO','PREINSCRITO','NO APROBADO'];
                var estado;
                while(econtro==false){
                  if(data[i]["cod_estudiante"]==<?php echo $codigo ?>){
                   econtro=true;    

                  }else{
                    i++;
                  }                                      
                }
                for(var j = 0; j < estados.length;j++){
                   if(estados[j] = data[i]["estado"]){
                     var aux = estados[j];
                     estados[j] = estados[0];
                     aux = estados[j];
                    estado = '<option value="'+estados[0]+'" selected>'+estados[0]+'</option><option value="'+estados[1]+'">'+estados[1]+'</option><option value="'+estados[2]+'">'+estados[2]+'</option>'                  
                   j = estados.length;
                   }
                   }
                var html ='<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="nombre">Nombre estudiante</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" name="nombre" id="nombre" value ="'+data[i]["nombre_completo"]+'" readonly style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="email">Correo estudiante</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="email" class="form-control" id="email" name="email" value ="'+data[i]["correo_estudiante"]+'" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="descrip">Programas</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<select name="program" class="form-control" id="program" required></select>'+
                          '</div>'+
                        '</div>'+
                                                                  
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="semestre">Semestre</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="semestre" name="semestre" required value ="'+data[i]["semestre"]+'"  minlength="6" maxlength="12" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="estado">Estado</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                          '<select name="estado" class="form-control" id="estado" required>'+estado+'</select>'+                          
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="pass">Contraseña</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            '<input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="pass" name="pass" required value ="'+data[i]["password_estudiante"]+'" onchange="verifyPass();"  minlength="6" maxlength="12" style="width:180%;">'+
                          '</div>'+
                        '</div>'+
                        '<div class="form-group row showcase_row_area">'+
                          '<div class="col-md-5 showcase_text_area">'+
                            '<label for="verify">Verificar contraseña</label>'+
                          '</div>'+
                          '<div class="col-md-20 showcase_content_area">'+
                            ' <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="verify" name="verify" required value ="'+data[i]["password_estudiante"]+'" onchange="verifyPass();" maxlength="12" style="width:180%;">'+
                          '</div>'+
                        '</div>';
           nom_programa = data[i]["nom_programa"];
          }
          getPrograma(nom_programa,html);
          
        },
        error: function (data) {
            console.log(data);
        },
    })
  };

</script>

  <body class="header-fixed">
    <!-- partial:../partials/_header.html -->
    <nav class="t-header">
      <div class="t-header-brand-wrapper">
        <a href="adminHome.php">
          <img class="logo" src="assets/images/logo.png" alt="">
          <img class="logo-mini" src="assets/images/logo.png" alt="">
        </a>
      </div>
      <div class="t-header-content-wrapper">
        <div class="t-header-content">
          <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
            <i class="mdi mdi-menu"></i>
          </button>
          <ul class="nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-bell-outline mdi-1x"></i>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
                <div class="dropdown-header">
                  <h6 class="dropdown-title">Notifications</h6>
                  <p class="dropdown-title-text">You have 4 unread notification</p>
                </div>
                <div class="dropdown-body">
                  <div class="dropdown-list">
                    <div class="icon-wrapper rounded-circle bg-inverse-primary text-primary">
                      <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="content-wrapper">
                      <small class="name">Storage Full</small>
                      <small class="content-text">Server storage almost full</small>
                    </div>
                  </div>
                  <div class="dropdown-list">
                    <div class="icon-wrapper rounded-circle bg-inverse-success text-success">
                      <i class="mdi mdi-cloud-upload"></i>
                    </div>
                    <div class="content-wrapper">
                      <small class="name">Upload Completed</small>
                      <small class="content-text">3 Files uploded successfully</small>
                    </div>
                  </div>
                  <div class="dropdown-list">
                    <div class="icon-wrapper rounded-circle bg-inverse-warning text-warning">
                      <i class="mdi mdi-security"></i>
                    </div>
                    <div class="content-wrapper">
                      <small class="name">Authentication Required</small>
                      <small class="content-text">Please verify your password to continue using cloud services</small>
                    </div>
                  </div>
                </div>
                <div class="dropdown-footer">
                  <a href="#">View All</a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="appsDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-apps mdi-1x"></i>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="appsDropdown">
                <div class="dropdown-header">
                  <h6 class="dropdown-title">Opciones</h6>
                </div>
                <div class="dropdown-body border-top pt-0">
                  <a class="dropdown-grid">
                    <i class="grid-icon mdi mdi-security mdi-2x"></i>
                    <span class="grid-tittle">Cambiar contraseña</span>
                  </a>
                  <a class="dropdown-grid" href="logout.php">
                    <i class="grid-icon mdi mdi-exit-to-app mdi-2x"></i>
                    <span class="grid-tittle">Cerrar sesión</span>
                  </a>
                </div>
                
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- partial -->
    <div class="page-body">
      <!-- partial:../partials/_sidebar.html -->
      <div class="sidebar">
        <div class="user-profile">
          <div class="display-avatar animated-avatar">
            <img class="profile-img img-lg rounded-circle" src="assets/images/profile/female/image_1.png" alt="profile image">
          </div>
          <div class="info-wrapper">
            <p class="user-name"><?php echo $_SESSION['nombre'];?></p>
          </div>
        </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">Menu</li>
          <li>
            <a href="adminHome.php">
              <span class="link-title">Estadisticas</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          
          <li>
            <a href="adminCompany.php">
              <span class="link-title">Empresas</span>
              <i class="mdi mdi mdi-bookmark-plus link-icon"></i>
            </a>
          </li>
          <li>
            <a href="adminStudents.php">
              <span class="link-title">Estudiantes</span>
              <i class="mdi mdi mdi-human-greeting link-icon"></i>
            </a>
          </li>
          <li>
            <a href="adminVacant.php">
              <span class="link-title">Vacantes</span>
              <i class="mdi mdi-clipboard-outline link-icon"></i>
            </a>
          </li>
                         
        </ul>
      </div>
      <!-- partial -->
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="viewport-header">
            <div class="row">
              <div class="col-12 py-5">
                <h4>Empresa</h4>
                <div class="form-group">
                                                           

              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-10 equel-grid">
                <div class="grid">
                  <p class="grid-header">Editar empresa</p>
                   <div class="grid-body">
                    <div class="item-wrapper">
                      <form id="mod" action="javascript:void(0);" onsubmit="modCompany();">
                          <div id="insertar">

                          </div>     
                          <div >
                            <br>
                              <div class="form-group row showcase_row_area" style="float:right;" >
                              <div>                  
                                  <a href="adminStudents" class="btn btn-warning" style="margin-right:15px;">Cancelar</a>
                                </div>
                                <div>
                                  <button type="submit" class="btn btn-success">Aceptar</button>
                                </div>
                                
                              </div>
                          </div>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>   
          </div>
         
        <!-- content viewport ends -->
        <!-- partial:../partials/_footer.html -->
        <footer class="footer">
          <div class="row">
            <div class="col-sm-6 text-center text-sm-right order-sm-1">
              <ul class="text-gray">
                <li><a href="#">Terms of use</a></li>
                <li><a href="#">Privacy Policy</a></li>
              </ul>
            </div>
            <div class="col-sm-6 text-center text-sm-left mt-3 mt-sm-0">
              
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- page content ends -->
    </div>
    <!--  -->
  </body>
</html>