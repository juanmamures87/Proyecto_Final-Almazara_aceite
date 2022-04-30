<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Molino del Sur - Acceso socios</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../images/favicon32.png" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500">

    <!--======================== AÑADIDOS PARA EL LOGIN ============================================-->
    <link rel="stylesheet" type="text/css" href="../vendorLoginSocios/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendorLoginSocios/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendorLoginSocios/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendorLoginSocios/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendorLoginSocios/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendorLoginSocios/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../css/utilLoginSocios.css">
    <link rel="stylesheet" type="text/css" href="../css/mainLoginSocios.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>

  <div id="errorSocios"><span id="msgErrorLogin"><?php if (isset($error)) { echo $error; } ?></span></div>
  <div><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i></div>

    <div class="preloader">
      <div class="preloader-body">
        <div class="cssload-container"><span></span><span></span><span></span><span></span>
        </div>
      </div>
    </div>
    <div class="page">
      <!-- Header de la página-->
      <header class="section page-header">
        <!-- Menú de nave-->
        <div class="rd-navbar-wrap rd-navbar-modern-wrap">
          <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="70px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand" id="logoAccesoSocios">
                    <a class="brand" href="portada">
                      <img id="logoEmpresaIndex" src="../images/LogoFinal-200px.png" alt="Logo Molino del sur"/>
                      <span id="nombreEmpresaInicio" class="h3">Molino del Sur</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!-- Carrusel más pequeño -->
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="../images/carruselSocios/country-gc8cda8d45_640.jpg" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
              <h5>QUEREMOS NUESTRA TIERRA</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="../images/carruselSocios/meadow-gf58953042_640.jpg" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
              <h5>NATURALEZA EN TODO SU ESPLENDOR</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="../images/carruselSocios/nature-gd840468ec_640.jpg" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
              <h5>IMPACTO MEDIOAMBIENTAL BAJO</h5>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Siguiente</span>
        </a>
      </div>

      <!-- Registro de usuario -->
      <div class="limiter" id="loginSocios">
        <div class="container-login100">
          <div class="wrap-login100">
            <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="post" action="index.php">
					<span class="login100-form-title">
						Iniciar sesión
					</span>

              <div class="wrap-input100 dni validate-input m-b-16">
                <input class="input100 dni" type="text" maxlength="9" name="dni" id="dni" placeholder="Dni">
                <span class="focus-input100"></span>
              </div>

              <div class="wrap-input100 pass validate-input">
                <input class="input100 pass" type="password" name="pass" id="pass" placeholder="Contraseña">
                <span class="focus-input100"></span>
              </div>

              <div class="text-right p-t-13 p-b-23">
						<span class="txt1">
							¿Olvidó su
						</span>

                <a href="#" class="txt2">
                  Contraseña?
                </a>
              </div>

              <div class="container-login100-form-btn mb-5">
                <button class="login100-form-btn">
                  Iniciar sesión
                </button>
              </div>
              <input type="hidden" id="controlador" name="controlador" value="login">
              <input type="hidden" id="accion" name="accion" value="inicioSocios">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Javascript-->
    <!--===============================================================================================-->
    <script src="../vendorLoginSocios/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendorLoginSocios/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendorLoginSocios/bootstrap/js/popper.js"></script>
    <script src="../vendorLoginSocios/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendorLoginSocios/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendorLoginSocios/daterangepicker/moment.min.js"></script>
    <script src="../vendorLoginSocios/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="../vendorLoginSocios/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="../js/accesoSocios.js"></script>
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>
  </body>
</html>