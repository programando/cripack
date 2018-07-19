<div class=" row">
  <div class="col-xs-12 col-sm-12 col-md-12">






    <div class="form-group">
      <label class="col-md-4 control-label" for="idarea" >Área Empresa :</label>
      <div class="col-md-8">
        <select name="idarea" id="idarea" class="form-control select-md" >
          <option value=" <?= $this->idarea  ;?>"> <?= $this->nom_area  ;?></option>
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
        <input id="celular" name="celular" type="text" value=" <?= $this->celular  ;?>"
        placeholder="Número Celular" class="form-control input-md">
      </div><br><br>
    </div>

    <div class=" form-group">
      <label class="col-md-4 control-label" for="email">Correo electrónico :</label>
      <div class="col-md-8">
        <input id="email" name="email" type="email" value=" <?= $this->email  ;?>"
        placeholder="Correo electrónico" class="form-control input-md">
      </div><br><br>
    </div>
<!--
    <div class="form-group">
      <label class="col-md-4 control-label" for="email">Otra Información :</label>
      <div class="col-md-8">
        <div class="checkbox">

          <label for="cliente-existente" class="checkbox-inline">
              <?php if ( $this->cliente ) : ; ?>
                      <input type="checkbox" value="" id="cliente-existente" name="cliente-existente" checked="checked">
                 <?php else :?>
                    <input type="checkbox" value="" id="cliente-existente" name="cliente-existente">
              <?php endif;?>

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
          <label for="entrega-tarjeta" class="checkbox-inline ">
            <input type="checkbox" value="" id="entrega-tarjeta" name="entrega-tarjeta">
            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span><span class="entrega-tarj">NO</span>
          </label>
        </div>
      </div>
    </div>
  -->

  </div>
</div>
