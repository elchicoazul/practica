<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Korinto</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/favicon.png" />
    <style>
    .select2-container .select2-selection--single {
        height: 35px !important; /* Ajusta la altura según tus necesidades */
        display: flex !important;
        align-items: center !important;
    }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="/practica"><img src="<?php echo base_url(); ?>/assets/images/logo.svg" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="/practica"><img src="<?php echo base_url(); ?>/assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                  <span>Gold Member</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-laptop"></i>
              </span>
              <span class="menu-title">Configuración</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>Usuarios">Usuario</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>Productos">Productos</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>Servicios">Servicios</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>Configuraciones">General</a></li>

              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?php echo base_url(); ?>Guia">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title">Recepción</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?php echo base_url(); ?>Liquidacion">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Liquidación</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?php echo base_url(); ?>Programacion">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Programación</span>
            </a>
          </li>
          <li class="nav-item menu-items">
              <a class="nav-link" href="<?php echo base_url(); ?>Liquidarfac">
                  <span class="menu-icon">
                      <!-- Cambiado el icono a "mdi mdi-cash" -->
                      <i class="mdi mdi-cash"></i>
                  </span>
                  <span class="menu-title">Liquidar Fac</span>
              </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?php echo base_url(); ?>Reportes">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
              <span class="menu-title">Reportes</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Henry Klein</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <!-- boton log out-->
                  <a class="dropdown-item preview-item" href="<?php echo base_url('Salir'); ?>">
                      <div class="preview-thumbnail">
                          <div class="preview-icon bg-dark rounded-circle">
                              <i class="mdi mdi-logout text-danger"></i>
                          </div>
                      </div>
                      <div class="preview-item-content">
                          <span class="preview-subject mb-1">Log out</span>
                      </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
                        
          <?= $this->renderSection('content'); ?>
                        
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © rabakukus.com 2023</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo base_url(); ?>/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?php echo base_url(); ?>/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo base_url(); ?>/assets/js/off-canvas.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/hoverable-collapse.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/misc.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/settings.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="<?php echo base_url(); ?>/assets/js/dashboard.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/registro/usuario.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/registro/productos.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/registro/configuracion.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/registro/servicio.js"></script>

    <script src="<?php echo base_url(); ?>/assets/js/programacion/programacion.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/reporte/reporte.js"></script>
    


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <script src="<?php echo base_url(); ?>/assets/js/guia/guia.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/liquidacion/liquidacion.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/liquidacion/tablaTotal.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/liquidacion/analisisElementos.js"></script>
    <!-- End custom js for this page -->

    

    <!--autocomplete script-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  </body>
</html>