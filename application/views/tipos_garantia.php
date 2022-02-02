<!-- datatables -->
<link rel="stylesheet" href="<?=base_url()?>assets/librerias/datatablescrm/media/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.tosrus.all.css">
<script src="<?=base_url();?>assets/librerias/datatablescrm/media/js/jquery.dataTables.min.js"></script>
<!-- html2canvas -->
<script src="<?=base_url()?>assets/librerias/html2canvas/html2canvas.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery.tosrus.all.min.js"></script>
<!-- jspdf -->
<script src="<?=base_url()?>assets/librerias/jspdf/jspdf.debug.js"></script>
<style>
    .checkA, .check{
        left: 0 !important;
        visibility: inherit !important;
        position: relative !important;
        margin-left: 15px;
    }
    label.pres_autorizado{
        background-color: #00c851!important;
        color: #fff;
        padding-right: 10px;
        border-radius: 10px;
        margin-left: 10px;
    }
    label.no_autorizado{
        background-color: #ec8585!important;
        color: #fff;
        padding-right: 10px;
        border-radius: 10px;
        margin-left: 10px;
    }

    a[href="<?=site_url('buscador/ver_historico')?>"]{
        display: none;
    }

    .flatpickr-clear {
        font-size: 100%;
        font-weight: bold;
        cursor: pointer;
        background: #fff;
    }
    button.whatsapp_pres{
        background-color: #79c143;
    }
    .comentario_fotos{
       line-height: normal !important;
        display: block;
        margin-top: 3px !important;
        width: 100%;
        text-align: justify;
        white-space: normal;
    }
    #modalbusqarts{
        overflow:scroll;
    }
    #exampleModal td{
        vertical-align: middle;
    }
    #cpModal td{
        vertical-align: middle;
    }
	#modalBuscArt{
        overflow:scroll;
    }
	#modalValidacion td{
        vertical-align: middle;
    }
    .selected {
    background-color: #c4c0c0;
  
}
table tr.active {
    background: #ccc;
    }
.table tbody tr.highlight td {
    background-color: #CFF5FF;
}
.modal {
    overflow-y: auto !important;
}
</style>
<div class="container">
    <br>
    <div class="row">
        <div class="col-sm-12">
            <blockquote class="blockquote bq-primary htext">
                <b>ADMINISTRAR TIPOS DE GARANTÍAS</b>
            </blockquote>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <h6><b>Seleccione, por favor, un rango de fechas:</b></h6>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-1 icono_calendario">
            <i class="fa fa-calendar-alt"></i>
        </div>
        <div class="col-sm-4">
        <input placeholder="Fecha Inicio" value="<?php echo date("Y-m").'-1';?>" type="text" id="fecha_comienza" class="form-control datepicker input_fecha" >
        </div>
        <div class="col-sm-1 icono_calendario">
            <i class="fa fa-calendar-alt"></i>
        </div>
        <div class="col-sm-4">
        <input placeholder="Fecha Fin" value="<?php echo date("Y-m-t", strtotime(date("Y-m-d")));?>" type="text" id="fecha_termina" class="form-control datepicker input_fecha">
        </div>
        <div class="col-sm-2">
            <button type="button" id="btn_mostrarTipos" class="btn btn-success btn-sm float-right">Ver Garantías</button>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <table class="table table-bordered table-striped table-hover animated fadeIn tabla_hist" id="tabla_tipoGtia">
                <thead class="mdb-color primary-color">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre</th> 
                        <th>Descripción</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Actualización</th>
                        <th>Acciones</th>
						<th>Eliminado</th>
                        <th>Fecha Eliminación</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <br>
</div>