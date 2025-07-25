<div class="login-box">
    <div class="login-logo">
      <img src="vistas/img/Logo/android-chrome-192x192.png" alt="HERMES Logo" class="img-fluid mb-3">
      <br>    
      <!-- <a href="#">HERMES</a> -->
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">HERMES</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="ingPassword" id="passwordField" required>
            <div class="input-group-append">
              <div class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                <span class="fas fa-eye-slash" id="toggleIcon"></span>
              </div>
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Recuerdame
                </label>
              </div>
            </div> -->
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" id="ingresar">Ingresar</button>
            </div>
            <!-- /.col -->
          </div>

          <?php
            $login = new ControladorUsuarios();
            $login -> ctrIngresoUsuario();
          ?>
          <script src="vistas/js/login.js"></script>
        </form>

        <!-- <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->