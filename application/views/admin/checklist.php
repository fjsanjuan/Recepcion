<section>
	<div class="container-fluid">
				<div class="row">
			<label for="" class="form-control">Nombre del Formulario</label>
			<input type="text">
		</div>
	</div>
</section>
<section class="card card-cascade narrower mb-5">
	<div class="container-fluid">
		<!--Grid row-->
	    <div class="row">
			<!--Grid column-->
			<div class="card card-cascade narrower">
                    <!--Card header-->
                    <div class="view view-cascade py-3 gradient-card-header info-color-dark mx-4 d-flex justify-content-between align-items-center">
                        <a href="" class="white-text mx-3">Checklist</a>
                    </div>
                    <!--/Card header-->
                    <!--Card content-->
                    <div class="card-body card-body-cascade">
						<div>
							<button type="button" class="btn btn-outline-primary waves-effect btn-sm" id="add_input">Input <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-outline-primary waves-effect btn-sm" id="add_textarea">Textarea <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-outline-primary waves-effect btn-sm" id="add_checkbox">Checkbox <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-outline-primary waves-effect btn-sm" id="add_radio">Radio buttons <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
						</div>
                        <hr class="my-0">
						<br>
						<!-- checkbox -->
                        <div id="manycontrol">
                        	<div class="col">
                        		<label for="">Pregunta</label>
                        		<input type="text" class="form-control form-control-sm" id="preguntachecks">
                        	</div>
                        	<div class="col">
                        		<label for="">Cuantas opciones</label>
								<input type="number" class="form-control form-control-sm" id="manychecks">
                        	</div>
                        	<div class="col">
                        		<input type="button" class="btn btn-primary" value="Agregar" id="btnSave_check" />
                        	</div>
                        </div>
                        <!-- para  input label -->
                        <div id="inputcontrol">
                        	<div class="col">
                        		<label for="">Pregunta</label>
                        		<input type="text" class="form-control form-control-sm" id="preguntainput">
                        	</div>
                        	<div class="col">
                        		<input type="button" class="btn btn-primary" value="Agregar" id="btnSave_input" />
                        	</div>
                        </div>
                        <!-- para textarea -->
                        <div id="textareacontrol">
                        	<div class="col">
                        		<label for="">Pregunta</label>
                     			<input type="text" class="form-control form-control-sm" id="preguntatext">
                        	</div>
                        	<div class="col">
                        		<input type="button" class="btn btn-primary" value="Agregar" id="btnSave_textarea" />
                        	</div>
                        </div>
                        <!-- para radio buttons -->
                        <div id="radiocontrol">
                        	<div class="col">
                        		<label for="">Pregunta</label>
                        		<input type="text" class="form-control form-control-sm" id="preguntaradio">
                        	</div>

                        	<div class="col">
                        		<label for="">Cuantas Opciones</label>
                        		<input type="number">
                        	</div>
                        	<div class="col">
                        		<input type="button" class="btn btn-primary" value="Agregar" id="btnSave_radio" />
                        	</div>
                        </div>
                    </div>
                <!--/.Card content-->
            </div>
            <div class="col-md-6">
            	            <div class="card card-cascade narrower">
            	<div class="view view-cascade py-3 gradient-card-header info-color-dark mx-4 d-flex justify-content-between align-items-center">
                    <a href="" class="white-text mx-3">Vista Previa</a>
                </div>
                <!--Card content-->
                <div class="card-body card-body-cascade">
                		<div id="elements" class="form-inline">
                		</div>
                </div>
            </div>
			</div>

	 	</div>
	</div>
</section>
<section>
	<button>GUARDAR</button>
</section>