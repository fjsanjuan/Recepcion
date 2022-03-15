<!-- Menú superior -->
<nav class="navbar navbar-expand-lg navbar-dark dark-primary-color ">
    <span style="font-size:30px; cursor:pointer; color: #ffffff; padding-right: 10px;" id="icono_sidebar">&#9776;</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="<?=base_url();?>"> <img src="<?=base_url()?>assets/img/logo_blanco_intelisis.png" alt="Servicio de Citas" style="width: 49%;"> </a>
        <ul class="navbar-nav ml-auto mt-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-user"></i> <?php echo $this->session->userdata["logged_in"]["nombre"]?>
                </a>
                <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdownMenuLink-4">
                    <!-- <a class="dropdown-item waves-effect waves-light" href="<?=site_url('user/configurar_perfil')?>">Configuración Perfil</a> -->
                    <a class="dropdown-item waves-effect waves-light" href="<?=site_url('user/logout')?>">Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- Menú lateral -->
<div id="menu_sidebar" class="sidenav animated">
  <a href="javascript:void(0)" class="closebtn">&times;</a>
  <br>
  <a href="<?=base_url();?>"><span class="span-sidebar"><i class="fa fa-home"></i> Página Principal</span></a>
  <a href="<?=site_url('user/configurar_perfil')?>"><span class="span-sidebar"><i class="fa fa-cogs"></i> Configuración Perfil</span></a>
  <a href="<?=site_url('buscador/ver_historico')?>"><span class="span-sidebar"><i class="fa fa-calendar-alt"></i> Histórico</span></a>
  <a href="<?=site_url('selfcheckin/self_check_in')?>"><span class="span-sidebar"><i class="fa fa-calendar-alt"></i> Self-Check-In</span></a>
</div>
