
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
    <div class=" form-group">
      <label class="col-md-4 control-label" for="contacto">Contacto :</label>
      <div class="col-md-8">
        <input id="contacto" name="contacto" type="text" value=" <?= $this->contacto  ;?>"
          placeholder="Nombre Contacto" class="form-control input-md">
      </div><br><br>
    </div>

        <div class="form-group">
      <label class="col-md-4 control-label" for="idcargo_externo" >Cargo :</label>
      <div class="col-md-8">
        <select name="idcargo_externo" id="idcargo_externo" class="form-control select-md" >
          <option value=" <?= $this->idcargo_externo  ;?>"> <?= $this->nom_cargo  ;?></option>
          <?php foreach ( $this->Cargos as $Cargo ) :;?>
            <option value="<?= $Cargo['idcargo_externo'] ;?>"><?= $Cargo['nom_cargo'] ;?></option>
          <?php endforeach ;?>
        </select>
      </div>
      <br><br>
    </div>


  </div>
</div>
