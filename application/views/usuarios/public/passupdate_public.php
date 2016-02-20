<!doctype html>
<html lang="en">
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

                    </div>
                    <!-- Main Content -->

                    <div class="ui thirteen wide column">

                        <div class="ui breadcrumb">
                            <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                            <div class="divider"> / </div>
                            <a href='<?php echo base_url() . 'usuario_public/update_account' ?>' class="section">Actualizar Cuenta</a>
                            <div class="divider"> / </div>
                            <div class="active section">Cambiar Contraseña</div>
                        </div>

                        <h2 class="ui header">
                            <i class="setting icon"></i>
                            <div class="content">
                                Cambiar Contraseña
                            </div>
                        </h2>

                        <?php if (!empty($message)) { ?>
                            <!--                            <div id="message">-->
                            <?php echo $message; ?>
                            <!--                            </div>-->
                        <?php } ?>


                        <div class="ui segment">
                            <?php echo form_open(current_url(), array('class' => 'ui form')); ?>  	



                            <div class="field">
                                <label for="current_password">Password Actual:</label>
                                <div class="ui left icon input">
                                    <input type="password" id="current_password" name="current_password" value="<?php echo set_value('current_password'); ?>"/>
                                    <i class="lock icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label for="new_password">Nuevo Password:</label>
                                <div class="ui left icon input">
                                    <input type="password" id="new_password" name="new_password" value="<?php echo set_value('new_password'); ?>"/>
                                    <i class="lock icon"></i>
                                </div>
                            </div>
                            <div class="field">
                                <label for="confirm_new_password">Confirme  el nuevo Password:</label>
                                <div class="ui left icon input">
                                    <input type="password" id="confirm_new_password" name="confirm_new_password" value="<?php echo set_value('confirm_new_password'); ?>"/>
                                    <i class="lock icon"></i>
                                </div>
                            </div>
                            <div class="field">

                                <input type="submit" name="change_password" id="submit" value="Actualizar Password" class="ui button"/>
                            </div>


                            <?php echo form_close(); ?>
                        </div>
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