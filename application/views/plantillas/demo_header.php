

<div id="menusito" class="ui borderless fixed top vertical menu ">
    <div class="item"></div>
    <div class="item">
        <img id="menuimg" class="ui centered item large image" src="<?php echo $includes_dir; ?>images/manuelita2.png" />
    </div>
      <div class="item"></div>

    <?php if (!$this->flexi_auth->is_admin()) { ?>

        <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_public/">
            <div class="header">
                <i class="home icon"></i>
                Inicio
            </div>
        </a>


        <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_public/search_by">
            <div class="header">
                <i class="search icon"></i>
                Busqueda de Tesis
            </div>
        </a>


        <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_public/check_request_status">
            <div class="header">
                <i class="book icon"></i>
                Mis Solicitudes
            </div>
        </a>

        <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_public/update_account">
            <div class="header">
                <i class="setting icon"></i>
                Actualizar Cuenta
            </div>
        </a>

    <?php } else { ?>

        <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_admin/">
            <div class="header">  
                <i class="home icon"></i>
                Inicio
            </div>
        </a>


        <div id="menu2" class="ui item blanco">
            <div class="header">
                <i class="settings icon"></i>
                Administrar
            </div>
            <div class="menu">

                <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_admin/request_background">

                    <i class=" archive icon"></i>
                    Solicitudes
                </a>

                <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_admin/administrar_usuarios">
                    <i class="user icon"></i>
                    Usuarios</a>




                <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_admin/administrar_grupos">
                    <i class="users icon"></i>
                    Grupos de Usuarios</a>

            </div>	

        </div>


        <div id="menu2" class="ui item blanco">
            <div class="header">
                <i class="suitcase icon"></i>
                Gestionar Tesis
            </div>

            <div class="menu">

                <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_admin/gestionar_tesis">
                    <i class="add square icon"></i>
                    Añadir Tesis</a>

                <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_admin/modificar_tesis">
                    <i class="edit icon"></i>
                    Modificar Tesis</a>


            </div>
        </div>



        <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_admin/estadisticas">
            <div class="header">
                <i class="bar chart icon"></i>
                Estadisticas
            </div>
        </a>

        <?php
    }
    ?> 	
    <a class="item blanco customhover" href="<?php echo $base_url; ?>usuario_public/logout">
        <div class="header">      
            <i class="sign out icon"></i>
            Salir
        </div>
    </a>



</div>
