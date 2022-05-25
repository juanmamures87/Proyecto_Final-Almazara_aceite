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
                            <td contenteditable="true"><?php echo $socio->telefono; ?></td>
                            <td contenteditable="true"><?php echo $socio->provincia; ?></td>
                            <td contenteditable="true"><?php echo $socio->municipio; ?></td>
                            <td contenteditable="true"><?php echo $socio->direccion; ?></td>
                            <td contenteditable="true"><?php echo $socio->cp; ?></td>
                            <td contenteditable="true"><?php echo $socio->num_casa; ?></td>
                            <td contenteditable="true"><?php echo $socio->piso; ?></td>
                            <td contenteditable="true"><?php echo $socio->puerta; ?></td>
                            <td contenteditable="true"><?php echo $socio->email; ?></td>
                            <td><?php $socio->activo == 1 ?
                                    $activado = "Activo <br> <input type='checkbox' class='accesoTabla' checked>" : $activado = "Desactivado <br> <input type='checkbox' class='accesoTabla'>"; echo $activado;?></td>
                            <td contenteditable="true"><?php echo $socio->tipo_socio; ?></td>
                            <td><?php echo $nuevaFechaAlta; ?></td>
                            <td contenteditable="true"><?php echo $socio->fecha_baja; ?></td>
                            <td><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>
                            <td><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>
                          </tr>

            <?php
                        }
                    }

                }

            ?>
          </tbody>
        </table>

        <nav aria-label="Page navigation example" id="navPaginacionSocios">
          <ul class="pagination justify-content-center">
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
            <ul class="pagination justify-content-center"></ul>
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
            <input type="number" class="form-control" min="50" id="kgProd" name="kgProd" placeholder="Kilogramos">
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="renProd">Rendimiento</label>
            <input type="number" class="form-control" min="18" max="25" id="renProd" name="renProd" placeholder="Rendimiento">
          </div>
          <div class="col-sm-2">
            <label class="visually-hidden" for="acidezProd">Acidez</label>
            <input type="number" step="0.1" min="0" max="2" class="form-control" id="acidezProd" name="acidezProd" placeholder="Acidez">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary mx-3" id="registroProd">Registrar</button>
            <button type="reset" class="btn btn-warning mx-2" id="resetFormProd">Resetear</button>
          </div>
        </form>

      </div>

      <!------------------------------ Apartado de muestra de datos de la producción ------------------------------>
      <div class="muestraSeccion" id="mostrarProduccion">

        <!------------------- Apartado de muestra del ticket de remesa de producción para imprimirlo --------------->
        <div id="apartadoTicket" >

            <?php ob_start(); ?>
          <div id="ticketRemesaProd">

            <div id="datosAlmazara">
              <h6 class="text-center">DATOS DE LA ALMAZARA</h6>
              <hr class="w-75 m-auto">
    <pre class="mt-2">
    Nombre o razón social:    Molino del Sur.
    Domicilio:                Calle Real 6, Mures, Jaén. 23686.
    NIF:                      26344720A
    </pre>
            </div>
            <div id="datosAgricultor">
              <h6 class="text-center">DATOS DEL OLEICULTOR</h6>
              <hr class="w-75 m-auto">
    <pre class="mt-2">
    Nombre o razón social:    <span id="ticketNombreOleicultor"></span>
    Domicilio:                <span id="ticketDomicilioOleicultor"></span>
    Municipio:                <span id="ticketMunOleicultor"></span>, Provincia:                <span id="ticketProvOleicultor"></span>
    NIF:                      <span id="ticketNifOleicultor"></span>
    </pre>
            </div>
            <div id="remesaProducto">
              <table class="table table-striped">
                <thead>
                  <th>Parcela</th>
                  <th>Kg.Aceituna</th>
                  <th>Litros aceite</th>
                  <th>Rendimiento</th>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div id="firmasFecha">
   <pre class="mt-2">
    Certifico que los datos contenidos en este documento son conformes
    con la realidad.
    En MURES, a <span id="ticketDiaFirma"></span> de <span id="ticketMesFirma"></span> de <span id="ticketYearFirma"></span>.
    Firmado:

    NIF: 26044720A
    <img id="imagenTicket" alt="Molino del Sur" src='data:image/png;base64,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'/>
    </pre>
            </div>

          </div>
          <?php
            $html = ob_get_clean();
            echo $html;
          ?>
          <div id="botonesImprimirCancelar" class="d-flex flex-column">
            <form action="index.php">
              <button class="btn btn-success mx-5 mb-5">Imprimir</button>
              <input type="hidden" name="controlador" value="imprimir">
              <input type="hidden" name="ticket" value="<?php $_SESSION['ticket'] = $html ?>">
            </form>
            <button id="cancelarImpresion" class="btn btn-secondary  mx-5">Cancelar</button>
          </div>
        </div>
      </div>

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
  <script src="../js/principal.js"></script>
  <script src="../js/zonaAdmin.js"></script>
  <script src="../js/zonaAdminProd.js"></script>
  <script src="../js/zonaAdminParcelas.js"></script>
  </body>
</html>