<style>



</style>
<div class="col-xs-12 col-sm-12 col-md-12">

  <div class="form-group">
    <label class="col-md-3 control-label" for="sector">Sector :</label>
    <div class="col-md-9">
      <input id="sector" name="sector" type="text" placeholder="Sector" class="form-control input-md" required="">
    </div>
    <br><br>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="tipo_producto">Área Interés : </label>
    <div class="col-md-9">

      <select  name="idestilotrabajo[]" id="idestilotrabajo" class="form-control select-md selectpicker" multiple>
        <option value="0">SELECCIONE ....</option>
        <?php foreach ( $this->Estilos as $Estilo ) :;?>
          <option value="<?= $Estilo['idestilotrabajo'] ;?>"><?= $Estilo['texto_equiv_web'] ;?></option>
        <?php endforeach ;?>
      </select>

    </div>
    <br><br>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="observacion" >Observaciones :</label>
    <div class="col-md-9">
      <textarea class="form-control" rows="5" id="observacion" name="observacion"></textarea>

    </div>
    <br><br>
  </div>

    <div class="form-group">
       <label class="col-md-3 control-label" for="observacion" >Contactar por :</label>
         <div class="col-md-9">
            <label class="radio-inline">  <input type="radio"   name="optradio"> Correo          </label>
            <label class="radio-inline">  <input type="radio" name="optradio">Teléfono           </label>
            <label class="radio-inline">  <input type="radio" name="optradio">Visita Comercial   </label>
            <label class="radio-inline">  <input type="radio" name="optradio">Cualquiera         </label>
        </div>
    </div>




  <br>

  <div class="form-group">
    <label class="col-md-3 control-label" for="atendido-por">Atendido por :</label>
    <div class="col-md-9">
        <select  name="atendido-por" id="atendido-por" class="form-control select-md" >
        <option value="0">SELECCIONE ....</option>
        <?php foreach ( $this->Asistentes_Ferias as $Asistente ) :;?>
          <option value="<?= $Asistente['idtercero'] ;?>"><?= $Asistente['nomtercero'] ;?></option>
        <?php endforeach ;?>
      </select>
    </div>

  </div>

</div>
