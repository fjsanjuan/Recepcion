<!-- modal busqueda ordenes -->
<div class="modal fade" id="modalBuscOrdenes" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Back Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="" class="grey-text">Folio</label>
                                    <input class="form-control form-control-sm" id="busc_folio" readonly="true" type="text">
                                </div>
                                <div class="col">  
                                    <label for="" class="grey-text">Cliente</label>
                                    <input class="form-control form-control-sm" id="busc_cliente" readonly="true" type="text">
                                </div>
                            </div>
                        </div>
                       <!-- <div class="row">
                            <div class="col-md-7">
                                 <input class="form-control" type="text" id="busquedapaq" onkeyup="mySearch2()" placeholder="Buscar por Descripcion">
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-7">
                            <h5>Ordenes</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover animated fadeIn" id="table_ord">
                                        <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                            <tr>
                                                <th>ID</th>
                                                <th>Referencia</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-5" style="display: none;" id="mostrar_detalles">
                                <h5>Detalles</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover animated fadeIn" id="table_detalles">
                                        <thead class="mdb-color primary-color" style="font-weight: bold; color:#fff;">
                                            <tr>
                                                <th>Articulo</th>
                                                <th>Descripcion</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="precio_paq" class="grey-text">Precio</label> 
                                    <input type="text" class="form-control form-control-sm" name="precio_paq" id="preciopaquete" readonly="true">
                                    <label for="tipo_precio" class="grey-text">Tipo</label>
                                    <input type="text" class="form-control form-control-sm" name="tipo_precio" id="tipodepreciopaquete" readonly="true">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Seleccionar</button> -->
            </div>
        </div>
    </div>
</div>