<!doctype html>
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

                </div>

                <div class="ui thirteen wide column">
                    <div class="ui breadcrumb">
                        <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                        <div class="divider"> / </div>
                        <a href='<?php echo base_url() . 'usuario_admin/administrar_grupos' ?>' class="section">Administrar Grupos de Usuarios</a>
                        <div class="divider"> / </div>
                        <div class="active section">Actualizar Permisos</div>
                    </div>

                    <h3 class="ui header">
                        <i class="users icon"></i>
                        <div class="content">
                            Actualizar Permisos del Grupo: <?php echo $group['ugrp_name']; ?>
                        </div>
                    </h3>

                    <?php if (!empty($message)) { ?>
                        <div id="message">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>

                    <?php echo form_open(current_url()); ?>  	
                    <table class="ui red celled table table-hover">
                        <thead>
                            <tr>
                                <th class="tooltip_trigger"
                                    title="The name of the privilege."/>
                                Nombre del Permiso
                                </th>
                                <th class="tooltip_trigger"
                                    title="A short description of the purpose of the privilege."/>
                                Descripcion
                                </th>
                                <th class="spacer_150 align_ctr tooltip_trigger"
                                    title="If checked, the user will be granted the privilege."/>
                                Añadir/Quitar Permiso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($privileges as $privilege) { ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][id]" value="<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>"/>
                                        <?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'name')]; ?>
                                    </td>
                                    <td><?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'description')]; ?></td>
                                    <td class="align_ctr">
                                        <?php
                                        // Define form input values.
                                        $current_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $group_privileges)) ? 1 : 0;
                                        $new_status = (in_array($privilege[$this->flexi_auth->db_column('user_privileges', 'id')], $group_privileges)) ? 'checked="checked"' : NULL;
                                        ?>
                                        <input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][current_status]" value="<?php echo $current_status ?>"/>
                                        <input type="hidden" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][new_status]" value="0"/>
                                        <input type="checkbox" name="update[<?php echo $privilege[$this->flexi_auth->db_column('user_privileges', 'id')]; ?>][new_status]" value="1" <?php echo $new_status ?>/>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <input type="submit" name="update_group_privilege" value="Actualizar" class="ui button"/>
                                </td>
                            </tr>
                        </tfoot>
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