
filainicial = 0;

$(document).on('ready', function() {

    var contador = 0;

    $('.menu .item').tab();

    limpiarAlerta();

    function ajax() {
        contador = 0;

        $('#pestaña2').prop('disabled', true);
        claves = [$('#btitulo').val(), $('#bautor').val(), $('#bdirector').val(), $('#baño').val(), $('#bkeywords').val(), $('#bprogramaac').val()];

        $('#loader0').addClass('active');
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/buscar',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'claves': claves, 'fila': filainicial, 'regmax': '5'},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#container');
                if (data) {
                    container.html(data);
                    $('#imagen0').removeClass('search icon');
                    $('#imagen1').removeClass('search icon');
                    $('#imagen2').removeClass('search icon');
                    $('#imagen3').removeClass('search icon');
                    $('#imagen4').removeClass('search icon');
                    $('#imagen5').removeClass('search icon');

                    $('#pestaña1').addClass('active');
                    $('#pc1').addClass('active');
                    $('#pestaña2').removeClass('active');
                    $('#pc2').removeClass('active');

                    $('#loader0').removeClass('active');


                }

                asignarEventos();


                //  pagination(1);
                pagination2(5);

            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });



    }

    function ajax2(e) {
        //carga al clickear la fila
        //pestaña trabajo de grado
        $('#loader1').addClass('active');
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/getbyId',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'claves': e},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#show');
                if (data) {
                    container.html(data);
                    $('#loader1').removeClass('active');
                }
                //   show();


            },
            error: function(e) {

                alert("error");
            }
        });

        solicitar(e);
    }

    function ajax3(e) {
        //pestaña confirmar datos
        $('#loader2').addClass('active');
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/request_tg',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'claves': e},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#solicitudes');
                if (data) {
                    container.html(data);

                    //modifique aca
                    evitarLetras();

                    $('#confirmar').unbind('click');
                    $('#confirmar').on('click', function() {
                        //enviar los datos 
                        ajax4(e);
                    });
                    botonAñadirPagina();
                    $('#loader2').removeClass('active');
                }
            }
            ,
            error: function(e) {

                alert("error");
            }
        });


    }

    function ajax4(id) {
        //crea la solicitud
        var paginas = getPaginas();
        if (paginas !== '') {

            //manda el ajax
            $.ajax({
                'url': 'http://localhost/SistemaConsultas/usuario_public/crear_solicitud',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'Id_ficha': id, 'Paginas': paginas},
                'success': function(data) {
                    var container = $('#alerta');
                    if (data) {

                        container.html(data);
                        $('#alerta').prop('hidden', false);
                        scrollabajo();
                    }
                },
                'error': function(e) {

                    alert("error");
                    console.log(e);
                }
            });

        } else {

            $('#alerta').html('<div class="ui warning message">' +
                    '<div class="header">' +
                    'Error: Campo Paginas Vacio' +
                    '</div><p>Agregue paginas o rango de paginas.</p></div>');
            $('#alerta').prop('hidden', false);
            scrollabajo();
        }
    }


    $('#btitulo').on('keyup', function() {
        filainicial = 0;



        delay(function() {
            $('#imagen0').addClass('search icon');
            $('#oculto').prop('hidden', false);
            ajax();
        }, 300);


    });


    $('#bautor').on('keyup', function() {
        filainicial = 0;



        delay(function() {
            $('#imagen1').addClass('search icon');
            $('#oculto').prop('hidden', false);
            ajax();
        }, 300);
    });

    $('#bdirector').on('keyup', function() {
        filainicial = 0;

        delay(function() {
            $('#imagen2').addClass('search icon');
            $('#oculto').prop('hidden', false);
            ajax();
        }, 300);
    });

    $('#baño').on('keyup', function() {
        filainicial = 0;

        delay(function() {
            $('#imagen3').addClass('search icon');
            $('#oculto').prop('hidden', false);
            ajax();
        }, 300);
    });

    $('#bkeywords').on('keyup', function() {
        filainicial = 0;

        delay(function() {
            $('#imagen4').addClass('search icon');
            $('#oculto').prop('hidden', false);
            ajax();
        }, 300);
    });

    $('#bprogramaac').on('keyup', function() {
        filainicial = 0;

        delay(function() {
            $('#imagen5').addClass('search icon');
            $('#oculto').prop('hidden', false);
            ajax();
        }, 300);
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
        contador = 0;
        // $('#acordion1').removeClass('active');
        // $('#acordion2').removeClass('active');
        $('.ui.accordion').accordion('close', 0);

        $('#pestaña2').prop('disabled', false);

        $('#principal').tab('change tab', 'p2');
        $('#pestaña1').tab('change tab', 'p2');
        $('#pestaña2').tab('change tab', 'p2');

        ajax2(e);
        botonVisualizar(e);


    }

    function solicitar(e) {

        ajax3(e);


        $("#idficha").val(e);

    }

    function pagination2(r) {
        //podemos optimizar de forma que en index no llame esta funcion mas adelante
        $("#next").on('click', function() {

            filainicial = filainicial + r;
            ajax();
        });

        $("#previous").on('click', function() {

            filainicial = filainicial - r;
            ajax();
        });

    }

    function evitarLetras() {

        $('#paginas').keypress(function(b)
        {
            var key = b.which || b.keyCode;

            if (!(key >= 48 && key <= 57) && // Interval of values (0-9)
                    (key !== 8) && // Backspace
                    (key !== 9) && // Horizontal tab
                    (key !== 37) && // Percentage
                    (key !== 44) && // coma
                    (key !== 45))               // guion
            {
                b.preventDefault();
                return false;
            }
        });

    }

    function botonVisualizar(e) {

        $("#visualizar").unbind('click');
        $("#visualizar").on('click', function() {

            window.open('visualizar/' + e, '_blank');


        });


    }

    function botonAñadirPagina() {

        $("#añadir").unbind('click');
        $("#añadir").on('click', function() {
            var temp = contador;
            var paginas = $("#paginas").val();
            if (paginas !== ''){
                var etiqueta = "<div id='label" + temp.toString() + "' class = 'ui label' ><strong class='paginas'>" + paginas + "</strong><i id='clabel" + temp.toString() + "' class = 'delete icon' ></i></div>";

                $("#etiquetas").append(etiqueta);

                $('#clabel' + temp.toString()).on('click', function() {
                    //  alert("se ejecuta");
                    $('#label' + temp).remove();

                });

                contador = contador + 1;
            }
        });


    }

    function getPaginas() {

        var string = '';
        $('strong').each(function(i) {

            string = string + ($(this).text()) + ',';

        });

        return string;
    }


    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    function scrollabajo() {

        $('html, body').animate({
            scrollTop: $("#alerta").offset().top
        }, 300);

    }

    function limpiarAlerta() {

        $('#secundario1').on('click', function() {

            $('#alerta').prop('hidden', true);

        });

        $('#pestaña1').on('click', function() {

            $('#alerta').prop('hidden', true);

        });

    }

});



    