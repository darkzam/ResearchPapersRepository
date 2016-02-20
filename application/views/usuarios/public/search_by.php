
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
                    <!-- Intro Content -->


                    <!-- Main Content -->

                    <div class="ui thirteen wide column">

                        <div class="ui breadcrumb">
                            <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                            <div class="divider"> / </div>
                            <div class="active section">Busqueda de Tesis</div>
                        </div>

                        <?php if (!empty($message)) { ?>
                            <!--                            <div id="message">-->
                            <?php echo $message; ?>
                            <!--                            </div>-->
                        <?php } ?>

                        <h2 class="ui header">
                            <i class="search icon"></i>
                            <div class="content">
                                Busqueda de Trabajos de Grado
                            </div>
                        </h2>


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
                                            <div class="field">
                                                <label for="bprogramaac">Buscar por Programa Academico</label>
                                                <div class="ui loading search">

                                                    <div class="ui icon input">
                                                        <input type="text" id="bprogramaac" class="prompt" placeholder="Buscar Programa">
                                                        <i id="imagen5" class=""></i>   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="oculto" hidden>
                            <div id="principal" class="ui red pointing secondary menu">
                                <button  id="pestaña1" class="active item" data-tab="p1">Lista Trabajos de Grado</button>
                                <button id="pestaña2" class=" item" data-tab="p2">Solicitar Trabajo de Grado</button>
                            </div>
                            <div  id="pc1" class="ui bottom active attached tab segment" data-tab="p1">   
                                <div id="loader0" class="ui inverted dimmer">
                                    <div class="ui text loader">Cargando</div>
                                </div>
                                <div id="container"></div>

                            </div>
                            <!-- en este div se carga la vista de la tabla con datos obtenidos por ajax-->
                            <div id="pc2" class="ui bottom attached tab segment" data-tab="p2">
                                <div id="secundario" class="ui top attached tabular menu">
                                    <button  id="secundario1" class="active item" data-tab="s1">Trabajo de Grado</button>
                                    <button id="secundario2" class=" item" data-tab="s2">Formulario de Solicitud</button>
                                </div>
                                <div  id="s1" class="ui bottom active attached tab segment " data-tab="s1">  
                                    <div id="loader1" class="ui inverted dimmer">
                                        <div class="ui text loader">Cargando</div>
                                    </div>

                                    <div class="ui one column padded grid">
                                        <div class="column">
                                            <form action="<?php echo base_url() . 'usuario_public/viewpdf'; ?>" method="post" target="_blank" class="ui form">
                                                <div id="show"></div>
                                                <br>
                                                <div class="field">
                                                    <input type="submit" value="Visualizar" name="verpdf" class="ui button">
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                                <div  id="s2" class="ui bottom attached tab segment " data-tab="s2">
                                    <div id="loader2" class="ui inverted dimmer">
                                        <div class="ui text loader">Cargando</div>
                                    </div>
                                    <div class="ui one column padded grid">
                                        <div class="column">
                                            <h2 class="ui centered header">

                                                <div class="content">
                                                    Confirmar Datos
                                                    <div class="sub header">Verifique si sus datos son correctos, actualice su cuenta de ser necesario.</div>
                                                </div>
                                            </h2>
                                            <div id="solicitudes"></div>
                                            <div class="ui divider"></div>
                                            <button id="confirmar" class="ui button">Solicitar Tesis</button>
                                            <a href="<?php echo base_url() . 'usuario_public/update_account' ?>" class="ui button">Modificar Datos</a>
                                        </div>
                                    </div>
<!--                                   <-<<<--<-<--->
                                </div>
                            </div>

                            <div id="alerta" hidden>
                            </div>
                        </div>






                    </div>

                </div>
            </div>

        </div>


        <?php $this->load->view('plantillas/footer'); ?> 






        <!-- Footer -->  



        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?>
        <script src="<?php echo $includes_dir; ?>js/tabla_1.js"></script>

    </body>
</html>