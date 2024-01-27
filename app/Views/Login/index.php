<html lang="en"><head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Acceder</h3>

                    <form action="<?php echo base_url(); ?>LoginUser/authenticate" method="post">
                        <div class="form-group">
                            <label>Nombre de Usuario</label>
                            <input type="text" name="username" class="form-control p_input" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control p_input" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                        </div>
                    </form>
                    <p class="sign-up">Don't have an Account?<a href="#"> Sign Up</a></p>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo base_url(); ?>/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo base_url(); ?>/assets/js/off-canvas.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/hoverable-collapse.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/misc.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/settings.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/todolist.js"></script>
    
    <!-- endinject -->
</body></html>