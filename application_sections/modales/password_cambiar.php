<!-- ventana modal :: ! atencion ¡ las compras deben ser mayor a 20.000 pesos -->
 <div   class           ="modal  fade"
        id              ="modal_cambio_password"
        tabindex        ="-1" role="dialog"
        aria-labelledby ="ver_modalLabel"
        aria-hidden     ="true"
        data-backdrop   ="static"
        data-keyboard   ="false"
        >
        <div class="modal-dialog">
          <div class="modal-content">
           <!-- header -->
           <div class="modal-header text-center">
             <!-- Boton de cierre en el lado derecho      -->
             <!--  <button type="button"  class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span> </button> -->
             <h5 id="contenido" > <strong> CAMBIAR CONTRASEÑA </strong></h5>
           </div>

           <!-- body -->
           <div class="modal-body text-aligment">
            <div class="form-group"><!--Input Email -->
              <div>
               Ingrese el e-mail que utilizó en el momento del registro, una vez validado, enviaremos un correo
               electrónico en donde se indicará el procedimiento para cambiar la contraseña.
               <br>
               <br>
                <br>
             </div>
             <label for="correo">E-mail Registrado...</label>
             <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-user"></i><!-- IMG QUE SE ENCUENTRA EN LA DERECHA DE INPUT-->
              </span><!--INPUT = DIRECCION DE CORREO -->
              <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="Usuario" />
            </div>
            <div id="msgbox">
            </div>
          </div><!--Input Email -->

          <div class="text-center" id="dv-img-cargando"  >
            <img id="imagen-cargando" src= "<?= BASE_IMAGES ;?>cargando.gif" alt="" />
            <br>
          </div><br/>

        </div>

        <div class="modal-footer">
           <div class   ="cont-btn-enviar">
           <button type ="button" class="btn btn-success btn-enviar" id='btn-recupera-pass'>Enviar</button><!--Boton Enviar -->
           <button type ="button" class="btn btn-info    btn-cerrar" data-dismiss="modal" >Cerrar</button>
      </div>

        </div>

      </div>
    </div>
  </div>
