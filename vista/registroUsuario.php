<div class="container" id="advanced-search-form">
  <i id="cierraRegistroUsuario" class="fa fa-times fa-2x float-right cierraRegistroUsuario" aria-hidden="true"></i>
  <h3>DATOS DE ENVÍO</h3>
  <p>¿Ya eres cliente?<span id="inicioDesdeRegistro"><u> Haz click aquí para acceder</u>.</span></p>
    <form id="formularioRegistroUsuarios">
      <div class="form-group">
        <label for="nombreReg" class="col-sm-2 col-form-label is-required"><b>NOMBRE</b></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="nombreReg" name="nombreReg">
        </div>
        <label for="apeReg" class="col-sm-2 col-form-label is-required"><b>APELLIDOS</b></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="apeReg" name="apeReg">
        </div>
        <label for="dniReg" class="col-sm-2 col-form-label is-required"><b>CIF/NIF/NIE</b>(opcional)</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="dniReg" name="dniReg" maxlength="9" placeholder="12345678L">
        </div>
        <label for="telReg" class="col-sm-2 col-form-label is-required"><b>TELÉFONO</b></label>
        <div class="col-sm-10">
          <input type="tel" class="form-control" min="60000000" max="999999999" id="telReg" name="telReg" placeholder="000112233">
        </div>
      </div>
      <div class="form-group">
        <label for="provReg" class="col-sm-2 col-form-label is-required"><b>PROVINCIA</b></label>
        <div class="col-sm-10">
          <select class="form-control" name="provReg" id="provReg">
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
        <label for="munReg" class="col-sm-2 col-form-label is-required"><b>MUNICIPIO</b></label>
        <div class="col-sm-10">
          <select class="form-control" name="munReg" id="munReg">

            <option class="text-center" value="MUNICIPIO">MUNICIPIO</option>

          </select>
        </div>
        <label for="dirReg" class="col-sm-2 col-form-label is-required"><b>DIRECCIÓN</b></label>
        <div class="col-sm-10">
          <select class="form-control" name="dirReg" id="dirReg">

            <option class="text-center" value="DIR">DIRECCIÓN</option>

          </select>
        </div>
        <label for="cpReg" class="col-sm-8 col-form-label is-required"><b>CÓDIGO POSTAL</b></label>
        <div class="col-sm-10">
          <select class="form-control" name="cpReg" id="cpReg">

            <option class="text-center" value="C.POSTAL">COD. POSTAL</option>

          </select>
        </div>
      </div>
      <div class="form-group mb-0">
        <label for="numCasaReg" class="col-sm-8 col-form-label is-required"><b>NÚMERO CASA</b></label>
        <div class="col-sm-10">
          <input type="number" min="1" max="999" class="form-control" id="numCasaReg" name="numCasaReg" required>
        </div>
        <label for="pisoReg" class="col-sm-2 col-form-label"><b>PISO</b></label>
        <div class="col-sm-10">
          <input type="number" min="0" max="99" class="form-control" id="pisoReg" name="pisoReg">
        </div>
        <label for="puertaReg" class="col-sm-2 col-form-label"><b>PUERTA</b></label>
        <div class="col-sm-10">
          <input type="text" class="form-control" minlength="1" maxlength="10" id="puertaReg" name="puertaReg">
        </div>
      </div>
      <div class="form-group">
        <label for="emailReg" class="col-sm-2 col-form-label is-required"><b>EMAIL</b></label>
        <div class="col-sm-10">
          <input type="email" class="form-control" id="emailReg" name="emailReg" placeholder="correo@yopmail.org">
        </div>
      </div>
      <h2></h2>
      <div class="container" id="apartadoRegCLiente">
        <div class="row col-lg-12">
          <div class="form-group">
            <label for="passReg" class="col-sm-6 col-form-label is-required"><b>CONTRASEÑA</b></label>
            <div class="col-sm-12">
              <input type="password" class="form-control" id="passReg" name="passReg" placeholder="min.4-max-10">
            </div>
          </div>
          <div class="form-group">
            <label for="passReg2" class="col-sm-6 col-form-label is-required"><b>REPITA CONTRASEÑA</b></label>
            <div class="col-sm-12">
              <input type="password" class="form-control" id="passReg2" name="passReg2" placeholder="min.4-max-10">
            </div>
          </div>
          <div class="form-group">
            <label for="emReg" class="col-sm-6 col-form-label is-required"><b>EMPRESA</b>(opcional)</label>
            <div class="col-sm-12">
              <input type="text" class="form-control" id="emReg" name="emReg">
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
          <div class="form-check col-lg-10">
            <label class="form-check-label" for="permitirReg">¿Crear cuenta?</label>
            <input class="form-check-input ml-3 mt-1" type="checkbox" name="permitirReg" id="permitirReg">
          </div>
      </div>
      <div class="container">
        <div class="row col-lg-10 m-auto">
          <button type="submit" class="btn btn-info col-lg-5" id="btnRegistroUsuario">Guardar datos de envío</button>
          <button type="reset" class="btn btn-warning col-lg-5" id="btnResetUsuario">Limpiar datos</button>
        </div>
      </div>
      <p>(Si habilita <u>crear cuenta</u> será registrado en el sistema para agilizar los trámites sino,
        solo se utilizarán los datos para el envío)</p>
    </form>
</div>