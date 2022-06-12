<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Molino del Sur - Tienda</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../images/favicon32.png" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/principalTienda.css">
    <link rel="stylesheet" href="../css/inicioSesionUsuario.css">
    <link rel="stylesheet" href="../css/registroUsuario.css">
  </head>
  <body>

  <!-- Contenedor que hará de pantalla para oscurecer la página y resaltar el inicio de sesión -->
  <div id="contenedorOscuro"></div>
  <!--------------------------------------------------------------------------------------------->

    <div class="preloader">
      <div class="preloader-body">
        <div class="cssload-container"><span></span><span></span><span></span><span></span>
        </div>
      </div>
    </div>
    <div class="page">
      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap rd-navbar-modern-wrap">
          <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed"
               data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static"
               data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static"
               data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px"
               data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="70px" data-lg-stick-up="true" data-xl-stick-up="true"
               data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand">
                    <a class="brand" href="portada">
                      <img id="logoEmpresaIndex" class="mt-2" src="../images/LogoFinal-200px.png" alt="Logo Molino del sur"/>
                      <span id="nombreEmpresaInicio" class="h3">Molino del Sur</span>
                    </a>
                  </div>
                </div>
                <div class="rd-navbar-main-element">
                  <div class="rd-navbar-nav-wrap">
                    <!-- RD Navbar Nav-->
                    <ul class="rd-navbar-nav">
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="tienda">Tienda</a></li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="quienesSomos">Quienes somos</a></li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="contacto">Contacto</a></li>
                    </ul>
                    <!-- Zona donde irá el nombre de usuario si inicia sesión -->
                    <p id="nombreUsuarioSesionCarrito" class="mb-2"></p>
                    <!---------------------------------------------------------->
                  </div>
                  <div class="rd-navbar-project-hamburger datosAdicionales" data-multitoggle=".rd-navbar-main" data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate>
                    <div class="project-hamburger"><span class="project-hamburger-arrow-top"></span><span class="project-hamburger-arrow-center"></span><span class="project-hamburger-arrow-bottom"></span></div>
                    <div class="project-hamburger-2"><span class="project-hamburger-arrow"></span><span class="project-hamburger-arrow"></span><span class="project-hamburger-arrow"></span>
                    </div>
                    <div class="project-close"><span></span><span></span></div>
                  </div>
                </div>
                <div class="rd-navbar-project rd-navbar-modern-project">
                  <div class="rd-navbar-project-modern-header">
                    <h4 class="rd-navbar-project-modern-title">Contactar</h4>
                    <div class="rd-navbar-project-hamburger" data-multitoggle=".rd-navbar-main" data-multitoggle-blur=".rd-navbar-wrap" data-multitoggle-isolate>
                      <div class="project-close"><span></span><span></span></div>
                    </div>
                  </div>
                  <div class="rd-navbar-project-content rd-navbar-modern-project-content">
                    <div>
                      <p>Siempre estamos listos para ofrecerle nuestro mejor aceite para su hogar o empresa. Contáctenos para saber cómo podemos ayudarlo .</p>
                      <div class="heading-6 subtitle">Nuestros contactos</div>
                      <div class="row row-10 gutters-10">
                        <div class="col-12"><img src="../images/sideBar-1-expasionTransporte394x255.jpg" alt="" width="394" height="255"/>
                        </div>
                      </div>
                      <ul class="rd-navbar-modern-contacts">
                        <li>
                          <div class="unit unit-spacing-sm">
                            <div class="unit-left"><span class="icon fa fa-phone"></span></div>
                            <div class="unit-body"><a class="link-phone" href="tel:#">680487543</a></div>
                          </div>
                        </li>
                        <li>
                          <div class="unit unit-spacing-sm">
                            <div class="unit-left"><span class="icon fa fa-location-arrow"></span></div>
                            <div class="unit-body"><a class="link-location" href="https://goo.gl/maps/3zVLsyz1FSQDaX1z6" target="_blank">Mures, Alcalá la Real, Jaén, Cp:23686</a></div>
                          </div>
                        </li>
                        <li>
                          <div class="unit unit-spacing-sm">
                            <div class="unit-left"><span class="icon fa fa-envelope"></span></div>
                            <div class="unit-body"><a class="link-email" href="mailto:#">pruebas2cfgs@gmail.com</a></div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>

      <!-- Fragmento de código con el inicio de sesión del usuario -->
      <div id="inicioSesionUsuario">
          <?php require_once 'vista/inicioSesionUsuario.html'; ?>
      </div>

      <div id="registroUsuario">
          <?php require_once 'vista/registroUsuario.php'; ?>
      </div>

      <!-- Breadcrumbs -->
      <section class="breadcrumbs-custom-inset">
        <div class="breadcrumbs-custom context-dark bg-overlay-33">
          <div class="container">
            <h2 class="breadcrumbs-custom-title">Carrito de la compra</h2>
            <ul class="breadcrumbs-custom-path">
              <li><a href="portada">Inicio</a></li>
              <li><a href="tienda">Tienda</a></li>
              <li class="active">Carrito</li>
            </ul>
          </div><!-- Aquí va la imagen de 1920x560 -->
          <div class="box-position" style="background-image: url(../images/carritoCompra1920x560.png);"></div>
        </div>
      </section>
      <!--------------------------------------------------------------------------------->
      <!-- Cuerpo del carrito de la compra con las tarjetas que contienen los productos-->
      <!--------------------------------------------------------------------------------->
      <section id="cuerpoPaginaCarrito" class="container-fluid mt-5 mb-5">

        <div class="row col-lg-12">
          <div id="cuerpoCarritoCompra" class="container border col-lg-8">
            <div class="row align-items-center" id="cabeceraTablaPaginaCarrito">

              <div class="col-lg-6"><h6>PRODUCTO</h6></div>
              <div class="col-lg-2"><h6>PRECIO</h6></div>
              <div class="col-lg-2"><h6>CANTIDAD</h6></div>
              <div class="col-lg-2"><h6>SUBTOTAL</h6></div>

            </div>
            <div id="filasProductos">

            </div>
          </div>

          <div class="container col-lg-4 float-right" id="resultadoFinal">

            <div class="w-100 text-left mt-3"><b>Subtotal</b><div class="text-right mr-2" id="subtotalCompra"></div></div>
            <hr>
            <div class="w-100 text-left mt-3"><b>Envío</b> (Envío gratuito por compra superior a 100€)<div class="text-right mr-2" id="envioCompra">5<span>€</span></div></div>
            <hr>
            <div class="w-100 text-left mt-3"><b>Total</b><div class="text-right mr-2" id="totalCompra"></div></div>
            <hr>
            <button id="finalizarCompra">Finalizar compra</button>

          </div>
        </div>
      </section>
      <!-- Footer de la página-->
      <footer class="section footer-variant-2 footer-modern context-dark section-top-image section-top-image-dark">
        <div class="footer-variant-2-content">
          <div class="container">
            <div class="row row-40 justify-content-between">
              <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="oh-desktop">
                  <div class="wow slideInRight" data-wow-delay="0s">
                    <!-- Nombre y logo de la empresa del footer -->
                    <div class="rd-navbar-brand">
                      <a class="brand" href="portada">
                        <img id="logoEmpresaFooter" src="../images/LogoFinal-200px.png" alt="Logo Molino del sur"/>
                        <span id="nombreEmpresaFooter" class="h3">Molino del Sur</span>
                      </a>
                    </div>                    <p>Molino del Sur es una pequeña almazara cooperativa de aceite. Ofrecemos uno de los mejores aceites de oliva virgen extra de la provincia</p>
                    <ul class="footer-contacts d-inline-block d-md-block">
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon fa fa-phone"></span></div>
                          <div class="unit-body"><a class="link-phone" href="tel:#">680497543</a></div>
                        </div>
                      </li>
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon fa fa-clock-o"></span></div>
                          <div class="unit-body">
                            <p>Lunes a Viernes:<br>08:30-13:30 - 16:00-19:00</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="unit unit-spacing-xs">
                          <div class="unit-left"><span class="icon fa fa-location-arrow"></span></div>
                          <div class="unit-body"><a class="link-location" href="https://goo.gl/maps/3zVLsyz1FSQDaX1z6" target="_blank">Mures, Alcalá la Real<br>Jaén<br>Cp: 23686</a></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 col-xl-4">
                <div class="oh-desktop">
                  <div class="inset-top-18 wow slideInDown" data-wow-delay="0s">
                    <h5>Boletín informativo</h5>
                    <p>Únase a nuestro boletín electrónico para recibir noticias y consejos.</p>
                    <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="subscribe" method="post" action="../bat/rd-mailform.php">
                      <div class="form-wrap">
                        <input class="form-input" id="subscribe-form-5-email" type="email" name="email" data-constraints="@Email @Required">
                        <label class="form-label" for="subscribe-form-5-email">Introduce tu email</label>
                      </div>
                      <button class="button button-block button-white" type="submit">Suscríbete</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-xl-3">
                <div class="oh-desktop">
                  <div class="inset-top-18 wow slideInLeft" data-wow-delay="0s">
                    <h5>Galería</h5>
                    <div class="row row-10 gutters-10" data-lightgallery="group">
                      <div class="col-6 col-sm-3 col-lg-6">
                        <!-- Fotos miniatura footer -->
                        <article class="thumbnail thumbnail-mary">
                          <div class="thumbnail-mary-figure"><img src="../images/footer-2-aceiteRomero129x120.jpg" alt="" width="129" height="120"/>
                          </div>
                          <div class="thumbnail-mary-caption"><a class="icon fl-bigmug-line-zoom60" href="../images/footer-2-aceiteRomero800x1200.jpg" data-lightgallery="item"><img src="../images/footer-2-aceiteRomero129x120.jpg" alt="" width="129" height="120"/></a>
                          </div>
                        </article>
                      </div>
                      <div class="col-6 col-sm-3 col-lg-6">
                        <!-- Fotos miniatura footer -->
                        <article class="thumbnail thumbnail-mary">
                          <div class="thumbnail-mary-figure"><img src="../images/footer-1-ramitaGota129.jpg" alt="" width="129" height="120"/>
                          </div>
                          <div class="thumbnail-mary-caption"><a class="icon fl-bigmug-line-zoom60" href="../images/footer-1-ramitaGota1200x800.jpg" data-lightgallery="item"><img src="../images/footer-1-ramitaGota129.jpg" alt="" width="129" height="120"/></a>
                          </div>
                        </article>
                      </div>
                      <div class="col-6 col-sm-3 col-lg-6">
                        <!-- Fotos miniatura footer -->
                        <article class="thumbnail thumbnail-mary">
                          <div class="thumbnail-mary-figure"><img src="../images/footer-3-aceitePanAjo129x120.jpg" alt="" width="129" height="120"/>
                          </div>
                          <div class="thumbnail-mary-caption"><a class="icon fl-bigmug-line-zoom60" href="../images/footer-3-aceitePanAjo800x1200.jpg" data-lightgallery="item"><img src="../images/footer-3-aceitePanAjo129x120.jpg" alt="" width="129" height="120"/></a>
                          </div>
                        </article>
                      </div>
                      <div class="col-6 col-sm-3 col-lg-6">
                        <!-- Fotos miniatura footer -->
                        <article class="thumbnail thumbnail-mary">
                          <div class="thumbnail-mary-figure"><img src="../images/footer-4-cuenquito129.jpg" alt="" width="129" height="120"/>
                          </div>
                          <div class="thumbnail-mary-caption"><a class="icon fl-bigmug-line-zoom60" href="../images/footer-4-cuenquito1200x800.jpg" data-lightgallery="item"><img src="../images/footer-4-cuenquito129.jpg" alt="" width="129" height="120"/></a>
                          </div>
                        </article>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-variant-2-bottom-panel">
          <div class="container">
            <!-- Derechos -->
            <div class="group-sm group-sm-justify">
              <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span> <span>Molino del Sur</span>. Todos los derechos reservados
              </p>
              <p class="rights">Diseñado por Juan María Castro Arjona 2ºDAW IES Alfonso XI</p>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- Salida global del formulario de correo-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Salida de mensaje para las diferentes acciones -->
    <div id="mensajeTienda"></div>
    <!-- Javascript-->
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/principal.js"></script>
    <script src="../js/principalTienda.js"></script>
    <script src="../js/principalCarrito.js"></script>
  </body>
</html>