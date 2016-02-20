
<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Sistema de Consultas de Trabajos de Grado</title>

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
                            <a href='<?php echo base_url() . 'usuario_admin/administrar_usuarios' ?>' class="section">Administrar Usuarios</a>
                            <div class="divider"> / </div>
                            <div class="active section">Editar Usuario</div>
                        </div>

                        <?php if (!empty($message)) { ?>
                            <div id="message">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>

                        <h2 class="ui header">
                            <i class="user icon"></i>
                            <div class="content">
                                Editar Usuario
                            </div>
                        </h2>

                        <?php echo form_open(current_url(), array('class' => 'ui form')); ?>  	
                        <div class="ui segment">
                            <h3>Detalles Personales</h3>
                            <div class="ui two fields">
                                <div class="field">
                                    <label for="first_name">Nombres:</label>
                                    <input type="text" id="first_name" name="update_first_name" value="<?php echo set_value('update_first_name', $user['upro_first_name']); ?>"/>
                                </div>
                                <div class="field">
                                    <label for="last_name">Apellidos:</label>
                                    <input type="text" id="last_name" name="update_last_name" value="<?php echo set_value('update_last_name', $user['upro_last_name']); ?>"/>
                                </div>
                            </div>
                            <div class="ui divider"></div>


                            <h3>Detalles de Contacto</h3>

                            <div class="ui two fields">
                                <!--                        <div class="field">
                                                            <label for="codigo">Codigo/Cedula:</label>
                                                            <input type="text" id="tarjetacredito" name="codigo" value="<?php //echo $user['upro_codigo'];     ?>"/>
                                                        </div>-->

                                <div class="field">
                                    <label for="programa">Programa Academico:</label>
                                    <?php $programas = ['Tecnologia de Sistemas', 'Ingenieria de Sistemas', 'Tecnologia en Alimentos', 'Ingenieria de Alimentos', 'Tecnologia Electronica', 'Ingenieria Electronica', 'Ingenieria Industrial', 'Tecnologia Agroambiental', 'Lic. Educacion Fisica', 'Psicologia']; ?>
                                    <select name="programa" >
                                        <?php for ($i = 0; count($programas) > $i; $i++) { ?>
                                            <option <?php
                                            if ($user['upro_programa'] === $programas[$i]) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $programas[$i]; ?></option>
                                            <?php } ?>
                                    </select>

                                </div>

                                <div class="field">
                                    <label for="sede">Sede:</label>
                                    <!--<input type="text" id="tarjetacredito" name="sede" value="<?php echo $user['upro_sede']; ?>"/>-->

                                    <?php $sedes = ['Palmira', 'Cali', 'Tulua', 'Yumbo', 'Caicedonia', 'Buga', 'Zarzal', 'Cartago', 'Santander de Quilichao', 'Buenaventura']; ?>
                                    <select name="sede" >

                                        <?php for ($i = 0; count($sedes) > $i; $i++) { ?>
                                            <option <?php
                                            if ($user['upro_sede'] === $sedes[$i]) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $sedes[$i]; ?></option>
                                            <?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div class="ui two fields">


                                <div class="field">
                                    <label for="phone_number">Telefono:</label>
                                    <input type="text" id="phone_number" name="update_phone_number" value="<?php echo set_value('update_phone_number', $user['upro_phone']); ?>"/>
                                </div>
                                <div class="field">

                                </div>
                            </div>

                            <div class="ui divider"></div>


                            <h3>Detalles de Cuenta</h3>

                            <div class="ui two fields">
                                <div class="field">
                                    <label for="username">Codigo/Cedula:</label>
                                    <input type="text" id="username" name="update_username" value="<?php echo set_value('update_username', $user[$this->flexi_auth->db_column('user_acc', 'username')]); ?>" class="tooltip_trigger"
                                           title="Set a username that can be used to login with."
                                           />
                                </div>
                                <div class="field">
                                    <label>Email:</label>
                                    <input type="text" id="email" name="update_email" value="<?php echo set_value('update_email', $user[$this->flexi_auth->db_column('user_acc', 'email')]); ?>" class="tooltip_trigger"
                                           title="Set an email address that can be used to login with."
                                           />
                                </div>


                            </div>





                            <div class="ui one fields">
                                <div class="field">

                                    <input type="submit" name="update_account" id="submit" value="Actualizar" class="ui button"/>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
                            <div class="ui divider"></div>
                            <?php echo form_open(current_url(), array('class' => 'ui form')); ?>
                            <h3>Generar Contraseña</h3> 


                            <div class="two fields">
                                <div class="field">
                                    <?php if (!empty($nuevopassword)) { ?>
                                        <input readonly="" type="text" name="generada" value="<?php echo $nuevopassword; ?>"/>
                                    <?php } else { ?>
                                        <input readonly="" type="text" name="generada" value=""/>
                                    <?php } ?>
                                </div>
                                <div class="field"></div>
                            </div>


                            <div class="field">

                                <input type="submit" name="resetearpass" value="Generar Contraseña" class="ui button"/>
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