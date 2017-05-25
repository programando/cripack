<div class=" row">
  <div class="col-xs-12 col-sm-12 col-md-12">

    <div class=" form-group">
      <label class="col-md-4 control-label" for="contacto">Contacto :</label>
      <div class="col-md-8">
        <input id="contacto" name="contacto" type="text" placeholder="Nombre Contacto" class="form-control input-md">
      </div><br><br>
    </div>


    <div class="form-group">
      <label class="col-md-4 control-label" for="idcargo_externo" >Cargo :</label>
      <div class="col-md-8">
        <select name="idcargo_externo" id="idcargo_externo" class="form-control select-md" >
          <option value="0">SELECCIONE ....</option>
          <?php foreach ( $this->Cargos as $Cargo ) :;?>
            <option value="<?= $Cargo['idcargo_externo'] ;?>"><?= $Cargo['nom_cargo'] ;?></option>
          <?php endforeach ;?>
        </select>
      </div>
      <br><br>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" for="idarea" >Área Empresa :</label>
      <div class="col-md-8">
        <select name="idarea" id="idarea" class="form-control select-md" >
          <option value="0">SELECCIONE ....</option>
          <?php foreach ( $this->AreasEmpresa as $AreaEmpresa ) :;?>
            <option value="<?= $AreaEmpresa['idarea'] ;?>"><?= $AreaEmpresa['nom_area'] ;?></option>
          <?php endforeach ;?>
        </select>
      </div>
      <br><br>
    </div>

    <div class=" form-group">
      <label class="col-md-4 control-label" for="celular">Nro Celular :</label>
      <div class="col-md-8">
        <input id="celular" name="celular" type="text" placeholder="Nombre Contacto" class="form-control input-md">
      </div><br><br>
    </div>

    <div class=" form-group">
      <label class="col-md-4 control-label" for="email">Correo electrónico :</label>
      <div class="col-md-8">
        <input id="email" name="email" type="email" placeholder="Correo electrónico" class="form-control input-md">
      </div><br><br>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" for="email">Otra Información :</label>
      <div class="col-md-8">
        <div class="checkbox">

          <label for="cliente-existente" class="checkbox-inline">
            <input type="checkbox" value="" id="cliente-existente" name="cliente-existente">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            CE
          </label>

          <label for="posible-cliente" class="checkbox-inline">
            <input type="checkbox" value="" id="posible-cliente" name="posible-cliente">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            CP
          </label>
          <label for="informacion" class="checkbox-inline">
            <input type="checkbox" value="" id="informacion" name="informacion">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            IN
          </label>

          <label for="competencia" class="checkbox-inline">
            <input type="checkbox" value="" id="competencia" name="competencia">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            CO
          </label>

        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" for="email">Entrega Tarjeta :</label>
      <div class="col-md-8">
        <div class="checkbox">
          <label for="entrega-tarjeta" class="checkbox-inline">
            <input type="checkbox" value="" id="entrega-tarjeta" name="entrega-tarjeta">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>

          </label>
        </div>
      </div>
    </div>


  </div>
</div>
