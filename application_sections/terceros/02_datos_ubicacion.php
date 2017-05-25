<div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">

       <div class="form-group">
        <label class="col-md-3 control-label" for="direccion">Dirección :</label>
        <div class="col-md-9">
         <input id="direccion" name="direccion" type="text" placeholder="Dirección" class="form-control input-md" required="">
        </div>
        <br><br>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="telefono">Teléfono : </label>
        <div class="col-md-9">
         <input id="telefono" name="telefono" type="text" placeholder="Números Teléfono" class="form-control input-md" required="">
        </div>
        <br><br>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="idmcipio" >Pais :</label>
        <div class="col-md-9">
         <select name="idpais" id="idpais" class="form-control select-md" >
            <option value="7">COLOMBIA</option>
            <?php foreach ( $this->Paises as $Pais ) :;?>
                  <option value="<?= $Pais['idpais'] ;?>"><?= $Pais['nompais'] ;?></option>
            <?php endforeach ;?>
         </select>

        </div>
        <br><br>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="idmcipio" >Ciudad :</label>
        <div class="col-md-9">
         <select name="idmcipio" id="idmcipio" class="form-control select-md" >
            <option value="0">SELECCIONE ....</option>
            <?php foreach ( $this->Municipios as $Municipio ) :;?>
                  <option value="<?= $Municipio['idmcipio'] ;?>"><?= $Municipio['nommcipio'] ;?></option>
            <?php endforeach ;?>
         </select>

        </div>
        <br><br>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="idzona_ventas" >Zona Ventas :</label>
        <div class="col-md-9">
         <select name="idzona_ventas" id="idzona_ventas" class="form-control select-md" >
            <option value="0">SELECCIONE ....</option>
            <?php foreach ( $this->Zona_Ventas as $Zona_Venta ) :;?>
                  <option value="<?= $Zona_Venta['idzona_ventas'] ;?>"><?= $Zona_Venta['nombre_zona_ventas'] ;?></option>
            <?php endforeach ;?>
         </select>

        </div>
        <br><br>
       </div>

      </div>
     </div>
