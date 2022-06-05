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

  <!-- Contenedores que albergarán los mensajes correctos y de error -->
  <div id="error"></div><div><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i></div>
  <div id="correcto"></div><div><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i></div>

  <header>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-sm navbar-light fixed-top">
      <div class="container-fluid d-flex justify-content-between align-items-center" id="navegador">
        <h3>Administrador: <span id="nombreAdmin"><?php if (isset($nombre, $dni)) { echo $nombre . " - " . $dni; } ?></span></h3>
        <h3>Fecha: <span id="fechaHoraAdmin"></span></h3>
        <img src="../images/LogoPaginaAdmin.png" alt="Molino del Sur" class="navbar-brand ml-5">
      </div>
    </nav>
  </header>

  <nav>
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
  </nav>

  <section id="contenedorAccionesAdmin">

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// SECCIÓN DE LOS SOCIOS ////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <article id="seccionSocios">

      <h1 class="tituloSeccion">Socios</h1>
      <div class="registroSeccion" id="registroSeccionSocios">

        <form id="formularioRegistroSocios">
          <div class="form-group">
            <label for="nombreSocio" class="col-sm-2 col-form-label is-required"><b>Nombre: </b></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nombreSocio" name="nombreSocio" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" required>
            </div>
          </div>
          <div class="form-group">
            <label for="apeSocio" class="col-sm-2 col-form-label is-required"><b>Apellidos: </b></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="apeSocio" name="apeSocio"
                     pattern="^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$" required>
            </div>
          </div>
          <div class="form-group">
            <label for="dniSocio" class="col-sm-2 col-form-label is-required"><b>DNI: </b></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="dniSocio" name="dniSocio" maxlength="9" placeholder="12345678L" required>
            </div>
          </div>
          <div class="form-group">
            <label for="telSocio" class="col-sm-2 col-form-label is-required"><b>Teléfono: </b></label>
            <div class="col-sm-10">
              <input type="tel" class="form-control" min="60000000" max="999999999" id="telSocio" name="telSocio" pattern="^(6|7|8|9)[ -]*([0-9][ -]*){8}"
                     placeholder="000112233" required>
            </div>
          </div>
          <div class="form-group">
            <label for="provSocio" class="col-sm-2 col-form-label is-required"><b>Provincia: </b></label>
            <div class="col-sm-10">
              <select class="form-control" name="provSocio" id="provSocio">
                <option class="text-center" value="PROVINCIA">PROVINCIA</option>

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
            <div class="col-sm-10">
              <label for="provSocioAlterna">Provincia alternativa: </label>
              <input type="text" class="form-control" id="provSocioAlterna" name="provSocioAlterna">
            </div>
          </div>
          <div class="form-group">
            <label for="munSocio" class="col-sm-2 col-form-label is-required"><b>Municipio: </b></label>
            <div class="col-sm-10">
              <select class="form-control" name="munSocio" id="munSocio">

                <option class="text-center" value="MUNICIPIO">MUNICIPIO</option>

              </select>
            </div>
            <div class="col-sm-10">
              <label for="munSocioAlterna">Municipio alternativo: </label>
              <input type="text" class="form-control" id="munSocioAlterna" name="munSocioAlterna">
            </div>
          </div>
          <div class="form-group">
            <label for="dirSocio" class="col-sm-2 col-form-label is-required"><b>Dirección: </b></label>
            <div class="col-sm-10">
              <select class="form-control" name="dirSocio" id="dirSocio">

                <option class="text-center" value="DIRECCIÓN">DIRECCIÓN</option>

              </select>
            </div>
            <div class="col-sm-10">
              <label for="dirSocioAlterna">Dirección alternativa: </label>
              <input type="text" class="form-control" id="dirSocioAlterna" name="dirSocioAlterna">
            </div>
          </div>
          <div class="form-group">
            <label for="cpSocio" class="col-sm-8 col-form-label is-required"><b>Código Postal: </b></label>
            <div class="col-sm-10">
              <select class="form-control" name="cpSocio" id="cpSocio">

                <option class="text-center" value="CÓDIGO POSTAL">CÓDIGO POSTAL</option>

              </select>
            </div>
            <div class="col-sm-10">
              <label for="cpSocioAlterna">Código postal alternativo: </label>
              <input type="number" class="form-control" min="10000" max="99999" id="cpSocioAlterna" name="cpSocioAlterna">
            </div>
          </div>
          <div class="form-group">
            <label for="numCasaSocio" class="col-sm-8 col-form-label is-required"><b>Número Casa: </b></label>
            <div class="col-sm-10">
              <input type="number" min="1" max="999" class="form-control" id="numCasaSocio" name="numCasaSocio" required>
            </div>
          </div>
          <div class="form-group">
            <label for="pisoSocio" class="col-sm-2 col-form-label"><b>Piso: </b></label>
            <div class="col-sm-10">
              <input type="number" min="0" max="99" class="form-control" id="pisoSocio" name="pisoSocio">
            </div>
          </div>
          <div class="form-group">
            <label for="puertaSocio" class="col-sm-2 col-form-label"><b>Puerta: </b></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" minlength="1" maxlength="10" id="puertaSocio" name="puertaSocio">
            </div>
          </div>
          <div class="form-group">
            <label for="emailSocio" class="col-sm-2 col-form-label is-required"><b>Email: </b></label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="emailSocio" name="emailSocio"
                     pattern="^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$" placeholder="correo@yopmail.org" required>
            </div>
          </div>

          <div class="form-group mt-3">
            <div class="col-sm-12"><b>Permitir/No permitir acceso</b></div>
            <div class="col-sm-10">
              <div class="form-check">
                <label class="form-check-label"><span id="muestraActiv">Desactivado</span></label>
                  <input class="form-check-input" type="checkbox" name="activoSocio" id="activoSocio">
              </div>
            </div>
          </div>
          <hr class="w-75">
          <div class="form-group row mb-4 mt-4">
            <div class="col-sm-10">
              <button type="submit" name="registroSocio" value="registroEnviado" id="registroSocio" class="btn btn-primary">Registrar</button>
              <button type="reset" name="borradoRegistroSocio" id="borradoRegistroSocio" class="btn btn-warning">Resetear</button>
            </div>
          </div>
        </form>

      </div>
      <div class="muestraSeccion" id="mostrarSeccionSocios">

        <table class="table table-striped" id="tablaSocios">
          <thead>
          <tr>
            <th scope="col">Socio</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Dni</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Provincia</th>
            <th scope="col">Municipio</th>
            <th scope="col">Dirección</th>
            <th scope="col">Cp</th>
            <th scope="col">Número</th>
            <th scope="col">Piso</th>
            <th scope="col">Puerta</th>
            <th scope="col">Email</th>
            <th scope="col">Acceso</th>
            <th scope="col">Tipo</th>
            <th scope="col">F.Alta</th>
            <th scope="col">F.Baja</th>
            <th scope="col">Modificar</th>
            <th scope="col">Eliminar</th>
          </tr>
          </thead>
          <tbody>
            <?php

                if (isset($mostrarSocios) && !empty($mostrarSocios)){

                    //Aquí guardamos el número de páginas que tendremos en la paginación, recogido del modelo a través del controlador
                    $paginasPaginacion = $mostrarSocios['paginas'];
                    //Eliminamos el valor de la paginación del array de los usuarios para no tener problemas al sacar datos
                    unset($mostrarSocios['paginas']);
                    foreach ($mostrarSocios as $valor){

                      foreach ($valor as $socio){

                        $extraerFecha = explode('-',$socio->fecha_alta) ;//date($socio->fecha_alta);
                        $nuevaFechaAlta = $extraerFecha[2] . "/" . $extraerFecha[1] . "/" . $extraerFecha[0];

            ?>
                          <tr>
                            <th><?php echo $socio->id_socio; ?></th>
                            <td><?php echo $socio->nombre; ?></td>
                            <td><?php echo $socio->apellidos; ?></td>
                            <td><?php echo $socio->dni; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->telefono; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->provincia; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->municipio; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->direccion; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->cp; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->num_casa; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->piso; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->puerta; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->email; ?></td>
                            <td title="Campo editable"><?php $socio->activo == 1 ?
                                    $activado = "Activo <br> <input type='checkbox' class='accesoTabla' checked>" : $activado = "Desactivado <br> <input type='checkbox' class='accesoTabla'>"; echo $activado;?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->tipo_socio; ?></td>
                            <td><?php echo $nuevaFechaAlta; ?></td>
                            <td contenteditable="true" title="Campo editable"><?php echo $socio->fecha_baja; ?></td>
                            <td><i title="Pulse para modificar con los datos introducidos" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                            <td><i title="Pulse para eliminar el socio seleccionado" class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                          </tr>

            <?php
                        }
                    }

                }

            ?>
          </tbody>
        </table>

        <nav aria-label="Page navigation example" id="navPaginacionSocios">
          <ul title="Pulse para cambiar de página o actualizar" class="pagination justify-content-center">
            <?php

                if (isset($paginasPaginacion)) {
                    for ($i = 1; $i <= $paginasPaginacion;$i++){
            ?>

                      <li data-pagina="<?php echo $i ?>" class="page-item"><a class="page-link" href=""><?php echo $i ?></a></li>

              <?php
                    }
                }
            ?>
          </ul>
          <div class="text-center w-25 m-auto text-decoration-underline">
          <span id="muestraPaginaSocios"></span>
          </div>
        </nav>

      </div>

    </article>

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////// SECCIÓN DE LOS SOCIOS ////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <article id="seccionClientes" hidden>

      <h1 class="tituloSeccion">Clientes</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// SECCIÓN DE LAS PARCELAS //////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <article id="seccionParcelas" hidden>

      <h1 class="tituloSeccion" id="tituloSeccionParcelas">Parcelas</h1>
      <div class="registroSeccion" id="registroSeccionParcelas">

        <form class="row gx-3 gy-2 align-items-center" id="formularioRegistroParcelas">
          <div class="col-sm-2">
            <label class="visually-hidden" for="busSocioParcela">Socio</label>
            <input type="search" class="form-control" id="busSocioParcela" name="busSocioParcela" placeholder="Búsqueda parcial">
          </div>
          <div class="col-sm-2">
            <select class="form-select" name="selSocioParcela" id="selSocioParcela">
              <option class="text-center" value="SOCIOS">SOCIOS</option>
            </select>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="selProvParcela">Provincia</label>
            <select class="form-select" id="selProvParcela" name="selProvParcela">

              <option class="text-center" value="PROVINCIA">PROVINCIA</option>

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
          <div class="col-sm-2">
            <label class="visually-hidden" for="selMunParcela">Municipio</label>
            <select class="form-select" id="selMunParcela" name="selMunParcela">
              <option class="text-center" value="MUNICIPIO">MUNICIPIO</option>

            </select>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="refCatParcela">Ref. Catastral</label>
            <input type="text" class="form-control" minlength="14" maxlength="20" id="refCatParcela" name="refCatParcela"
                   placeholder="Ref. Catastral">
          </div>
          <div class="col-sm-1">
            <label class="visually-hidden" for="polParcela">Polígono</label>
            <input type="number" class="form-control" id="polParcela" name="polParcela" placeholder="Polígono">
          </div>
          <div class="col-sm-1">
            <label class="visually-hidden" for="parParcela">Parcela</label>
            <input type="text" class="form-control" id="parParcela" name="parParcela" placeholder="Parcela">
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="superParcela">Superficie</label>
            <input type="number" step="0.1" class="form-control" id="superParcela" name="superParcela" placeholder="Superficie m.cuadrados">
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="selSisParcela">Sistema cultivo</label>
            <select class="form-select" id="selSisParcela" name="selSisParcela">
              <option class="text-center" value="SISTEMA CULTIVO">SISTEMA CULTIVO</option>

                <?php
                    if (isset($sistema) && !empty($sistema)){

                        foreach ($sistema as $sisCultivo){

                            ?>

                          <option value="<?php echo $sisCultivo->id_sistema?>"><?php echo $sisCultivo->nombre?></option>

                            <?php

                        }
                    }

                ?>

            </select>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="selVarParcela">Variedad aceituna</label>
            <select class="form-select" id="selVarParcela" name="selVarParcela">
              <option class="text-center" value="VARIEDAD ACEITUNA">VARIEDAD ACEITUNA</option>

                <?php
                    if (isset($variedad) && !empty($variedad)){

                        foreach ($variedad as $varAceituna){

                            ?>

                          <option value="<?php echo $varAceituna->id_aceituna?>"><?php echo $varAceituna->nombre?></option>

                            <?php

                        }
                    }

                ?>

            </select>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="plantasParcela">Num. Plantas</label>
            <input type="number" class="form-control" id="plantasParcela" name="plantasParcela" placeholder="Num. Plantas">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary mx-3" id="registroParcelas">Registrar</button>
            <button type="reset" class="btn btn-warning mx-2" id="resetFormParcelas">Resetear</button>
            <button class="btn btn-success botonSeleccionDatos mx-4" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#seleccionDatosParcelas" aria-controls="seleccionDatosParcelas">
              Visualizar Datos
            </button>
          </div>
        </form>

        <!-------------------------------------------------------------------------------------------->
        <!-- Menú lateral desplegable para seleccionar como ver los datos referentes a las parcelas -->
        <!-------------------------------------------------------------------------------------------->
        <div class="offcanvas offcanvas-start mt-5" tabindex="-1" id="seleccionDatosParcelas" aria-labelledby="seleccionDatosParcelasEtiqueta">
          <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="seleccionDatosParcelasEtiqueta">DATOS PARCELAS</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <hr>
            <label class="mt-3" for="busProv"><b>Búsqueda por socio: </b></label>
            <div class="d-flex flex-row">
              <div class="col-sm-4">
                <label class="visually-hidden" for="busSocioParcelaMuestra">Socio</label>
                <input type="search" class="form-control" id="busSocioParcelaMuestra" placeholder="B. Parcial">
              </div>
              <div class="col-sm-8">
                <select class="form-select" id="selSocioParcelaMuestra">
                  <option class="text-center" value="SOCIOS">SOCIOS</option>
                </select>
              </div>
            </div>
            <label class="mt-3" for="busProv"><b>Búsqueda por provincia: </b></label>
            <select class="form-select visualizar" aria-label="Default select example" id="busProv">
              <option class="text-center" value="PROVINCIA">PROVINCIA</option>

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
            <label class="mt-3" for="busSuper"><b>Búsqueda por superficie en m<sup>2</sup>: </b></label>
            <select class="form-select visualizar" aria-label="Default select example" id="busSuper">
              <option class="text-center" value="SUPERFICIE">SUPERFICIE</option>
              <option value="0-5000"> < 5000</option>
              <option value="5000-20000"> > 5000 y < 20000</option>
              <option value="20000-50000"> > 20000 y < 50000</option>
              <option value="50000-100000"> > 50000 y < 100000</option>
              <option value="100000-1000000"> > 100000</option>
            </select>
            <label class="mt-3" for="busSisCul"><b>Sistema de cultivo: </b></label>
            <select class="form-select visualizar" aria-label="Default select example" id="busSisCul">
              <option class="text-center" value="SISTEMA CULTIVO">SISTEMA CULTIVO</option>

                <?php
                    if (isset($sistema) && !empty($sistema)){

                        foreach ($sistema as $sisCultivo){

                            ?>

                          <option value="<?php echo $sisCultivo->id_sistema?>"><?php echo $sisCultivo->nombre?></option>

                            <?php

                        }
                    }

                ?>
            </select>
            <label class="mt-3" for="busVar"><b>Variedad aceituna: </b></label>
            <select class="form-select visualizar" aria-label="Default select example" id="busVar">
              <option class="text-center" value="VARIEDAD ACEITUNA">VARIEDAD ACEITUNA</option>

                <?php
                    if (isset($variedad) && !empty($variedad)){

                        foreach ($variedad as $varAceituna){

                            ?>

                          <option value="<?php echo $varAceituna->id_aceituna?>"><?php echo $varAceituna->nombre?></option>

                            <?php

                        }
                    }

                ?>
            </select>
            <label class="mt-3" for="busPlan"><b>Número de plantas: </b></label>
            <select class="form-select visualizar" aria-label="Default select example" id="busPlan">
              <option class="text-center" value="PLANTAS">PLANTAS</option>
              <option value="0-100"> < 100</option>
              <option value="100-500"> > 100 y < 500 </option>
              <option value="500-2000"> > 500 < 2000 </option>
              <option value="2000-10000"> > 2000 </option>
            </select>
            <button class="btn btn-danger" id="limpiaTablaParcelas">Limpiar tabla</button>
          </div>
        </div>
        <!-------------------------------------------------------------------------------------------->
        <!----- ACABA EL MENÚ DESPLEGABLE DE SELECCIÓN DE VISUALIZAR LOS DATOS DE LAS PARCELAS ------->
        <!-------------------------------------------------------------------------------------------->
      </div>

      <div class="muestraSeccion" id="mostrarSeccionParcelas">

          <table class="table table-striped h6 text-sm-center" id="tablaParcelas">

            <thead>
            <tr>
              <th scope="col">Id Parcela</th>
              <th scope="col">Id Socio</th>
              <th scope="col">Apellidos</th>
              <th scope="col">Nombre</th>
              <th scope="col">Provincia</th>
              <th scope="col">Municipio</th>
              <th scope="col">Ref. Catastral</th>
              <th scope="col">Polígono</th>
              <th scope="col">Parcela</th>
              <th scope="col">Superficie</th>
              <th scope="col">Sistema</th>
              <th scope="col">Variedad</th>
              <th scope="col">Plantas</th>
              <th scope="col">Modificar</th>
              <th scope="col">Eliminar</th>
            </tr>
            </thead>
            <tbody></tbody>
          </table>
          <nav aria-label="Page navigation example" id="navPaginacionParcelas">
            <ul title="Pulse para cambiar de página o actualizar" class="pagination justify-content-center"></ul>
            <div class="text-center w-25 m-auto text-decoration-underline">
              <span id="muestraPaginaParcelas"></span>
            </div>
          </nav>

      </div>

    </article>

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// SECCIÓN DE LA PRODUCCIÓN //////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <article id="seccionProduccion" hidden>

      <h1 class="tituloSeccion" id="tituloProduccion">Producción</h1>
      <div class="registroSeccion" id="registroProduccion">

        <form class="row gx-3 gy-2 align-items-center" id="formularioRegistroProduccion">
          <div class="col-sm-2">
            <label class="visually-hidden" for="busSocioProd">Socio</label>
            <input type="search" class="form-control" id="busSocioProd" placeholder="Búsqueda parcial">
          </div>
          <div class="col-4">
            <label class="visually-hidden" for="selSocioProd">Socio</label>
            <select class="form-select" name="selSocioProd" id="selSocioProd">
              <option class="text-center" value="SOCIOS">SOCIOS</option>
            </select>
          </div>
          <div class="col-4">
            <label class="visually-hidden" for="selParcelaProd">Parcela</label>
            <select class="form-select" id="selParcelaProd" name="selParcelaProd">
              <option class="text-center" value="PARCELA">PARCELA</option>
            </select>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="selTipoProd">Tipo producto</label>
            <select class="form-select" id="selTipoProd" name="selTipoProd">
              <option class="text-center" value="TIPO PRODUCTO">TIPO PRODUCTO</option>
              <option value="suelo">Suelo</option>
              <option value="vuelo">Vuelo</option>
            </select>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="kgProd">Kilogramos</label>
            <input type="number" class="form-control" min="50" id="kgProd" name="kgProd" placeholder="Kilogramos" required>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="renProd">Rendimiento</label>
            <input type="number" class="form-control" min="18" max="25" id="renProd" name="renProd" placeholder="Rendimiento" required>
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="acidezProd">Acidez</label>
            <input type="number" step="0.1" min="0" max="2" class="form-control" id="acidezProd" name="acidezProd" placeholder="Acidez" required>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary mx-3" id="registroProd">Registrar</button>
            <button type="reset" class="btn btn-warning mx-2" id="resetFormProd">Resetear</button>
            <button class="btn btn-success botonSeleccionDatos mx-4" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#seleccionDatosProd" aria-controls="seleccionDatosProd">
              Visualizar Datos
            </button>
            <button type="button" class="btn btn-danger" id="limpiarTablaBusquedas">Limpiar tabla</button>
          </div>
        </form>

        <!----------------------------------------------------------------------------------------------------------->
        <!-- Menú lateral desplegable para seleccionar como ver los datos referentes a las remesas de producciones -->
        <!----------------------------------------------------------------------------------------------------------->
        <div class="offcanvas offcanvas-start mt-5" tabindex="-1" id="seleccionDatosProd" aria-labelledby="seleccionDatosProdEtiqueta">
          <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="seleccionDatosProdEtiqueta">DATOS PRODUCCIONES</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <hr>
            <label class="mt-3" for="busParcialProd"><b>Búsqueda por socio y temporada: </b></label>
            <div class="d-flex flex-row">
              <div class="col-sm-4">
                <label class="visually-hidden" for="busSocioProdMuestra">Socio</label>
                <input type="search" class="form-control" id="busSocioProdMuestra" placeholder="B. Parcial">
              </div>
              <div class="col-sm-8">
                <select class="form-select" id="selSocioProdMuestra">
                  <option class="text-center" value="SOCIOS">SOCIOS</option>
                </select>
              </div>
            </div>
            <select class="form-select visualizar" aria-label="Default select example" id="busProdTemporada">
              <option class="text-center" value="TEMPORADA">TEMPORADA</option>

                <?php
                    //Variables y bucle que comprende el año actual y 5 años antes para ver las anteriores producciones
                    //Y mostrarlas por un select para su elección
                    $lustroAtras = date('Y') - 5;
                    $yearActual = date('Y');
                    while ($lustroAtras < $yearActual){

                            ?>

                          <option value="<?php echo $lustroAtras . "/" . $lustroAtras + 1;?>"><?php echo $lustroAtras . "/" . $lustroAtras + 1;?></option>

                            <?php

                        $lustroAtras++;

                    }

                ?>
            </select>
            <hr>
            <label class="mt-5" for="busKgXtemp"><b>10 Mayores entradas de aceituna por temporada: </b></label>
            <select class="form-select visualizar" aria-label="Default select example" id="busKgXtemp">
              <option class="text-center" value="KGTEMPORADA">KG. TEMPORADA</option>

                <?php
                    //Variables y bucle que comprende el año actual y 5 años antes para ver las anteriores producciones
                    //Y mostrarlas por un select para su elección
                    $lustroAtras = date('Y') - 5;
                    $yearActual = date('Y');
                    while ($lustroAtras < $yearActual){

                        ?>

                      <option value="<?php echo $lustroAtras . "/" . $lustroAtras + 1;?>"><?php echo $lustroAtras . "/" . $lustroAtras + 1;?></option>

                        <?php

                        $lustroAtras++;

                    }

                ?>
            </select>
            <label class="mt-5" for="bus10EntradasTiempos"><b>10 Mayores entradas de aceituna en todos los tiempos de la almazara</b></label>
            <button type="button" class="btn btn-light w-100" id="bus10EntradasTiempos">MAYORES ENTRADAS</button>
          </div>
        </div>
        <!----------------------------------------------------------------------------------------------------------->
        <!-------- Acaba el menú lateral correspondiente a las búsquedas de las remesas de producción --------------->
        <!----------------------------------------------------------------------------------------------------------->

      </div>

      <!------------------------------ Apartado de muestra de datos de la producción ------------------------------>
      <div class="muestraSeccion" id="mostrarProduccion">

        <!------------------- Apartado de muestra del ticket de remesa de producción para imprimirlo --------------->
        <div id="apartadoTicket" hidden>

            <!-- Incluimos el ticket generado con los datos del socio y su remesa de producción -->
          <?php require_once "vista/ticketRemesa.html";?>

          <div id="botonesImprimirCancelar" class="d-flex flex-column">
            <button id="btnImprimirRemesa" class="btn btn-success mx-5 mb-5">Imprimir</button>
            <button id="cancelarImpresion" class="btn btn-secondary  mx-5">Cancelar</button>
          </div>
        </div>

        <!-- Tabla de muestra de datos de las remesas de producción -->
        <table class="table table-striped h6 text-sm-center" id="tablaProduccion">

          <thead>
          <tr>
            <th scope="col">Id Albarán</th>
            <th scope="col">Id Socio</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Nombre</th>
            <th scope="col">Provincia</th>
            <th scope="col">Municipio</th>
            <th scope="col">Ref. Catastral</th>
            <th scope="col">Polígono</th>
            <th scope="col">Parcela</th>
            <th scope="col">Kg. Aceituna</th>
            <th scope="col">Rendimiento</th>
            <th scope="col">Litros Aceite</th>
            <th scope="col">Acidez</th>
            <th scope="col">Tipo</th>
            <th scope="col">Fecha entrada</th>
            <th scope="col">Hora entrada</th>
          </tr>
          </thead>
          <tbody></tbody>
        </table>
        <nav aria-label="Page navigation example" id="navPaginacionProduccion">
          <ul class="pagination justify-content-center"></ul>
          <div class="text-center w-25 m-auto text-decoration-underline">
            <span id="muestraPaginaProduccion"></span>
          </div>
        </nav>
      </div>

    </article>

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// SECCIÓN DE LA TIENDA //////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <article id="seccionTienda" hidden>

      <h1 class="tituloSeccion" id="tituloTienda">Tienda</h1>
      <div class="registroSeccion" id="registroTienda">

        <form class="row align-items-center" id="formularioRegistroTienda">
          <div class="input-group gap-2">
            <div class="col-sm-3">
              <label class="visually-hidden" for="nomProducto"></label>
              <input type="text" class="form-control" minlength="5" maxlength="50" id="nomProducto" name="nomProducto"
                     placeholder="Descripcion" required>
            </div>
            <div class="col-sm-2">
              <label class="visually-hidden" for="selCatProducto">CATEGORÍA</label>
              <select class="form-select" name="selCatProducto" id="selCatProducto">
                <option class="text-center" value="CATEGORIA">CATEGORÍA</option>
                <?php
                    if (isset($mostrarCategorias)){

                      foreach ($mostrarCategorias as $categoria){

                ?>

                        <option value="<?php echo $categoria->id_cat_aceite?>"><?php echo $categoria->nombre ?></option>

                <?php
                      }
                ?>

              </select>
            </div>
            <div class="col-sm-1">
              <label class="visually-hidden" for="recipienteProducto"></label>
              <input type="number" class="form-control" min="1" id="recipienteProducto" name="recipienteProducto" placeholder="Recipientes">
            </div>
            <div class="col-sm-1">
              <label class="visually-hidden" for="l/recipiente"></label>
              <input type="number" step="0.1" min="0.250" class="form-control" id="l/recipiente" name="l/recipiente" placeholder="litos/recipiente">
            </div>
            <label class="form-label" for="imgProducto"></label>
            <input type="file" class="form-control rounded" id="imgProducto" name="imgProducto" placeholder="Imagen del producto">
          </div>
          <div class="input-group mt-2 gap-2">
          <div class="col-sm-2">
            <label class="visually-hidden" for="descProducto"></label>
            <input type="number" class="form-control" id="descProducto" name="descProducto" placeholder="Dcto. Por defecto 0">
          </div>
            <button type="submit" class="btn btn-primary rounded" id="registroProducto">Registrar</button>
            <button type="reset" class="btn btn-warning rounded" id="resetFormProducto">Resetear</button>
            <div class="input-group mx-5 preciosAceite">
              <!-- En estos input mostramos los precios del AOVE y el AOV. Se podrán modificar en cualquier momento -->
              <span class="input-group-text" id="spanAove">Precio €/l AOVE:</span>
              <input type="text" class="form-control text-center" data-precio="<?php echo $mostrarCategorias[0]->precio ?>"
                     value="<?php echo $mostrarCategorias[0]->precio ?>" id="precioAove" name="precioAove" aria-describedby="spanAove">
              <span class="input-group-text" id="spanAov">Precio €/l AOV:</span>
              <input type="text" class="form-control text-center" data-precio="<?php echo $mostrarCategorias[1]->precio ?>"
                     value="<?php echo $mostrarCategorias[1]->precio ?>" id="precioAov" name="precioAov" aria-describedby="spanAov">
            </div>
            <button class="btn btn-success rounded mx-0" type="button" id="cambioPrecio">Modificar precios</button>
          </div>
        </form>
          <?php
              }
          ?>
      </div>
      <div class="muestraSeccion" id="mostrarTienda">

        <table class="table table-striped" id="tablaProductos">
          <thead>
          <tr>
            <th scope="col">Id.Producto</th>
            <th scope="col">Descripción</th>
            <th scope="col">Fecha inserción</th>
            <th scope="col">Descuento</th>
            <th scope="col">Categoría</th>
            <th scope="col">Recipiente</th>
            <th scope="col">Litros/Recipiente</th>
            <th scope="col">Imagen</th>
            <th scope="col">Modificar</th>
            <th scope="col">Eliminar</th>
          </tr>
          </thead>
          <tbody>
          <?php

              if (isset($mostrarProductos) && !empty($mostrarProductos)){

                  //Aquí guardamos el número de páginas que tendremos en la paginación, recogido del modelo a través del controlador
                  $paginasPaginacion = $mostrarProductos['paginas'];
                  //Eliminamos el valor de la paginación del array de los usuarios para no tener problemas al sacar datos
                  unset($mostrarProductos['paginas']);
                  foreach ($mostrarProductos as $valor){

                      foreach ($valor as $producto){

                          $extraerFecha = explode('-',$producto->fecha_inser) ;
                          $nuevaFechaAlta = $extraerFecha[2] . "/" . $extraerFecha[1] . "/" . $extraerFecha[0];

                          ?>
                        <tr>
                          <th><?php echo $producto->id_producto; ?></th>
                          <td contenteditable="true" title="Campo editable"><?php echo $producto->descripcion; ?></td>
                          <td><?php echo $nuevaFechaAlta; ?></td>
                          <td contenteditable="true" title="Campo editable"><?php echo $producto->dcto; ?></td>
                          <td><?php echo $producto->nombre; ?></td>
                          <td contenteditable="true" title="Campo editable"><?php echo $producto->recipiente; ?></td>
                          <td contenteditable="true" title="Campo editable"><?php echo $producto->litros_recipiente; ?></td>
                          <td><img class="imagenProductoTabla" src="<?php echo $producto->imagen; ?>" title="Pulse para modificar" width="80" height="80" alt="<?php echo $producto->descripcion; ?>"></td>
                          <td><i title="Pulse para modificar los datos introducidos" class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                          <td><i title="Pulse para eliminar el producto" class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                        </tr>

                          <?php
                      }
                  }

              }

          ?>
          </tbody>
        </table>

        <nav aria-label="Page navigation example" id="navPaginacionProductos">
          <ul title="Pulse para cambiar la página o actualizar" class="pagination justify-content-center">
              <?php

                  if (isset($paginasPaginacion)) {
                      for ($i = 1; $i <= $paginasPaginacion;$i++){
                          ?>

                        <li data-pagina="<?php echo $i ?>" class="page-item"><a class="page-link" href=""><?php echo $i ?></a></li>

                          <?php
                      }
                  }
              ?>
          </ul>
          <div class="text-center w-25 m-auto text-decoration-underline">
            <span id="muestraPaginaProductos"></span>
          </div>
        </nav>

        <button class="btn btn-info float-end me-3" id="renovarCantidadesAceite">Actualizar cantidades</button>
        <!-- Input para la muestra de los litros de aceite disponibles de cada tipo -->
        <div id="mostrarLitosDisponibles" class="form-group">
          <label for="litrosDisponiblesAove">Litros AOVE</label>
          <input type="text" class="form-control bg-white rounded" name="litrosDisponiblesAove" id="litrosDisponiblesAove"
                 <?php if (isset($mostrarLitros)){ ?>
                   value="<?php echo $mostrarLitros[0]->cantidad_litros ?>"
                 <?php } ?> readonly>
          <label class="mt-2" for="litrosDisponiblesAov">Litros AOV</label>
          <input type="text" class="form-control bg-white rounded" name="litrosDisponiblesAov" id="litrosDisponiblesAov"
              <?php if (isset($mostrarLitros)){?>
                value="<?php echo $mostrarLitros[1]->cantidad_litros ?>"
              <?php } ?> readonly>
        </div>

      </div>

    </article>

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// SECCIÓN SOBRE LAS VENTAS //////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <article id="seccionVentas" hidden>

      <h1 class="tituloSeccion">Ventas</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

    <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// SECCIÓN SOBRE LAS NOTICIAS //////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <article id="seccionNoticias" hidden>

      <h1 class="tituloSeccion">Noticias</h1>
      <div class="registroSeccion">Registro</div>
      <div class="muestraSeccion">Mostrar</div>

    </article>

  </section>

  <!-- Optional JavaScript! -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/7b55877beb.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script></script>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- Archivos javascript -->
  <script src="../js/principal.js"></script>
  <script src="../js/zonaAdmin.js"></script>
  <script src="../js/zonaAdminParcelas.js"></script>
  <script src="../js/zonaAdminProd.js"></script>
  <script src="../js/zonaAdminTienda.js"></script>
  </body>
</html>