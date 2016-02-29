
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sistema de Consulta de Trabajos de Grado</title>       
        <?php $this->load->view('plantillas/head'); ?>

    </head>

    <body >
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
                            <div class="active section">Modificar Tesis</div>
                        </div>

                        <h3 class="ui header">
                            <i class="edit icon"></i>
                            <div class="content">
                                Modificar Tesis
                            </div>
                        </h3>


                        <?php if (!empty($message)) { ?>
                            <div id="message">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>


                        <!------------------------>
                        <div id="busquedacont" class="ui segment">

                            <div class="ui accordion">
                                <div id="acordion1" class="active title">
                                    <i class="dropdown icon"></i>
                                    Menu de Busqueda
                                </div>
                                <div id="acordion2" class="active content">
                                    <form class="ui form">
                                        <div class="two fields">
                                            <div class="field">
                                                <label for="fid">Buscar por Identificador</label>
                                                <div class="ui loading search">
                                                    <div class="ui icon input">
                                                        <input id="fid" class="prompt" type="text" placeholder="Buscar...">
                                                        <i id="imagen" class=""></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field"></div>
                                        </div>


                                        <div class="ui divider"></div>

                                        <div class="two fields">
                                            <div class="field">
                                                <label for="btitulo">Buscar por Titulo</label>
                                                <div class="ui loading search">

                                                    <div class="ui icon input">      
                                                        <input type="text" id ="btitulo" class="prompt" placeholder="Buscar Titulo">
                                                        <i id="imagen0" class=""></i>     
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label for="bautor">Buscar por Autor</label>
                                                <div class="ui loading search">

                                                    <div class="ui icon input">

                                                        <input type="text" id="bautor" class="prompt" placeholder="Buscar Autor">
                                                        <i id="imagen1" class=""></i>     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="two fields">
                                            <div class="field">
                                                <label for="bdirector">Buscar por Director</label>
                                                <div class="ui loading search">
                                                    <div class="ui icon input">
                                                        <input type="text" id="bdirector" class="prompt" placeholder="Buscar Director">
                                                        <i id="imagen2" class=""></i>     
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label for="baño">Buscar por Año </label>
                                                <div class="ui loading search">

                                                    <div class="ui icon input">
                                                        <input type="text" id="baño" class="prompt" placeholder="Buscar Año">
                                                        <i id="imagen3" class=""></i>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="two fields">
                                            <div class="field">
                                                <label for="bkeywords">Buscar por Palabras Claves</label>
                                                <div class="ui loading search">

                                                    <div class="ui icon input">
                                                        <input type="text" id="bkeywords" class="prompt" placeholder="Buscar Palabras">
                                                        <i id="imagen4" class=""></i>   
                                                    </div>
                                                </div>
                                            </div>
                                            <!--                                            <div class="field">
                                                                                            <label for="bprogramaac">Buscar por Programa Academico</label>
                                                                                            <div class="ui loading search">
                                            
                                                                                                <div class="ui icon input">
                                                                                                    <input type="text" id="bprogramaac" class="prompt" placeholder="Buscar Programa">
                                                                                                    <i id="imagen4" class=""></i>   
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>-->

                                            <div class="field">
                                                <label>Buscar por Programa Academico: </label>
                                                <select id="bprogramaac" name="programa" required>
                                                    <option selected value="">Todos</option>
                                                    <?php
                                                    foreach ($programas as $programa) {
                                                        ?>
                                                        <option value="<?php echo $programa['id']; ?>">
                                                            <?php
                                                            echo $programa['codigo'] . "-" . $programa['nombre'];
                                                            ?>
                                                        </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>



                        <!---------------------------->

                        <div id="principal" class="ui red pointing secondary menu">
                            <button  id="pestaña1" class="active item" data-tab="p1">Lista Trabajos de Grado</button>
                            <button id="pestaña2" class=" item" data-tab="p2">Modificar Trabajo de Grado</button>
                        </div>

                        <div  id="pc1" class="ui bottom active attached tab segment" data-tab="p1">   
                            <div id="loader0" class="ui active inverted dimmer">
                                <div class="ui text loader">Loading</div>
                            </div>


                            <div id="filtrado" >
                                <label for="p">Filas</label>
                                <select name="p" id="paginas" class="ui compact dropdown">
                                    <option selected>5</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                </select>
                            </div>


                            <div id="tabla_fichas" ></div>



                        </div>
                        <div id="pc2" class="ui bottom attached tab segment" data-tab="p2">

                            <div id="loader1" class="ui active inverted dimmer">
                                <div class="ui text loader">Loading</div>
                            </div>
                            <div class="ui segment">
                                <?php echo form_open_multipart('usuario_admin/upload_file2', array('class' => 'ui form')); ?> 
                                <div id="formulario"></div>
                                <br>
                                <?php echo form_close(); ?>
                                <button id="visualizar" class="ui button">Descargar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('plantillas/footer'); ?> 


        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?>
        <script src="<?php echo $includes_dir; ?>js/modificar_tesis.js"></script>

    </body>
</html>