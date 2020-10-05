<!-- Start your project here-->
<div style="height: 100vh">
    <div class="flex-center flex-column">
        <!--Card-->
        <div class="card mx-xl-5">
            <!--Card content-->
            <div class="card-body">
                <div class="form-header dark-primary-color rounded header-login">
                    <img src="<?=base_url()?>assets/img/garage.ico" alt="icono auto servicio"> <h3>Recepción</h3>
                </div>
                <!-- Default form login -->
                    <form role="form" action="<?= site_url()?>/user/login" method="post" id="form_login" class="form-actions"> 
                        <p class="h4 text-center mb-4">Iniciar sesión</p>
                        <!-- Material input email -->
                        <div class="md-form">
                            <i class="fa fa-envelope prefix grey-text"></i>
                            <input type="email" name="email" class="form-control">
                            <label for="email">Email</label>
                        </div>
                        <!-- Material input password -->
                        <div class="md-form">
                            <i class="fa fa-lock prefix grey-text"></i>
                            <input type="password" name="password" class="form-control">
                            <label for="password">Contraseña</label>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-primary" type="submit">Ingresar</button>
                        </div>
                    </form>
                <!-- Default form login -->
            </div>
        </div>               
    </div>
</div>