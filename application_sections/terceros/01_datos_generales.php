
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">



    <div class="form-group">
      <label class="col-md-4 control-label" for="idtpdoc" >Tipo Documento :</label>
      <div class="col-md-8">
        <select name="idtpdoc" id="idtpdoc" class="form-control select-md" >
          <option value="<?= $this->idtpdoc ;?>"><?= $this->nomtpdoc ;?> </option>
          <?php foreach ( $this->Tipos_Doc as $Tipo_Doc ) :;?>
            <option value="<?= $Tipo_Doc['idtpdoc'] ;?>"><?= $Tipo_Doc['nomtpdoc'] ;?></option>
          <?php endforeach ;?>
        </select>
      </div><br><br>
    </div>

    <div class=" form-group">
      <label class="col-md-4 control-label" for="identificacion">Identificación :</label>
      <div class="col-md-8">
        <input id="identificacion_feria" name="identificacion_feria" type="text" value ="<?= $this->identificacion; ?>"
            placeholder="Número Identificación" class="form-control input-md">
      </div><br><br>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" for="nomtercero">Nombre/Razón Social :</label>
      <div class="col-md-8">
        <input id="nomtercero" name="nomtercero" type="text"
              placeholder="Nombre/Razón Social"  value=" <?= $this->nomtercero  ;?>"
              class="form-control input-md">
      </div><br><br>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label" for="nomtercero">Quién nos visita ? :</label>
      <div class="col-md-8">
        <input id="persona-visita" name="persona-visita" type="text" placeholder="Persona que nos visita" class="form-control input-md">
      </div><br><br>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label" > </label>
      <div class="col-md-8">

        <div class="checkbox">
          <label for="cliente" class="checkbox-inline">
            <?php if ( $this->cliente == TRUE ) :?>
              <input type="checkbox" value="" id="cliente" name="cliente" checked="ckecked">
            <?php else :?>
              <input type="checkbox" value="" id="cliente" name="cliente">
            <?php endif ;?>
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
             Cliente

          </label>

          <label for="proveedor" class="checkbox-inline">
             <?php if ( $this->proveedor == TRUE ) :?>
                   <input type="checkbox" value="" id="proveedor" name="proveedor" checked="ckecked">
              <?php else :?>
                  <input type="checkbox" value="" id="proveedor" name="proveedor">
             <?php endif ;?>
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            Proveedor
          </label>

          <label for="otro" class="checkbox-inline">
            <input type="checkbox" value="" id="otro" name="otro">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
            Otro
          </label>

        </div>



      </div><br><br>
    </div>

  </div>
</div>
