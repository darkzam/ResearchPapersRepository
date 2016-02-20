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

                    </div>
                    <!-- Intro Content -->
                    <div class="ui thirteen wide column">
                     
                        <div class="ui breadcrumb">
                            <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                            <div class="divider"> / </div>
                            <div class="active section">Administrar Solicitudes</div>
                        </div>


                        <!-- Main Content -->




                        <?php if (!empty($message)) { ?>
                            <div id="message">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>


                        <h3 class="ui header">
                            <i class="archive icon"></i>
                            <div class="content">
                                Administrar Solicitudes
                            </div>
                        </h3>

                        <div id="filtrado" class="ui segment ten wide column">

                            <form class="ui form">
                                <div class="ui two fields">
                                    <div class="field">
                                        <label for="busuario">Filtrar por Usuario</label>
                                        <div class="ui loading search">
                                            <div class="ui icon input">

                                                <input id="busuario" class="prompt" type="text" placeholder="Buscar Codigo de Usuario...">
                                                <i id="imagen" class=""></i>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="field">
                                        <label for="bestado">Filtrar por Estado solicitud</label>
                                        <select name="bestado" id="bestado" >
                                            <option value="p" selected>Pendientes</option>
                                            <option value="a">Aprobadas</option>
                                            <option value="d">Denegadas</option>
                                            <option value="" >Todas</option>

                                        </select>

                                    </div>


                                </div>
                                <div class="ui one fields">
                                    <div class="field">
                                        <label for="p">Numero de filas:</label>
                                        <select name="p" id="paginas" class="ui compact dropdown">
                                            <option selected>10</option>
                                            <option >20</option>
                                            <option >30</option>
                                            <option >40</option>
                                            <option >50</option>
                                        </select>
                                    </div>
                                </div>





                            </form>
                        </div>


                        <div id="principal" class="ui red pointing secondary menu">
                            <button  id="pestaña1" class="active item" data-tab="p1">Resultados</button>
                            <button id="pestaña2" class="item" data-tab="p2">Administrar Solicitud</button>
                        </div>
                        <div  id="pc1" class="ui bottom active attached tab segment " data-tab="p1">

                            <div id="loader0" class="ui active inverted dimmer">
                                <div class="ui text loader">Loading</div>
                            </div>



                            <div id="manage"></div>

                        </div>
                        <div id="pc2" class="ui bottom attached tab segment " data-tab="p2">
                            <div id="secundario" class="ui top attached tabular menu">

                                <a id="item1" class="active item" data-tab="first">Datos de Solicitud</a>
                                <a id="historial" class="item" data-tab="second">Historial de Solicitud</a>
                            </div>


                            <div  id="contenido1" class="ui bottom active attached tab segment " data-tab="first">

                                <div id="loader1" class="ui active inverted dimmer">
                                    <div class="ui text loader">Loading</div>
                                </div>
                                <form class="ui form">

                                    <div id="datos"></div>
                                </form> 
                            </div>
                            <div id="contenido2" class="ui bottom attached tab segment " data-tab="second">
                                <div id="loader2" class="ui active inverted dimmer">
                                    <div class="ui text loader">Loading</div>
                                </div>
                                <div id="datos2"></div>
                            </div>



                            <div class="ui segment">
                                <div  class="ui accordion">
                                    <div id="acordeon1" class="title">
                                        <i class="dropdown icon"></i>
                                        Añadir Observacion
                                    </div>

                                    <div id="acordeon2" class="content">


                                        <textarea cols="110" id="comentario"></textarea>


                                    </div>
                                </div> 
                            </div>




                            <div class="row">
                                <button id="aprobar" class="ui button" >Aprobar</button>
                                <button id="denegar" class="ui button">Denegar</button>
                                <button id="exportar" class="ui button">Exportar a pdf</button>


                                <button id="sgte" class="ui tiny right floated labeled icon button">
                                    <i class="right arrow icon"></i>
                                    Siguiente
                                </button>

                                <button id="atras" class="ui tiny right floated labeled icon button">
                                    <i class="left arrow icon"></i>
                                    Atras
                                </button>



                            </div> 




                        </div>
                        <!-- div show oculto para visualizar los datos y aprobar o denegar-->
                    </div>






                    <!-- div popup oculto para formulario de solicitud-->


                    <div id="mensajes"></div> 

                </div>
                <!--        </div>-->
            </div>
        </div>


                <!-- Footer -->  
                <?php $this->load->view('plantillas/footer'); ?> 


                <!-- Scripts -->  
                <?php $this->load->view('plantillas/scripts'); ?>
                <script src="<?php echo $includes_dir; ?>js/request.js"></script>

                </body>
                </html>