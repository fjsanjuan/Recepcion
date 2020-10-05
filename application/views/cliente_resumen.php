<!-- hidden-->
<input type="hidden" name="tipo_c" id="tipo_c" value="<?=$tipo?>">
<input type="hidden" name="id_c" id="id_c" value="<?=$id?>">

<div class="container">
     <div class="row" style="padding-top: 25px;">
        <div class="col">
            <blockquote class="blockquote bq-primary htext">Cliente</blockquote>
        </div>
    </div>
    <div class="row">
        <div class="col mcenter">    
            <img class="animated fadeIn" src="<?=base_url()?>assets/img/logo.png" alt="Intelisis">
        </div>    
    </div>
    <!-- Start your project here-->
    <div  class="row align-items-center" style="height: 65vh;">
     <!--Panel-->
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Actualizar datos</h3>
                    <p class="card-text">Si desea actualizar los datos del cliente haga clic en actualizar.</p>
                    <button class="btn btn-primary" id="proceder_update">Actualizar</button>
                </div>
            </div>
        </div>
        <!--/.Panel-->
        <!--Panel-->
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Proceder con la Cita</h3>
                    <p class="card-text">Si no desea actualizar los datos en este momento favor de proceder.</p>
                    <button style="float:right;" class="btn btn-primary" id="proceder_c">Proceder</button>
                </div>
            </div>
        </div>
        <!--/.Panel-->
    </div>
</div>

