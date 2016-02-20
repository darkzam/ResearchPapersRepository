<!doctype html>

<head>
    <meta charset="utf-8">
    <title>Sistema de Consultas de Trabajos de Grado</title>

    <?php $this->load->view('plantillas/head'); ?>

</head>

<body id="public_dashboard">

    <div id="cont1" class="ui container">

        <?php $this->load->view('plantillas/demo_header'); ?> 

        <?php $this->load->view('plantillas/header'); ?> 
        <div id="cont2" class="ui container">

            <div class="ui grid customgrid">
                <!-- Header -->  
                <div class="ui three wide column">  

                </div>

                <div class="ui thirteen wide column">

                    <div class="ui breadcrumb">
                        <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                        <div class="divider"> / </div>
                        <div class="active section">Estadisticas</div>
                    </div>
                    <?php if (!empty($message)) { ?>
                        <div id="message">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>

                    <h3 class="ui header">
                        <i class="bar chart icon"></i>
                        <div class="content">
                            Estadisticas
                        </div>
                    </h3>


                    <div id="principal" class="ui red pointing secondary menu">
                        <button  id="pestaña1" class="active item" data-tab="p1">Solicitudes en el Sistema</button>
                        <button id="pestaña2" class=" item" data-tab="p2">Logueos en el Sistema</button>
                    </div>
                    <div  id="pc1" class="ui bottom active attached tab segment " data-tab="p1">   
                        <div id="loader0" class="ui inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>

                        <div id="canvas-holder1">
                            <canvas  id="canvas1" height="500" width="650"></canvas></br>
                        </div>
                        <div id="tablapie">    </div>

                    </div>
                    <div id="pc2" class="ui bottom attached tab segment " data-tab="p2">

                        <div class="ui segment">
                            <h1>Logueos al sistema</h1>
                            <form class="ui form">
                                <div class="ui two fields">
                                    <div class="field">
                                        <label>Ordenar por:</label>
                                        <select name="bfecha" id="bfecha" class="ui small normal dropdown">

                                            <option value="1">Año-Mes</option>
                                            <option value="0">Mes-Dia</option>

                                        </select>
                                    </div>
                                    <div class="field">
                                        <label>Seleccione mes:</label>
                                        <div id="busquedas"> </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="canvas-holder2">

                            <div id="loader1" class="ui inverted dimmer">
                                <div class="ui text loader">Loading</div>
                            </div>    




                            <div id="contenedor2">

                                <canvas  id="canvas2" height="600" width="730"></canvas>
                            </div>
                        </div>
                    </div>



                </div> 


                <!--                <div class="ui four wide column"></div>-->


                <!--                    <div style="float: left" >
                                            <canvas id="canvas2" height="450" width="475"></canvas>
                                        
                                    </div>-->


            </div>
        </div>
    </div>


    <!-- Footer -->  
    <?php $this->load->view('plantillas/footer'); ?> 

    <!-- Scripts -->  
    <?php $this->load->view('plantillas/scripts'); ?>


    <script type="text/javascript" src="<?php echo $includes_dir; ?>js/ChartNew.js"></script>

    <script type="text/javascript" src="<?php echo $includes_dir; ?>js/Add-ins\stats.js"></script>
    <script src="<?php echo $includes_dir; ?>js/estadisticas.js"></script>


</body>

</html>