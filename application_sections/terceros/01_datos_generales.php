<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">

    <div class=" form-group">
      <label class="col-md-4 control-label" for="identificacion">Identificación :</label>
      <div class="col-md-8">
        <input id="identificacion_feria" name="identificacion_feria" type="text" placeholder="Número Identificación" class="form-control input-md">
      </div><br><br>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" for="idtpdoc" >Tipo Documento :</label>
      <div class="col-md-8">
        <select name="idtpdoc" id="idtpdoc" class="form-control select-md" >
          <option value="0">SELECCIONE ....</option>
          <?php foreach ( $this->Tipos_Doc as $Tipo_Doc ) :;?>
            <option value="<?= $Tipo_Doc['idtpdoc'] ;?>"><?= $Tipo_Doc['nomtpdoc'] ;?></option>
          <?php endforeach ;?>
        </select>
      </div><br><br>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" for="nomtercero">Nombre/Razón Social :</label>
      <div class="col-md-8">
        <input id="nomtercero" name="nomtercero" type="text" placeholder="Nombre/Razón Social" class="form-control input-md">
      </div><br><br>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" > </label>
      <div class="col-md-8">

        <div class="checkbox">
          <label for="cliente" class="checkbox-inline">
            <input type="checkbox" value="" id="cliente" name="cliente">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
             Cliente
          </label>

          <label for="proveedor" class="checkbox-inline">
            <input type="checkbox" value="" id="proveedor" name="proveedor">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            Proveedor
          </label>
        </div>



      </div><br><br>
    </div>

  </div>
</div>
