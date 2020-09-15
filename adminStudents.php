<?php
header ("Pragma-directive: no-cache");
header ("Cache-directive: no-cache");
header ("Cache-control: no-cache");
header ("Pragma: no-cache");
header ("Expires: 0");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache" />
    <title>Home</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.addons.css">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" />

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
                  if(data[i]["estado"]=="ACTIVADO"){
                    var estado = 'badge badge-primary';
                  }else if(data[i]["estado"]=="INSCRITO"){
                    estado='badge badge-success';
                  }else if(data[i]["estado"]=="ASPIRANTE"){
                    estado='badge badge-dark';
                  }else{
                    estado='badge badge-info';
                  }
                var olo= (data[i]['semestre']==null) ? '-' : data[i]['semestre'];
                var aux= (data[i]['numero_solicitudes']==null) ? '-' : data[i]['numero_solicitudes'];

                html += '<tr>' +
                '<td><center>' + data[i]["nombre_completo"] + '</center></td>' +
                '<td><center>' + data[i]["correo_estudiante"] + '</center></td>' +
                '<td><center>' + aux + '</center></td>' +
                '<td><center>' + data[i]["nom_programa"] + '</center></td>' +
                '<td><center>' + olo + '</center></td>' +
                '<td><center><div class="'+estado+'">' + data[i]["estado"] + '</div></center></td>' +
                '<td><center>' + data[i]["num_ingresos"] + '</center></td>' +
               

                '<td><center>  <form method="post" target="_blank" action="pdf.php" id="formCV"> '+
                              '<input type="hidden" id="id" name="id" value="'+ data[i]["cod_estudiante"] +'"/>'+
                              '<button type="submit" style="background: url(assets/images/5112.png); width:50px; height:50px; background-size: 50px 50px; border: none;">'+
                              '</form>  </center></td>'+
                        '<td><a href="editStudents.php?codigo=' + data[i]["cod_estudiante"] +'">'+'<button type="button" rel=tooltip" class="btn btn-outline-info btn-rounded">editar'
                '</tr>'
                }
              $('#estudiante').html(html);
            }
              $("#contentPage").html(data);
                    $('#estudiantes').DataTable({
                          "scrollX": true,
                          "language": {
                            "sProcessing":    "Procesando...",
                            "sLengthMenu":    "Mostrar _MENU_ registros",
                            "sZeroRecords":   "No se encontraron resultados",
                            "sEmptyTable":    "Ningún dato disponible en esta tabla",
                            "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":   "",
                            "sSearch":        "Buscar:",
                            "sUrl":           "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":    "Último",
                                "sNext":    "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        }
                    }); 
        },
        error: function (data) {
            console.log(data);
        },
    })
   }

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
                   <div style="width: 1100px;">
                    <table id="estudiantes" name="estudiante" class="display nowrap dataTable dtr-inline collapsed no-footer" role="grid" aria-describedby="estudiante_info">
                        <thead>
                          <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Nombre Estudiante: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Nombre Estudiante</th>                            
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Correo Estudiante: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Correo Estudiante</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Solicitudes: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Solicitudes</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Programa: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Programa</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Semestre: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Semestre</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Estado: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Estado</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Ingresos: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Ingresos</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Hoja De Vida: Activar para ordenar la columna de manera ascendente" style="width: 1px;">H.V</th>
                            <th class="sorting" tabindex="0" aria-controls="estudiante" rowspan="1" colspan="1" aria-label="Opciones: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Opciones</th>
                          </tr>
                        </thead>
                        <tbody id="estudiante" name="estudiante" ><tr role="row" class="odd"></tr>

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