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

            <div id="modificar" class="ui grid customgrid">
                <div class="ui three wide column">

                </div>

                <div class="ui thirteen wide column">
                    <div class="ui breadcrumb">
                        <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                        <div class="divider"> / </div>
                        <div class="active section">Añadir Tesis</div>
                    </div>

                    <?php echo validation_errors('<div class="ui negative message">', "</div>"); ?>

                    <?php
                    if ($this->session->flashdata("success") !== FALSE) {
                        echo '<div class="ui positive message">' . $this->session->flashdata("success") . '</div>';
                    }
                    ?>
                    
                     <?php echo $msg ; ?>

                    <h3 class="ui header">
                        <i class="add square icon"></i>
                        <div class="content">
                            Añadir Trabajo de Grado
                        </div>
                    </h3>



                    <div id="gestionar">

                        <div id="body" class="ui segment">

                            <?php echo form_open_multipart('usuario_admin/upload_file', array('class' => 'ui form')); ?> 
                            <div class=" field"> 
                                <label>Titulo: </label>
                                <input type="text" name="titulo" value="" required="true"/>
                            </div>



                            <div class="field">
                                <label>Autor(es): </label>
                                <input type="text" name="autor" value="" required="true"/>
                            </div>
                            <div class="field">
                                <label>Director(es): </label>
                                <input type="text" name="director" value="" required="true"/>
                            </div>

                            <div class="field">
                                <label>Palabras Claves: </label>
                                <input type="text" name="keywords" value="" required="true"/>
                            </div>

                            <div class="two fields">
                                <div class="field">
                                    <label>Programa Academico: </label>
        <!--                            <input type="text" name="ano" value="" required="true"/>-->
                                    <select name="programa" required>
                                        <option selected value="0">ADMINISTRACIÓN DE EMPRESAS</option>
                                        <option value="1">CONTADURÍA PÚBLICA</option>
                                        <option value="2">EDU FISICA</option>
                                        <option value="3">INGENIERIA INDUSTRIAL</option>
                                        <option value="4">PSICOLOGIA</option>
                                    </select>
                                </div>

                                <div class="field">
                                    <label>Año de Publicacion: </label>
                                    <input type="text" name="ano" value="" required=""/>
                                </div>
                            </div>



                            <div class="field">
                                <div class="ui accordion">

                                    <div class="title">
                                        <i class="dropdown icon"></i>
                                        Resumen: 
                                    </div>
                                    <div class="content">
                                        <textarea name="resumen" value="" required="true"></textarea>
                                    </div>
                                </div>
                            </div>




                            <div class="field">
                                <label id="marvel" for="userfile" class="ui icon button">

                                    Subir archivo
                                    <i class="file icon"></i>
                                </label>
                                <input id="userfile" style="display:none" type="file" name="userfile" size="20" required="true" />
                            </div>


                            <input class="ui button" type="submit" value="Crear Tesis" />
                            <?php echo form_close(); ?>


                        </div>
                    </div>
                </div>         




            </div>
        </div>
    </div>

    <!-- Footer -->  
    <?php $this->load->view('plantillas/footer'); ?> 


    <!-- Scripts -->  
    <?php $this->load->view('plantillas/scripts'); ?>
    <script src="<?php echo $includes_dir; ?>js/gestion_tesis.js"></script>

</body>
</html>