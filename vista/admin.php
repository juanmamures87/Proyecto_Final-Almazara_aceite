<!DOCTYPE html>
<html class="wide wow-animation" lang="es">
  <head>
    <title>Molino del Sur - Administración</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="../images/favicon32.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Estilos-->
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <body>

  <header>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-sm bg-opacity-25 bg-black navbar-light fixed-top">
      <div class="container-fluid" id="navegador">
        <h3>Administrador: <span id="nombreAdmin"><?php if (isset($nombre, $dni)) { echo $nombre . " - " . $dni; } ?></span></h3>
        <h3>Fecha: <span id="fechaHoraAdmin"></span></h3>
        <img src="../images/LogoPaginaAdmin.png" alt="Molino del Sur" class="navbar-brand ml-5">
      </div>
    </nav>
  </header>

  <aside>
    <!-- Menú de navegación lateral -->
    <div class="sidenav">
      <h3>Socios</h3>
      <h3>Clientes</h3>
      <h3>Parcelas</h3>
      <h3>Producción</h3>
      <h3>Tienda</h3>
      <h3>Ventas</h3>
      <h3>Noticias</h3>

      <form action="index.php" method="post">
        <input type="submit" class="btn btn-warning" id="cierreSesionAdmin" value="Cerrar Sesión">
        <input type="hidden" name="controlador" value="cerrarSesion">
        <input type="hidden" name="accion" value="cerrarSesion">
      </form>
    </div>
  </aside>

  <section id="contenedorAccionesAdmin">

    <article id="seccionSocios">

      <h1 class="tituloSeccion">Socios</h1>
      <div class="registroSeccion" id="registroSeccionSocios">

        <form class="p-2">
          <div class="form-group">
            <label for="nombreSocio" class="col-sm-2 col-form-label">Nombre: </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nombreSocio" name="nombreSocio" required>
            </div>
          </div>
          <div class="form-group">
            <label for="apeSocio" class="col-sm-2 col-form-label">Apellidos: </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="apeSocio" name="apeSocio" required>
            </div>
          </div>
          <div class="form-group">
            <label for="dniSocio" class="col-sm-2 col-form-label">DNI: </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="dniSocio" name="dniSocio" required>
            </div>
          </div>
          <div class="form-group">
            <label for="telSocio" class="col-sm-2 col-form-label">Teléfono: </label>
            <div class="col-sm-10">
              <input type="tel" class="form-control" id="telSocio" name="telSocio" required>
            </div>
          </div>
          <div class="form-group">
            <label for="provSocio" class="col-sm-2 col-form-label">Provincia: </label>
            <div class="col-sm-10">
              <select class="form-control" name="provSocio" id="provSocio" required>
                <b><option class="text-center" value="PROVINCIA">PROVINCIA</option></b>

                  <?php
                      if (isset($resultado) && !empty($resultado)){

                          $provincias = $resultado['consulta_provinciero']['provinciero']['prov'];
                          foreach ($provincias as $provincia){

                              ?>

                            <option><?php echo utf8_encode($provincia['np'])?></option>

                              <?php

                          }
                      }

                  ?>

              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="munSocio" class="col-sm-2 col-form-label">Municipio: </label>
            <div class="col-sm-10">
              <select class="form-control" name="munSocio" id="munSocio" required>

                <option class="text-center" value="MUNICIPIO">MUNICIPIO</option>

              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="dirSocio" class="col-sm-2 col-form-label">Dirección: </label>
            <div class="col-sm-10">
              <select class="form-control" name="dirSocio" id="dirSocio" required>

                <option class="text-center" value="DIRECCIÓN">DIRECCIÓN</option>

              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="cpSocio" class="col-sm-8 col-form-label">Código Postal: </label>
            <div class="col-sm-10">
              <select class="form-control" name="cpSocio" id="cpSocio" required>

                <option class="text-center" value="CÓDIGO POSTAL">CÓDIGO POSTAL</option>

              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="numCasaSocio" class="col-sm-8 col-form-label">Número Casa: </label>
            <div class="col-sm-10">
              <input type="number" min="1" max="999" class="form-control" id="numCasaSocio" name="numCasaSocio" required>
            </div>
          </div>
          <div class="form-group">
            <label for="pisoSocio" class="col-sm-2 col-form-label">Piso: </label>
            <div class="col-sm-10">
              <input type="number" min="0" max="99" class="form-control" id="pisoSocio" name="pisoSocio">
            </div>
          </div>
          <div class="form-group">
            <label for="puertaSocio" class="col-sm-2 col-form-label">Puerta: </label>
            <div class="col-sm-10">
              <input type="text" class="form-control" minlength="1" maxlength="10" id="puertaSocio" name="puertaSocio">
            </div>
          </div>
          <div class="form-group">
            <label for="emailSocio" class="col-sm-2 col-form-label">Email: </label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="emailSocio" name="emailSocio" required>
            </div>
          </div>
          <div class="form-group">
            <label for="passwSocio" class="col-sm-2 col-form-label">Contraseña: </label>
            <div class="col-sm-10">
              <input type="password" class="form-control" minlength="6" maxlength="10" id="passwSocio" name="passwSocio" required>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2">Activo</div>
            <div class="col-sm-10">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="activoSocio" id="activoSocio">
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-10">
              <button type="submit" name="registroSocio" id="registroSocio" class="btn btn-primary">Registrar</button>
            </div>
          </div>
        </form>

      </div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <article id="seccionClientes" hidden>

      <h1 class="tituloSeccion">Clientes</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <article id="seccionParcelas" hidden>

      <h1 class="tituloSeccion">Parcelas</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <article id="seccionProduccion" hidden>

      <h1 class="tituloSeccion">Producción</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <article id="seccionTienda" hidden>

      <h1 class="tituloSeccion">Tienda</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <article id="seccionVentas" hidden>

      <h1 class="tituloSeccion">Ventas</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <article id="seccionNoticias" hidden>

      <h1 class="tituloSeccion">Noticias</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

  </section>

  <!-- Optional JavaScript! -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/7b55877beb.js" crossorigin="anonymous"></script>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/zonaAdmin.js"></script>
  </body>
</html>