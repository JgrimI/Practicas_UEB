<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
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

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


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
    if ($.fn.DataTable.isDataTable( '#company' ) ) {
        $('#company').DataTable().destroy();
    }
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
                    var estado = 'btn btn-danger';
                  }else if(data[i]["estado"]=="APROBADO"){
                    estado='btn btn-success';
                  }else{
                    estado='btn btn-info';
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
                        '<td><a href="javascript:void(0);" onclick="openModal('+data[i]["NIT"]+',\''+data[i]["estado"]+'\');" class="'+estado+'">'+ data[i]["estado"] + '</a></td>' +
                        '<td><a href="assets/images/cc/' + data[i]["cc_empresa"] + '" target="blank"><img width="50px" height="50px"src="assets/images/pdf.png"></a></td>' +
                        '<td><a href="editCompany.php?nit=' + data[i]["NIT"] +'">'+'<button type="button" rel=tooltip" class="btn btn-info btn-rounded">editar'
                        '</tr>'

             ;
           }
          
          $('#company tbody').html(html);
          
            }
            $("#contentPage").html(data);
                    $('#company').DataTable({
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

function openModal(id, estado){

  $("#cambiarEstado").modal("show");  
  console.log(estado);
  $("#VEstado  option[value='"+estado+"']").attr("selected", true);
  $('#nitVal').val(id);
         
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
              getCompanies();
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
                  <div class="item-wrapper text-center">
                      <div style="width: 1060px;">
                      <table id="company" name="company" class="display nowrap dataTable dtr-inline collapsed no-footer" role="grid" aria-describedby="company_info">
                      <thead>
                      <tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Logo: Activar para ordenar la columna de manera descendente" style="width: 59px;">Logo</th>
                        <th class="sorting" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-label="NIT: Activar para ordenar la columna de manera ascendente" style="width: 1px;">NIT</th>
                        <th class="sorting" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-label="Correo: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Correo</th>
                        <th class="sorting" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-label="Descripcion : Activar para ordenar la columna de manera ascendente" style="width: 1px;">descripcion </th>
                        <th class="sorting" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-label="Numero de ingresos: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Ingresos</th>
                        <th class="sorting" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-label="Estado: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Estado</th>
                        <th class="sorting" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-label="Camara de Comercio: Activar para ordenar la columna de manera ascendente" style="width: 1px;">C.C</th>
                        <th class="sorting" tabindex="0" aria-controls="company" rowspan="1" colspan="1" aria-label="Opciones: Activar para ordenar la columna de manera ascendente" style="width: 1px;">Opciones</th>
                      </tr>
                    </thead>
                      <tbody id="company" name="company"><tr role="row" class="odd"></tr>
                      </tbody>
                        
                      </table>
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
                <div class="col-md-5 showcase_text_area" id="nitVal" name="nitVal">
                    <label for="VEstado">Cambiar Estado</label>
                </div>
                <input type="hidden" id="nitVal2" name="nitVal2" required value ="" maxlength="50">
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
    <script src="assets/js/charts/chartjs.js"></script>
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- build:js -->
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    <script src="assets/js/template.js"></script>
    <!--  -->
  </body>
</html>