
<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
    <head>
        <meta charset="utf-8">
<title>Sistema de Consulta de Trabajos de Grado</title>         
        <?php $this->load->view('plantillas/head'); ?> 
    </head>

    <body id="public_dashboard">

        <div id="body_wrap">
            <!-- Header -->  
            <?php $this->load->view('plantillas/header'); ?> 

            <!-- Demo Navigation -->
            <?php $this->load->view('plantillas/demo_header'); ?> 

            <!-- Intro Content -->


            <!-- Main Content -->
            <div class="content_wrap main_content_bg">
                <div class="content clearfix">
                    <div class="col100">

                        <?php if (!empty($message)) { ?>
<!--                            <div id="message">-->
                                <?php echo $message; ?>
<!--                            </div>-->
                        <?php } ?>

                        <div class="w100 frame">							
                        <?php echo $Idd;?>
                        </div>
                       
                         
                    </div>
                </div>
            </div>	

            <!-- Footer -->  
            <?php $this->load->view('plantillas/footer'); ?> 
        </div>

        <!-- Scripts -->  
        <?php $this->load->view('plantillas/scripts'); ?> 
        <script src="<?php echo $includes_dir;?>js/tabla.js"></script>
    </body>
</html>