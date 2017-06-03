<!-- ventana modal :: ! atencion ¡ las compras deben ser mayor a 20.000 pesos -->
 <div   class           ="modal  fade"
        id              ="modal_areas_interes"
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
          <h5 id="contenido" >CLIENTE INTERESADO EN </h5>

       </div>

       <!-- body -->
       <div class="modal-body text-aligment">
          <div id="contenido">

                <?php
                    Debug::Mostrar( Session::Get('MyVar') . idtercero );
                    ?>

                <input type="text" class="form-control" id="idtercero" name="idtercero" value=" <?= Session::Get('MyVar')  ;?>">
          </div>
       </div>

       <div class="modal-footer">
            <button type="button" class="btn btn-info cerrar_cumpleanios" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>

   	  </div>
   </div>
</div>
