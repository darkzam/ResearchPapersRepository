<!doctype html>
<html lang="en" >
    <head>
        <meta charset="utf-8">
        <title>Sistema de Consulta de Trabajos de Grado</title>        
        <?php $this->load->view('plantillas/head'); ?>

    </head>

    <body id="public_dashboard">


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
                            <a href='<?php echo base_url() ?>' class="section">Inicio</a>
                            <div class="divider"> / </div>
                            <div class="active section">Mis Solicitudes</div>
                        </div>

                        <?php if (!empty($message)) { ?>
<!--                            <div id="message">-->
                                <?php echo $message; ?>
<!--                            </div>-->
                        <?php } ?>


                        <h2 class="ui header">
                            <i class="book icon"></i>
                            <div class="content">
                                Mis Solicitudes
                            </div>
                        </h2>

                        <div id="solicitudes"></div>

                    </div>


                </div>
            </div>
        </div>

        <!-- Footer -->  
        <?php $this->load->view('plantillas/footer'); ?> 


        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?>
        <script src="<?php echo $includes_dir; ?>js/checkrequeststatus.js"></script>

    </body>
</html>