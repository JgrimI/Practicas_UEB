<?php
session_start();
header ("Pragma-directive: no-cache");
header ("Cache-directive: no-cache");
header ("Cache-control: no-cache");
header ("Pragma: no-cache");
header ("Expires: 0");
if (!isset($_SESSION['redirect'])) {
    header('Location: index.php');
}
include('graficas.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Home</title>
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
    graf();
    getData()
  };

   function getData(){
      $.ajax({
        type: "POST",
        url: "ws/getGraph.php",
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data["status"] == 1) {
                var data = data["usuarios"];
                var estu = data[0]["num_estudiantes"];
                var empre = data[0]["num_empresas"]; 
                var vacant = data[0]["num_vacantes"];

                var estuH= '<p>'+estu+'</p>'+
                '<p></p>';
                 var empreH= '<p>'+empre+'</p>'+
                '<p></p>';
                 var vacantH= '<p>'+vacant+'</p>'+
                '<p></p>';

                $('#num_estudiantes').html(estuH);
                $('#num_empresas').html(empreH);
                $('#num_vacantes').html(vacantH);

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
          <form action="#" class="t-header-search-box">
            <div class="input-group">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" autocomplete="off">
              <button class="btn btn-primary" type="submit"><i class="mdi mdi-arrow-right-thick"></i></button>
            </div>
          </form>
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
          <div class="content-viewport">
            <div class="row">
              <div class="col-12 py-5">
                <h4>Dashboard</h4>
                <p class="text-gray">Welcome aboard, Allen Clerk</p>
              </div>
            </div>
            <div class="row">

              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid" >
                  <div class="grid-body text-gray" >
                    <div class="d-flex justify-content-between" id="num_estudiantes" name="num_estudiantes"  >
                      <p ></p>
                    </div>
                    <p class="text-black">Estudiantes</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_1"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between" id="num_empresas" name="num_empresas">
                      <p ></p>
                    </div>
                    <p class="text-black">Empresas</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_2"></canvas>
                    </div>
                  </div>
                </div>
              </div>
             
             <div class="col-md-3 col-sm-6 col-6 equel-grid">
                <div class="grid">
                  <div class="grid-body text-gray">
                    <div class="d-flex justify-content-between" id="num_vacantes" name="num_vacantes">
                      <p ></p>
                    </div>
                    <p class="text-black">Vacantes</p>
                    <div class="wrapper w-50 mt-4">
                      <canvas height="45" id="stat-line_3"></canvas>
                    </div>
                  </div>
                </div>
              </div>
             
             
              

              <div class="col-md-6">
              <div class="grid">
                <div class="grid-body">
                  <h2 class="grid-title">Numero de Usuarios</h2>
                  <div class="item-wrapper">
                    <canvas id="num-usuarios" width="600" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="grid">
                <div class="grid-body">
                  <h2 class="grid-title">Actividad de las vacantes</h2>
                  <div class="item-wrapper">
                    <canvas id="actividad-line-graph" width="600" height="400"></canvas>
                  </div>
                </div>
              </div>
            </div>

              
              
             
              
            </div>
          </div>
        </div>
      </div>
      <!-- page content ends -->
    </div>
        <!-- partial:../partials/_footer.html -->
        <footer class="footer">
         
        </footer>
        <!-- partial -->
      </div>
      <!-- page content ends -->
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    <script src="assets/vendors/js/core.js"></script>
    <!--  <script src="assets/vendors/js/vendor.addons.js"></script>-->
     <script src="assets/js/charts/chartjs.js"></script>
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- build:js -->
    <script src="assets/js/template.js"></script>
    <!--  -->
  </body>
</html>