<div class="container">
	<div  class="row align-items-center" style="height: 90vh;">
	    <div class="col-6">
	        <img class="img-fluid" src="http://intelisis-solutions.com/logo_intelisis.jpg" alt="intelisis" style="width: 75%;">
	    </div>
	    <div class="col-6">
	    	<div class="row">
		  		<div class="col">
	    			<button class="shadow-box-example z-depth-2 flex-center " id="concita">
            			<p class="white-text">CON CITA</p>&nbsp;&nbsp;
            			<i class="fa fa-clock-o" aria-hidden="true" style="color:white; font-size: 50px;"></i>
            		</button>
	    		</div>
	    		<div class="w-100"></div>
	    		<br><br>
	    		<div class="col">
	        		<button class="shadow-box-example z-depth-2 flex-center" id="sincita">
            			<p class="white-text">SIN CITA</p>&nbsp;&nbsp;
            			<i class="fa fa-car" aria-hidden="true" style="color:white; font-size: 50px;"></i>
            		</button>	
	    		</div>
			</div>
	    </div>
	</div>
</div>

<script>
	$( document ).ready(function() {
    	$("#concita").on("click", function(e){
			e.preventDefault();
			$(location).attr('href', base_url + 'index.php/tablero_asesor');

		});
		$("#sincita").on("click", function(e){
			e.preventDefault();
			$(location).attr('href', base_url + 'index.php/buscador');
			
		});
	});
</script>