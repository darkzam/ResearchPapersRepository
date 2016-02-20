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
                        <div class="active section">Administrar Usuarios</div>
                    </div>
                    <h3 class="ui header">
                        <i class="user icon"></i>
                        <div class="content">
                            Administrar Usuarios
                        </div>
                    </h3>
                    <div id="adm_users">             


                        <?php if (!empty($message)) { ?>
                            <div id="message">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>



                        <div class="ui segment">
                            <?php echo form_open(current_url(), array('class' => 'ui form')); ?>

                            <div class="ui one fields">
                                <div class="ui field">
                                    <label for="search">Buscar Nombre de Usuario:</label>
                                    <input type="text" id="search" name="search_query" value="<?php echo set_value('search_users', $search_query); ?>" placeholder="Buscar Usuario..."/>
                                </div>
                            </div>
                            <div class="field">
                                <p> <?php echo $pagination['total_users']; ?> Usuarios encontrados.</p>     
                            </div>   
                            <input type="submit" name="search_users" value="Buscar" class="ui button"/>
                            <button class="ui button"><a href="<?php echo $base_url; ?>usuario_admin/administrar_usuarios" class="link_button grey">Reset</a></button>

                            <?php echo form_close(); ?>

                        </div>
                        <?php echo form_open(current_url()); ?>
                        <table class="ui red celled table table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo/Cedula</th>
                                    <th>Email</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>

                                    <th class="spacer_100 align_ctr tooltip_trigger"
                                        title="Indicates the user group the user belongs to.">
                                        User Group
                                    </th>

                                    <th class="spacer_100 align_ctr tooltip_trigger"
                                        title="If checked, the users account will be locked and they will not be able to login.">
                                        Banear Usuario
                                    </th>
                                    <th>
                                        Modificar

                                    </th>

                                </tr>
                            </thead>
                            <?php if (!empty($users)) { ?>
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                        <tr>
                                            <td> <?php echo $user['uacc_id']; ?>   </td>
                                            <td>   <?php echo $user['uacc_username']; ?>       </td>
                                            <td>   <?php echo $user['uacc_email']; ?>   </td>
                                            <td>   <?php echo $user['upro_first_name']; ?>   </td>
                                            <td>   <?php echo $user['upro_last_name']; ?>    </td>

                                            <td>
                                                <?php echo $user[$this->flexi_auth->db_column('user_group', 'name')]; ?>
                                            </td>
                                            <td class="align_ctr">
                                                <input type="hidden" name="current_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="<?php echo $user[$this->flexi_auth->db_column('user_acc', 'suspend')]; ?>"/>
                                                <!-- A hidden 'suspend_status[]' input is included to detect unchecked checkboxes on submit -->
                                                <input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="0"/>

                                                <?php if ($this->flexi_auth->is_privileged('Administrar Usuarios')) { ?>
                                                    <input type="checkbox" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="1" <?php echo ($user[$this->flexi_auth->db_column('user_acc', 'suspend')] == 1) ? 'checked="checked"' : ""; ?>/>
                                                <?php } else { ?>
                                                    <input type="checkbox" disabled="disabled"/>
                                                    <small>Not Privileged</small>
                                                    <input type="hidden" name="suspend_status[<?php echo $user[$this->flexi_auth->db_column('user_acc', 'id')]; ?>]" value="0"/>-->
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a class="ui button" href="<?php echo base_url() . 'usuario_admin/edit_user/' . $user['uacc_id']; ?>"/>Editar</a>
                <!--                                        <input type="submit" name="editar" value="Editar"/>  -->

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <?php $disable = (!$this->flexi_auth->is_privileged('Administrar Usuarios') ) ? 'disabled="disabled"' : NULL; ?>
                                            <input type="submit" name="update_users" value="Actualizar Usuarios" class="ui button" <?php echo $disable; ?>/>
                                        </td>
                                    </tr>
                                </tfoot>
                            <?php } else { ?>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="highlight_red">
                                            No se encontraron usuarios.
                                        </td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        </table>

                        <?php if (!empty($pagination['links'])) { ?>

                            <div class="ui pagination menu">

                                <?php echo $pagination['links']; ?>

                            </div>
                        <?php } ?>

                        <?php echo form_close(); ?>

                    </div>
                    <!-- div show oculto para visualizar los datos y aprobar o denegar-->
                    <div id="show"></div> 
                    <!-- div popup oculto para formulario de solicitud-->
                    <div id="mensajes"></div> 

                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->  
    <?php $this->load->view('plantillas/footer'); ?> 


    <!-- Scripts -->  
    <?php $this->load->view('plantillas/scripts'); ?>
<!--        <script src="<?php //echo $includes_dir;            ?>js/request.js"></script>-->

</body>
</html>