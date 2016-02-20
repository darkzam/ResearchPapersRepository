<!doctype html>
<html lang="en">
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


                        <!-- Demo Navigation -->
                      
                    </div>
                    <!-- Intro Content -->

                    <div class="ui thirteen wide column">
                       




                        <div class="ui breadcrumb">
                            <div class="active section">Inicio</div>
                            <div class="divider"> / </div>

                        </div>
                        <?php if (!empty($message)) { ?>
<!--                            <div id="message">-->
                                <?php echo $message; ?>
<!--                            </div>-->
                        <?php } ?>


                        <h2 class="ui header">
                            <i class="home icon"></i>
                            <div class="content">
                                Bienvenido al Sistema de Consultas de Trabajos de Grado
                            </div>
                        </h2>


                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('plantillas/footer'); ?> 


        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?> 

    </body>
</html>