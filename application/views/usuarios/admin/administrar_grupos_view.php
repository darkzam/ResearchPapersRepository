<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Sistema de Consulta de Trabajos de Grado</title>        
        <?php $this->load->view('plantillas/head'); ?> 
    </head>

    <body>

        <div id="cont1" class="ui container">

            <?php $this->load->view('plantillas/demo_header'); ?> 

            <?php $this->load->view('plantillas/header'); ?> 
            <div id="cont2" class="ui container">



                <div class="ui grid customgrid">
                    <div class="ui three wide column">


                        <!-- Demo Navigation -->

                        <!-- Intro Content -->
                    </div>



                    <!-- Main Content -->


                    <div class="ui thirteen wide column">
                        <div class="ui breadcrumb">
                            <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                            <div class="divider"> / </div>
                            <div class="active section">Administrar Grupos de Usuarios</div>
                        </div>
                        <?php if (!empty($message)) { ?>
                          
                                <?php echo $message; ?>
                           
                        <?php } ?>


                        <h3 class="ui header">
                            <i class="users icon"></i>
                            <div class="content">
                                Administrar Grupos de Usuarios
                            </div>
                        </h3>

                        <?php echo form_open(current_url()); ?>  	
                        <table class="ui red celled table table-hover">
                            <thead>
                                <tr>
                                    <th class="spacer_150 tooltip_trigger" 
                                        title="The user group name.">
                                        Nombre del Grupo
                                    </th>
                                    <th class="tooltip_trigger" 
                                        title="A short description of the purpose of the user group.">
                                        Descripcion
                                    </th>
                                    <th class="spacer_100 align_ctr tooltip_trigger" 
                                        title="Indicates whether the group is considered an 'Admin' group.<br/> Note: Privileges can still be set seperately.">
                                        Es Grupo Administrador
                                    </th>
                                    <th class="spacer_100 align_ctr tooltip_trigger"
                                        title="Manage the access privileges of user groups.">
                                        Modificar Permisos del Grupo
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_groups as $group) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $group[$this->flexi_auth->db_column('user_group', 'name')]; ?>
                                        </td>
                                        <td><?php echo $group[$this->flexi_auth->db_column('user_group', 'description')]; ?></td>
                                        <td class="align_ctr"><?php echo ($group[$this->flexi_auth->db_column('user_group', 'admin')] == 1) ? "Si" : "No"; ?></td>
                                        <td class="align_ctr">
                                            <a class="ui button" href="<?php echo $base_url . 'usuario_admin/actualizar_permisos_grupos/' . $group[$this->flexi_auth->db_column('user_group', 'id')]; ?>">Modificar</a>
                                        </td>	
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->  
        <?php $this->load->view('plantillas/footer'); ?> 

        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?> 

    </body>
</html>