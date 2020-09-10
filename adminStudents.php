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
    getEstudiantes();


  };

 function getPrograma(nom_programa){
   $.ajax({
     type: "POST",
     url: "ws/getPrograms.php",
     success: function (data) {
      data = JSON.parse(data);
            if (data["status"] == 1) {
                data = data["programs"];
                let options = '<option value="">Seleccione el programa al cual pertenece</option>';
                for(let i in data){
                    if (nom_programa == data[i]["nom_programa"]){
                         options += '<option value="'+data[i]["cod_programa"]+'" selected>'+data[i]["nom_programa"]+'</option>'
                    }
                    else
                        options += '<option value="'+data[i]["cod_programa"]+'">'+data[i]["nom_programa"]+'</option>'
                }
                $('#program').select2({ width: '100%' });
                $('#program').html(options);
                $('#ventanaModal').modal('show');
            }
     }
   })
 };

 function getEstudiantes(){
      $.ajax({
        type: "GET",
        url: "ws/getEstudiantes.php", 
        success: function (data) {
          console.log(data);
        data = JSON.parse(data);
            if (data["status"] == 1) {
                data = data["estudiantes"];
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                  if(data[i]["estado"]=="DESACTIVADO"){
                    var estado = 'badge badge-danger';
                  }else if(data[i]["estado"]=="ACTIVADO"){
                    estado='badge badge-success';
                  }else{
                    estado='badge badge-info';
                  }
                var aux= (data[i]['semestre']==null) ? '-' : data[i]['semestre'];
                var aux= (data[i]['numero_solicitudes']==null) ? '-' : data[i]['numero_solicitudes'];

                html += '<tr>' +
                '<td><center>' + data[i]["nombre_completo"] + '</center></td>' +
                '<td><center>' + data[i]["correo_estudiante"] + '</center></td>' +
                '<td><center>' + aux + '</center></td>' +
                '<td><center>' + data[i]["nom_programa"] + '</center></td>' +
                '<td><center>' + aux + '</center></td>' +
                '<td><center><div class="'+estado+'">' + data[i]["estado"] + '</div></center></td>' +
                '<td><center>' + data[i]["num_ingresos"] + '</center></td>' +
                '<td><center><a href=""><img width="50px" height="50px" src="assets/images/5112.png"/></a></center></td>'+
                '<td>'+'<button  type="button" rel="tooltip" class="btn btn-outline-info btn-rounded" data-toggle="modal" onclick="getVentanaModal('+ data[i]["cod_estudiante"] +')">edit</button></td>'
                '</tr>'
                }
              $('#estudiante').html(html);
            }
        },
        error: function (data) {
            console.log(data);
        },
    })

 };

 function getVentanaModal(cod_estudiante){

   $.ajax({
        type: "GET",
        url: "ws/getEstudiantes.php",
        success: function (data) {
          console.log(data);
        data = JSON.parse(data);
            if (data["status"] == 1) {
                data = data["estudiantes"];
                var html = '';
                var i;
                var nom_programa;
              for (i = 0; i < data.length; i++) {
                if(cod_estudiante == data[i]["cod_estudiante"]){
                 html += '<div class="form-group"> <label for="name">Nombre Estudiante</label><input type="text" name="nombre" placeholder= "Ingresar Nombre" required class="form-control" value='+data[i]["nombre_completo"]+'/> </div>'+
                 '<div class="form-group"><label for="name">Correo Estudiante</label><input type="text" name="Correo" placeholder="Ingresar Email" required class="form-control" value='+data[i]["correo_estudiante"]+' /></div>'+
                 '<div class="form-group"><label for="name">Solicitudes</label><input type="text" name="solicitudes" placeholder="Ingresar Solicitudes" required class="form-control" value='+data[i]["numero_solicitudes"]+' /></div>'+
                 '<div class="form-group"><label for="name">Programa</label><div class="input-group input-group-sm mb-3"><select name="program" class="form-control" id="program" required></select></div></div>'+
                 '<div class="form-group"><label for="name">Semestre</label><input type="text" name="semestre" placeholder="Ingresar Semestre" required class="form-control"  value='+data[i]["semestre"]+' /></div>'+
                 '<div class="form-group"><label for="name">Estado</label><input type="text" name="semestre" placeholder="Ingresar Estado" required class="form-control" value='+data[i]["estado"]+' /></div>'+
                 '<div class="form-group"><label for="name">Ingresos</label><input type="text" name="semestre" placeholder="Ingresar Ingresos" required class="form-control" value='+data[i]["num_ingresos"]+' /></div>'+
                 '<div class="form-group"><label for="name">Hoja De vida</label><input type="text" name="semestre" placeholder="Ingresar Hoja de vida" required class="form-control" /></div>'+
                 '<div class="alert alert-success"><h6><strong>tus datos se han guardado exitosamente</strong></h6></div>';
                 nom_programa = data[i]["nom_programa"];
                i = data.lenght;
                }         
         }
        }
        $('#modal').html(html);
        getPrograma(nom_programa);
      },
  });
 };


</script>

<body class="header-fixed">
    <!-- partial:../partials/_header.html -->
    <nav class="t-header">
      <div class="t-header-brand-wrapper">
        <a href="empresa.php">
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
                <h4>Estudiantes</h4>
              </div>
            </div>       
          </div>
          <div class="content-viewport">
            <div class="row">              
              <div class="col-lg-27">
                <div class="grid">
                  <p class="grid-header">Lista de Estudiantes</p>
                  <div class="item-wrapper text-center">
                     <div style="width: 1060px;">
                      <table class="table info-table wraped table-striped">
                        <thead>
                          <tr>
                            <th style="text-align: center">Nombre Estudiante</th>                            
                            <th style="text-align: center">Correo Estudiante</th>
                            <th style="text-align: center">Solicitudes</th>
                            <th style="text-align: center">Programa</th>
                            <th style="text-align: center">Semestre</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Ingresos</th>
                            <th style="text-align: center">Hoja De Vida</th>
                            <th style="text-align: center">Opciones</th>
                          </tr>
                        </thead>
                        <tbody id="estudiante" >

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
 <div class="modal fade" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="tituloVentana" aria-hidden="true">
  <div class="modal-dialog ui-corner-all" role="document">
   <div class="modal-content">
    <div class="modal-header">
          <h5 id="tituloVentana">Editar Estudiante</h5>
          <button class="close" data-dismiss="modal" aria-label="cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>
    <div class="modal-body" id="modal">
    </div>
    <div class="modal-footer">
      <button class="btn btn-warning" type="button" data-dismiss="modal">
        Cerrar
      </button>
      <button class="btn btn-success" type="button">
        Aceptar
      </button>
    </div>
   </div>
  </div>
 </div>
    <!--page body ends -->
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