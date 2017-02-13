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
                        <div class="ui divider"></div>
                         <div class="ui ordered list">
                                <a href="#div_1" class="item">Buscar y Solicitar Trabajo de Grado</a>
                                <a href="#div_2" class="item">Consultar las Solicitudes Realizadas</a>
                                <a href="#div_3" class="item">Actualizar Datos</a>
                            </div>
                        <div class="ui text container">


                            <div class="ui one column grid">
                                <div class="ui column">
                                    <div id="div_1" class="ui centered header">Guia de Usuario</div>
                                    <p>A continuacion se explica la funcionalidad y uso de cada modulo.</p>
                                    <h3>1.Buscar y Solicitar Trabajo de Grado</h3>
                                    <p>Si desea buscar y solicitar trabajos de grado, puede hacerlo entrando en <b>Busqueda de Tesis</b> : </p>
                                </div>
                                <div class="ui column">
                                    <div class="ui circular image">
                                        <img src="<?php echo $includes_dir; ?>images/botonbuscar.png">
                                    </div>

                                </div>
                                <div class="ui column">
                                    <p>Donde tendremos a disposicion el menu de busqueda de las tesis, el cual contiene cada uno de los filtros de busqueda (<b>Busqueda por Titulo, Autor, Director, Palabras Clave, Año, Programa Academico</b>):
                                    </p>

                                    <div class="ui image">
                                        <img src="<?php echo $includes_dir; ?>images/menubusqueda.png">
                                    </div>
                                </div>
                                <div class="ui column">
                                    <p>Basta con insertar su busqueda en el filtro que desee utilizar para que el sistema comience a cargar resultados; Los filtros pueden encadenarse y traer resultados con varios parametros de busqueda, por ejemplo:</p>
                                    <div class="ui image">
                                        <img src="<?php echo $includes_dir; ?>images/menubusqueda2.png">
                                    </div>
                                </div>
                                <div class="ui column">
                                    <p>Usamos los filtros de <b>Titulo, Año</b> y <b>Programa</b> y obtenemos el resultado acorde. Ahora si deseamos ver la informacion detallada de este trabajo de grado y solicitar parte de su contenido daremos click sobre él, lo que nos lleva a la siguiente pantalla:</p>
                                    <div class="ui image">
                                        <img src="<?php echo $includes_dir; ?>images/menubusqueda3.png">
                                    </div>
                                </div>
                                <div class="ui column">
                                    <p>Desde donde podemos ver en detalle la informacion del trabajo de grado; desde aqui podemos visualizar el trabajo de grado entrando a <b>Visualizar</b>. Si queremos solicitar contenido de este trabajo de grado entramos a la pestaña <b>Formulario de Solicitud</b>, por ejemplo:</p>
                                    <div class="ui image">
                                        <img src="<?php echo $includes_dir; ?>images/menubusqueda4.png">
                                    </div>
                                </div>
                                <div class="ui column">
                                    <p>En la primera seccion del formulario podemos confirmar que nuestros datos sean correctos para garantizar mayor credibilidad en la solicitud y no sea <b>Denegada</b> por los moderadores. En la parte inferior podemos ingresar las paginas del contenido que deseamos solicitar del trabajo de grado:</p>
                                    <div class="ui image">
                                        <img src="<?php echo $includes_dir; ?>images/menubusqueda5.png">
                                    </div>
                                </div>
                                <div class="ui column">
                                    <p>Podemos ingresar rangos validos de paginas(<b>13-25, 20-25</b>), paginas individuales (<b>13, 25, 35</b>), o un conjunto de estas (<b>13, 25, 35-45, 55-75</b>).
                                    </p>
                                    <div class="ui image">
                                        <img src="<?php echo $includes_dir; ?>images/menubusqueda6.png">
                                    </div>
                                </div>
                                <div class="ui column">
                                    <p> Estos rangos y paginas los adicionamos a nuestra solicitud dando click en <b>Añadir</b>, con esto podremos ver el contenido a solicitar hasta el momento; se puede borrar cada etiqueta dando click en <b>X</b> como tambien podemos ingresar nuevo contenido a solicitar.</p><p> Por ultimo si hemos confirmado nuestros datos y las paginas a solicitar crearemos la solicitud dando click en <b>Solicitar Tesis</b>. Si deseamos actualizar nuestra informacion de usuario daremos click en <b>Modificar Datos</b>.</p>

                                    <h3 id="div_2">2.Consultar las Solicitudes Realizadas</h3>
                                    <p>Para revisar el estado de sus solicitudes entre a la opcion <b>Mis Solicitudes</b> </p>
                                </div>  
                                <div class="ui column">
                                    <div class="ui circular image">
                                        <img src="<?php echo $includes_dir; ?>images/botonmissol.png">
                                    </div>
                                </div>
                                <div class="ui column">

                                    <p>Donde podra ver un listado con la informacion de sus solicitudes, junto al estado de estas : <b>Pendiente</b> de Revision por parte de un moderador
                                        , en caso de que su solicitud no sea valida estara <b>Denegada</b> y <b>Aprobada</b> si cumple si la solicitud cumple con las debidas condiciones en cuyo caso podra acercarse a la oficina.
                                    </p>
                                </div>

                                <div id="div_3" class="ui column">
                                    <h3>3.Actualizar Datos</h3>
                                    <p>Si necesita modificar los Datos de su Cuenta, Informacion Personal y  de Contacto, puede hacerlo entrando a la opcion <b>Actualizar Datos</b> :</p>
                                </div> 
                                <div class="ui column">
                                    <div class="ui column">
                                        <div class="ui circular image">
                                            <img src="<?php echo $includes_dir; ?>images/botonactdatos.png">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('plantillas/footer'); ?> 


            <!-- Scripts -->  
            <?php $this->load->view('plantillas/scripts'); ?> 

    </body>
</html>