<?php
session_start();

if (!isset($_SESSION['redirect'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
    <!-- plugins:css -->
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
    
    getCompanies();

  };


  function getCompanies(){
    $.ajax({
        type: "POST",
        url: "ws/getCompanies.php",
        success: function (data) {    
        data = JSON.parse(data);    
            if (data["status"] == 1) {
                data = data["companies"];
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                  if(data[i]["estado"]=="RECHAZADO"){
                    var estado = 'btn btn-outline-danger';
                  }else if(data[i]["estado"]=="APROBADO"){
                    estado='btn btn-outline-success';
                  }else{
                    estado='btn btn-outline-info';
                  }
                  
                html += '<tr>' +
                        '<td>'+
                        '<div class="row text-center">'+
                                   '<div class="col-12">'+
                                       '<img width="50px" height="50px" class="thumb-sm rounded-circle mr-2" src="assets/images/logos/' + data[i]["logo"] + '">'+
                                   '</div>'+
                                   '<div class="col-12">'+
                                       '<p>' + data[i]["nombre"] +'</p>'+
                                   '</div>'+
                               '</div>'+    
                        '</td>' +
                        '<td>' + data[i]["NIT"] + '</td>' +
                        '<td>' + data[i]["correo_empresa"] + '</td>' +
                        '<td>' + data[i]["descripcion_empresa"] + '</td>' +
                        '<td>' + data[i]["num_ingresos"] + '</td>' +
                        '<td><button type="button" rel=tooltip" class="'+estado+'" data-toggle="modal" data-target="#cambiarEstado">'+ data[i]["estado"] + '</td>' +
                        '<td><a href="assets/images/cc/' + data[i]["cc_empresa"] + '"><img width="50px" height="50px"src="assets/images/pdf.png"></a></td>' +
                        '<td><a href="editCompany.php?nit=' + data[i]["NIT"] +'">'+'<button type="button" rel=tooltip" class="btn btn-outline-info btn-rounded">editar'
                        '</tr>'

             ;
             var nit = data[i]["NIT"];
           }
          
          $('#company').html(html);
          $('#nitVal').val(nit);
          
            }
        },
        error: function (data) {
            console.log(data);
        },
    })
  }

    function valCompany(){
      $.ajax({
        type: "POST",
        url: "ws/valCompany.php",
        data:new FormData($('#valEmpresa')[0]),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"] == 1) {
              $('#cambiarEstado').modal('toggle');

            }else{
              if(data['error'] == 1062){
                $('#cambiarEstado').modal('toggle');
              }
            }
        },
        error: function (data) {
            console.log(data);
        },
    });
  }
  

</script>

  <body class="header-fixed">
    <!-- partial:../partials/_header.html -->
    <nav class="t-header">
      <div class="t-header-brand-wrapper">
        <a href="adminCompany.php">
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
                <h4>Empresas</h4>
              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-27">
                <div class="grid">
                  <p class="grid-header">Lista de Empresas</p>
                  <div class="item-wrapper">
                    <div class="table-responsive">
                      <table class="table info-table table-striped" >
                        <thead>
                          <tr>
                            <th>Logo</th>                            
                            <th>NIT</th>
                            <th>Correo</th>
                            <th>Descripción</th>
                            <th>Numero de ingresos</th>
                            <th>Estado</th>
                            <th>cc_empresa</th>
                            <th>Opciones</th>
                          </tr>
                        </thead>
                        <tbody id="company" >
                                   
                        </tbody>
                        
                      </table>
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
    <!--page body ends -->

    <!-- Modal -->
    <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="CambiarEstado"  aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Cambiar Estado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="valEmpresa" action="javascript:void(0);" onsubmit="valCompany();">
            <div class="form-group row showcase_row_area">
                <div class="col-md-5 showcase_text_area">
                    <label for="VEstado">Cambiar Estado</label>
                </div>
                <input type="hidden" id="nitVal" name="nitVal" required value ="" maxlength="50">
                <div class="col-md-20 showcase_content_area">
                    <select name="VEstado" class="form-control" id="VEstado" required>
                      <option value="REGISTRADO">Registrado</option>
                      <option value="RECHAZADO">Rechazar</option>
                      <option value="APROBADO">Aceptar</option>
                    </select> 
                </div>          
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
          </form>
        </div>
      </div>
    </div> 
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="assets/vendors/js/core.js"></script>
    <script src="assets/vendors/js/vendor.addons.js"></script>
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="assets/js/template.js"></script>
    <!--  -->
  </body>
</html>