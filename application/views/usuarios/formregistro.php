<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Sistema de Consulta de Trabajos de Grado</title>      

        <?php $this->load->view('plantillas/head'); ?> 
    </head>

    <body id="register">

        <div class="ui grid">
            <!-- Header -->  

            <div class="row"></div>
            <div class="ui three wide column"></div>

            <div class="ui ten wide column">
               
                   <h3 class="ui header">
                        <i class="add user icon"></i>
                        <div class="content">
                          Registrar Nueva Cuenta
                        </div>
                      </h3>
                <div class="ui raised segment">
                

                
                    <h4>Datos Personales</h4>
                <?php echo form_open(current_url(), array('class' => 'ui form')); ?>  	

                <div class="two fields">
                    <div class="field">
                        <label for="first_name">Nombres:</label>
                        <input type="text" id="first_name" name="register_first_name" value="<?php echo set_value('register_first_name'); ?>"/>
                    </div>
                    <div class="field">
                        <label for="last_name">Apellidos:</label>
                        <input type="text" id="last_name" name="register_last_name" value="<?php echo set_value('register_last_name'); ?>"/>
                    </div>
                </div>



                <div class="ui divider"></div>
                <h4>Datos de Contacto</h4>
                <div class="two fields">

                    <div class="field">
                        <label for="programa">Programa Academico:</label>
                        <!--<input type="text" id="tarjetacredito" name="programa" value="" >-->
                        <?php $programas = ['Tecnologia de Sistemas', 'Ingenieria de Sistemas', 'Tecnologia en Alimentos', 'Ingenieria de Alimentos', 'Tecnologia Electronica', 'Ingenieria Electronica', 'Ingenieria Industrial', 'Tecnologia Agroambiental', 'Lic. Educacion Fisica', 'Psicologia']; ?>
                        <select name="programa" >
                            <?php for ($i = 0; count($programas) > $i; $i++) { ?>
                                <option><?php echo $programas[$i]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="sede">Sede:</label>
                        <!--<input type="text" id="tarjetacredito" name="sede" value=""/>-->
                        <?php $sedes = ['Palmira', 'Cali', 'Tulua', 'Yumbo', 'Caicedonia', 'Buga', 'Zarzal', 'Cartago', 'Santander de Quilichao', 'Buenaventura']; ?>
                        <select name="sede" >
                            <?php for ($i = 0; count($sedes) > $i; $i++) { ?>
                                <option><?php echo $sedes[$i]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="two fields">
                    
                    <div class="field">

                        <label for="phone_number">Telefono:</label>
                        <input type="text" id="phone_number" name="register_phone_number" value="<?php echo set_value('register_phone_number'); ?>"/>
                    </div>
                    <div class="field"></div>
                </div>



                <div class="ui divider"></div>
                 <h4>Datos de Cuenta</h4>
                <div class="two fields">
                    
                        <div class="field">
                            <label for="username">Codigo:</label>
                            <input type="text" id="username" name="register_username" value="<?php echo set_value('register_username'); ?>" class="tooltip_trigger"
                                   title="Set a username that can be used to login with."
                                   />
                        </div>
                        <div class="field">
                        <label for="email_address">Email:</label>
                        <input type="text" id="email_address" name="register_email_address" value="<?php echo set_value('register_email_address'); ?>" class="tooltip_trigger"
                               title="This demo requires that upon registration, you will need to activate your account via clicking a link that is sent to your email address."
                               />
                        </div>
                  

                </div>

                <div class="two fields">
                     <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="register_password" value="<?php echo set_value('register_password'); ?>"/>
                     </div>
                     <div class="field">
                    <label for="confirm_password">Confirme el Password:</label>
                    <input type="password" id="confirm_password" name="register_confirm_password" value="<?php echo set_value('register_confirm_password'); ?>"/>
                     </div>
                </div>

                <input type="submit" name="register_user" id="submit" value="Crear Cuenta" class="ui button"/>

                <?php echo form_close(); ?>
            </div>
                <?php if (!empty($message)) { ?>
                    <div id="message">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?> 

    </body>
</html>