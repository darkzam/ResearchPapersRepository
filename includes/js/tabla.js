numpagina = '';
$(document).on('ready', function() {
    w = $(this).width();
    h = $(this).height();

   // index();
    btitulo();
    function index() {
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/get_list_view',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': numpagina},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#container'); //jquery selector (get element by id)
                if (data) {
                    container.html(data);
                }
                asignarEventos();
                alert(numpagina);
                pagination(0);

            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
       
    }
    function btitulo() {
       // $('#btitulo').off('keyup', 'hola');
        $('#btitulo').on('keyup', function () {

            claves = [$('#btitulo').val(), $('#bautor').val(), $('#bdirector').val(), $('#baño').val(), $('#bkeywords').val()];
            $.ajax({
                'url': 'http://localhost/SistemaConsultas/usuario_public/buscar',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'clave': $('#btitulo').val(), 'claves': claves, 'numpagina': numpagina},
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    var container = $('#container');
                    if (data) {
                        container.html(data);
                    }
                    asignarEventos();
                 //   alert(numpagina);
                   
                    pagination();
                },
                error: function(e) {

                    alert("error");
                    console.log(e);

                }
            });


        });
    }

    $('#bautor').on('keyup', function() {

        //valor campos
        claves = [$('#btitulo').val(), $('#bautor').val(), $('#bdirector').val(), $('#baño').val(), $('#bkeywords').val()];
        //validar los valores
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/buscar',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': $('#bautor').val(), 'claves': claves},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#container');
                if (data) {
                    container.html(data);
                }
                asignarEventos();
            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
    });

    $('#bdirector').on('keyup', function() {

        //valor campos
        claves = [$('#btitulo').val(), $('#bautor').val(), $('#bdirector').val(), $('#baño').val(), $('#bkeywords').val()];
        //validar los valores
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/buscar',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': $('#bautor').val(), 'claves': claves},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#container');
                if (data) {
                    container.html(data);
                }
                asignarEventos();
            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
    });

    $('#baño').on('keyup', function() {

        //valor campos
        claves = [$('#btitulo').val(), $('#bautor').val(), $('#bdirector').val(), $('#baño').val(), $('#bkeywords').val()];
        //validar los valores
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/buscar',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': $('#bautor').val(), 'claves': claves},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#container');
                if (data) {
                    container.html(data);
                }
                asignarEventos();
            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
    });

    $('#bkeywords').on('keyup', function() {

        //valor campos
        claves = [$('#btitulo').val(), $('#bautor').val(), $('#bdirector').val(), $('#baño').val(), $('#bkeywords').val()];
        //validar los valores
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/buscar',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': $('#bautor').val(), 'claves': claves},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#container');
                if (data) {
                    container.html(data);
                }
                asignarEventos();
            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
    });

    function asignarEventos() {

        var tam = $('table tbody tr').length;
        //alert("numero filas "+tam);
        for (var i = 0; i < tam; i++) {
            $('#' + i).on('click', function() {
                var id = $(this).children().first().text();

                //alert("el id de la celda es: " + id);
                //  console.log(id);
                mostrarCaja(id);

            });
        }
    }

    function mostrarCaja(e) {
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/getbyId',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'claves': e},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#show');
                if (data) {
                    container.html(data);

                }
                show();
                solicitar(e);

            },
            error: function(e) {

                alert("error");
            }
        });

    }
    function show() {

        $("#show").dialog({
            closeText: "Cerrar",
            autoOpen: false,
            modal: true,
            title: "Ver trabajo de Grado",
            width: w / 2 + w / 3.3,
            //show: "fold",
            hide: "scale",
            resizable: false,
            close: function() {
                $(this).dialog('destroy');
                $(this).html('');
            }
        });

        $("#show").dialog('open');
    }

    function solicitar(e) {
        $("#solicitar").on('click', function() {
            $.ajax({
                'url': 'http://localhost/SistemaConsultas/usuario_public/request_tg',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'claves': e},
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    var container = $('#solicitudes');
                    if (data) {
                        container.html(data);
                        container.dialog({
                            closeText: "Cerrar",
                            autoOpen: false,
                            modal: true,
                            title: "Solicitar Trabajo de Grado",
                            width: w / 2 + w / 3.3,
                            // show: "fold",
                            hide: "scale",
                            resizable: false,
                            close: function() {
                                $(this).dialog('destroy');
                                $(this).html('');
                            }
                        });
                        container.dialog('open');
                        $('#confirmar').on('click', function() {
                            //enviar los datos

                            $.ajax({
                                'url': 'http://localhost/SistemaConsultas/usuario_public/crear_solicitud',
                                'type': 'POST', //the way you want to send data to your URL
                                'data': {'Id_user': $('#puserid').val(), 'Id_ficha': $('#ppid').val()},
                                'success': function(data) {
                                    if (data) {
                                        alert("solicitud creada");
                                    }
                                },
                                'error': function(e) {

                                    alert("error");
                                    console.log(e);
                                }
                            });
                            $('#solicitudes').dialog('close');


                        });
                    }
                }
                ,
                error: function(e) {

                    alert("error");
                }
            });


        });


    }

    function pagination() {
        //asignar eventos a los botones
        var lista = $("#paginacion li");
        for (var i = 1; i < lista.length + 1; i++) {
            $('#' + i + '-page').on('click', function() {
                numpagina = '' + $(this).attr('id')[0];
               // alert(numpagina);
                
                  btitulo();
               
            });

        }
    }

});


/*busqueda por titulo
 * basico
 * cada que se ingrese un caracter en el input titulo efecturas la busqueda y mostrar los resultados
 * si esta buscando y se ingresa otro , borre la antigua respuesta y busque la nueva
 * avanzado
 * verificar cadena de busqueda
 * realizar la busqueda en los resultados de anterior busqueda
 */


    