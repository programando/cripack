
 <div   class           ="modal  fade"
        id              ="modal_eliminar"
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
          <h5 id="contenido" ><strong>¿ ELIMINAR REGISTRO ?</strong></h5>
       </div>

       <!-- body -->
       <div class="modal-body text-aligment">
          <div id="contenido">
                 Confirma que desea borrar el registro seleccionado ?
            <input type="hidden" class="form-control" id="idregistro" name="idregistro">
          </div>

       </div>

       <div class="modal-footer">
            <button type="button"  class="btn btn-danger" id="btn-eliminar"  data-dismiss="modal"  >Eliminar</button>
            <button type="button" class="btn btn-info " data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>

   	  </div>
   </div>
</div>
