<!-- ventana modal :: ! atencion ¡ las compras deben ser mayor a 20.000 pesos -->
 <div   class           ="modal  fade"
        id              ="mensaje_inactivo"
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
          <h5 id="contenido" >¡ REGISTRO INACTIVO EN NUESTRO SISTEMA !</h5>
       </div>

       <!-- body -->
       <div class="modal-body text-aligment">
          <div id="contenido">
                Su registro ha sido inhabilitado en nuestro sistema por falta de actividad.<br>
                <br>Comuníquese con servicio al cliente para más detalles sobre esta situación.
          </div>
       </div>

       <div class="modal-footer">
            <button type="button" class="btn btn-info cerrar_cumpleanios" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>

   	  </div>
   </div>
</div>
