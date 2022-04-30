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
        <h3>Administrador: <span id="nombreAdmin"><?php if (isset($nombre)) { echo $nombre; } ?></span></h3>
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
      <h3>Productos</h3>
      <h3>Ventas</h3>
      <h3>Noticias</h3>

      <form action="index.php" method="post">
        <input type="submit" class="btn btn-warning" id="cierreSesionAdmin" value="Cerrar Sesión">
        <input type="hidden" name="controlador" value="cerrarSesion">
        <input type="hidden" name="accion" value="cerrarSesion">
      </form>
    </div>
  </aside>

  <section id="seccionSocios" hidden>

    <article>

      <h1>Prueba de los socios</h1>

    </article>

  </section>

  <section id="seccionClientes" hidden>

    <article>

      <h1>Prueba de los socios</h1>

    </article>

  </section>

  <section id="seccionParcelas" hidden>

    <article>

      <h1>Prueba de los socios</h1>

    </article>

  </section>

  <section id="seccionProduccion" hidden>

    <article>

      <h1>Prueba de los socios</h1>

    </article>

  </section>

  <section id="seccionProductos" hidden>

    <article>

      <h1>Prueba de los socios</h1>

    </article>

  </section>
  <section id="seccionVentas" hidden>

    <article>

      <h1>Prueba de los socios</h1>

    </article>

  </section>
  <section id="seccionNoticias" hidden>

    <article>

      <h1>Prueba de los socios</h1>

    </article>

  <!-- Optional JavaScript! -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/7b55877beb.js" crossorigin="anonymous"></script>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="../js/zonaAdmin.js"></script>
  </body>
</html>