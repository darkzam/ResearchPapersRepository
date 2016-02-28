
<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Sistema de Consultas de Trabajos de Grado</title>

        <?php $this->load->view('plantillas/head'); ?>
    </head>

    <body id="login" >

        <div class="ui grid">
            <div class=" row"></div>
            <div class=" row"></div>
            <div class="ui five wide column">
            </div>
            <div class="ui six wide column">
                <div class="ui raised segment signin">
                    <h3 class="ui centered header">
                        <img class="ui medium image" src="<?php echo $includes_dir; ?>images/logovallepalmira.png"/>
                        <div class="content">
                            Sistema de Consulta de Trabajos de Grado
                            <div class="sub header">Loguee con su Email o Codigo/Cedula con el que se registró</div>
                        </div>
                    </h3>
                    <div class="ui padded grid">
                        <div class="ui four wide column"></div>
                        <?php echo form_open(current_url(), array('class' => 'ui form')); ?>  	


                        <div class="field ">
                            <label for="identity">Login:</label>

                            <div class="ui left icon input">

                                <input type="text" id="identity" name="login_identity" value="<?php echo set_value('login_identity'); ?>" class="tooltip_parent"/>
                                <i class="user icon"></i>
                            </div>
                        </div>

                        <div class="field">
                            <label for="password">Contraseña:</label>
                            <div class="ui left icon input">
                                <input type="password" id="password" name="login_password" value="<?php echo set_value('login_password'); ?>"/>
                                <i class="lock icon"></i>
                            </div>
                        </div>


                        <label for="submit"></label>
                        <input type="submit" name="login_user" id="submit" value="Entrar" class="ui button"/>
                        <a href="<?php echo $base_url; ?>usuario/register_account" class="ui button">Registrarse</a>

                        <?php echo form_close(); ?>	
                    </div>









                </div>
                <?php if (!empty($message)) { ?>
                    <div id="message">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>
            </div>
        </div>


        <!-- Footer -->



        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?> 

    </body>
</html>