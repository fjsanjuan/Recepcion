<div class="row">
    <!-- Start your project here-->
    <div style="padding: 10px;">
        <div class="flex-center flex-column">
            <!--Card-->
            <div class="card mx-xl-5">
                <!--Card content-->
                <div class="card-body">
                    <div class="form-header dark-primary-color rounded">
                        <h3><i class="fa fa-user-plus"></i> Registro Nuevo Usuario</h3>
                    </div>
                    <!--    Default form login -->
                        <form role="form" action="<?= base_url()?>user/create" method="post" id="form_create_usr" class="form-actions"> 
                            <!-- Material input email -->
                            <div class="md-form">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <input type="text" name="nombre_usr" class="form-control">
                                <label for="nombre_usr">Nombre</label>
                            </div>
                            <div class="md-form">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <input type="text" name="apellido_usr" class="form-control">
                                <label for="apellido_usr">Apellido</label>
                            </div>
                            <div class="md-form">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <input type="email" name="email_usr" class="form-control">
                                <label for="email_usr">Email</label>
                            </div>
                            <div class="md-form">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <input type="password" name="password_usr" class="form-control">
                                <label for="password_usr">Password</label>
                            </div>
                            <div class="md-form">
                                <i class="fa fa-envelope prefix grey-text"></i>
                                <input type="password" name="repassword_usr" class="form-control">
                                <label for="repassword_usr">Confirmar Password</label>
                            </div>

                            <div class="md-form">
                                <!--Blue select-->
                                <select name="rol_usr" class="mdb-select colorful-select dropdown-primary">
                                    <option value="1">Superusuario</option>
                                    <option value="2">Recepcionista</option>
                                    <option value="3">Asesor</option>
                                    <option value="4">Jefe de Taller</option>
                                    <option value="5">Técnico</option>
                                </select>
                                <label>Rol</label>
                            </div>
                            <div class="md-form">
                                <i class="grey-text"></i>
                                <input type="number" name="usuario_suc" class="form-control">
                                 <label for="usuario_suc">Sucursal</label>
                            </div>
                            <div class="md-form">
                                <i class="grey-text"></i>
                                <input type="text" name="cve_usuario" class="form-control">
                                <label for="cve_usuario">Clave Intelisis</label>
                            </div>
                            <!--/Blue select-->
                            <div class="text-center mt-4">
                                <button class="btn btn-primary" type="submit">Registrar</button>
                            </div>
                        </form>
                    <!-- Default form login -->
                </div>
            </div>               
        </div>
    </div>  
</div>
<br><br>