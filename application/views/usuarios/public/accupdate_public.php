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
                    <div class="three wide column">
                    </div>

                    <div class=" thirteen wide column">


                        <div class="ui breadcrumb">
                            <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                            <div class="divider"> / </div>
                            <div class="active section">Actualizar Cuenta</div>
                        </div>

                        <?php if (!empty($message)) { ?>

                            <?php echo $message; ?>

                        <?php } ?>

                        <h2 class="ui header">
                            <i class="setting icon"></i>
                            <div class="content">
                                Actualizar Datos de Cuenta
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
                        </div>

                        <div class="ui segment">
                            <h3>Detalles de Contacto</h3>

                            <div class="ui two fields">

<!--                                <div class="field">
                                    <label for="programa">Programa Academico:</label>
                                    <?php //$programas = ['Tecnologia de Sistemas', 'Ingenieria de Sistemas', 'Tecnologia en Alimentos', 'Ingenieria de Alimentos', 'Tecnologia Electronica', 'Ingenieria Electronica', 'Ingenieria Industrial', 'Tecnologia Agroambiental', 'Lic. Educacion Fisica', 'Psicologia']; ?>
                                    <select name="programa" >
                                        <?php //for ($i = 0; count($programas) > $i; $i++) { ?>
                                            <option <?php
                                            //if ($user['upro_programa'] === $programas[$i]) {
                                             //   echo 'selected';
                                           // }
                                            ?>><?php// echo $programas[$i]; ?></option>
                                            <?php //} ?>
                                    </select>

                                </div>-->

                                <div class="field">
                                    <label> Programa Academico: </label>
                                    <select name="programa" required>
                                        <?php
                                        $seleccionado = false;
                                        foreach ($programas as $programa) {
                                            ?>

                                            <?php
                                            if ($user['upro_programa'] === $programa['id']) {
                                                $seleccionado = true;
                                            }
                                            ?>

                                            <option <?php
                                            if ($seleccionado) {
                                                echo "selected";
                                            }
                                            ?> value="<?php echo $programa['id']; ?>">
                                                    <?php
                                                    if ($seleccionado) {
                                                        echo "**";
                                                    }
                                                    echo $programa['codigo'] . "-" . $programa['nombre'];
                                                    if ($seleccionado) {
                                                        echo "**";
                                                    }
                                                    ?>
                                            </option>

                                            <?php
                                            $seleccionado = false;
                                        }
                                        ?>
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
                                    <!--                            <label for="codigo">Codigo/Cedula:</label>-->
                                    <!--                            <input type="text" id="tarjetacredito" name="codigo" value="<?php //echo $user['upro_codigo'];          ?>"/>-->
                                </div>



                            </div>


                        </div>

                        <div class="ui segment">
                            <h3>Detalles de Cuenta</h3>

                            <div class="ui two fields">
                                <div class="field">
                                    <label for="username">Codigo/Cedula:</label>
                                    <input type="text" id="username" name="update_username" value="<?php echo set_value('update_username', $user[$this->flexi_auth->db_column('user_acc', 'username')]); ?>" class="tooltip_trigger"
                                           title="Set a username that can be used to login with."
                                           />
                                </div>
                                <div class="field">
                                    <label>Direccion Email:</label>
                                    <input type="text" id="email" name="update_email" value="<?php echo set_value('update_email', $user[$this->flexi_auth->db_column('user_acc', 'email')]); ?>" class="tooltip_trigger"
                                           title="Set an email address that can be used to login with."
                                           />
                                </div>


                            </div>
                            <div class="ui one fields">
                                <div class="field">
                                    <label>Contraseña:</label>
                                    <a href="<?php echo $base_url; ?>usuario_public/change_password">Cambiar Contraseña</a>
                                </div>
                            </div>
                        </div>

                        <div class="ui segment">

                            <div class="ui one fields">
                                <div class="field">

                                    <input type="submit" name="update_account" id="submit" value="Actualizar" class="ui button"/>
                                </div>
                            </div>
                        </div>
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