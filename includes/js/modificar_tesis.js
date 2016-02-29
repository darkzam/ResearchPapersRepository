dominio = "sistemaconsultas.com";

numpagina = '';
filainicial = 0;

$(document).on('ready', function () {


    $('.ui.accordion').accordion();
    $('.menu .item').tab();

    $('#pestaña2').prop('disabled', true);

    index2();
    //eventoNumeroFilas();
    eventoFuser();

    function index() {

        var opcion = $('#paginas').find(":selected").text();
        registrosporpagina = parseInt(opcion);

        var fid = $('#fid').val();

//devuelve la tabla de tesis con paginado y busqueda de id
        $('#loader0').addClass('active');
        $.ajax({
            'url': 'http://' + dominio + '/usuario_admin/get_tesis',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'fila': filainicial, 'regmax': registrosporpagina, 'fid': fid},
            'success': function (data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#tabla_fichas'); //jquery selector (get element by id)
                if (data) {

                    container.html(data);
                    $('#imagen').removeClass('search icon');

                    $('#loader0').removeClass('active');

                    $('#pestaña1').addClass('active');
                    $('#pc1').addClass('active');
                    $('#pestaña2').removeClass('active');
                    $('#pc2').removeClass('active');

                    asignarEventos();
                    eventoNumeroFilas(false);
                }


                pagination2(registrosporpagina, false);

            },
            error: function (e) {

                alert("error index");
                console.log(e);

            }
        });
    }

    //////////////////////////

    function index2() {

        var opcion = $('#paginas').find(":selected").text();
        registrosporpagina = parseInt(opcion);

        claves = [$('#btitulo').val(), $('#bautor').val(), $('#bdirector').val(), $('#baño').val(), $('#bkeywords').val(), $('#bprogramaac').val()];

        $('#loader0').addClass('active');
        $.ajax({
            'url': 'http://' + dominio + '/usuario_admin/busqueda_ajax_tesis',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'claves': claves, 'fila': filainicial, 'regmax': registrosporpagina},
            'success': function (data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#tabla_fichas');
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

                    asignarEventos();
                    eventoNumeroFilas(true);
                }
                pagination2(registrosporpagina, true);

            },
            error: function (e) {

                alert("error");
                console.log(e);

            }
        });



    }

    $('#btitulo').on('keyup', function () {
        filainicial = 0;
        delay(function () {
            $('#imagen0').addClass('search icon');
            $('#oculto').prop('hidden', false);
            index2();
        }, 300);


    });

    $('#bautor').on('keyup', function () {
        filainicial = 0;
        delay(function () {
            $('#imagen1').addClass('search icon');
            $('#oculto').prop('hidden', false);
            index2();
        }, 300);
    });

    $('#bdirector').on('keyup', function () {
        filainicial = 0;

        delay(function () {
            $('#imagen2').addClass('search icon');
            $('#oculto').prop('hidden', false);
            index2();
        }, 300);
    });

    $('#baño').on('keyup', function () {
        filainicial = 0;

        delay(function () {
            $('#imagen3').addClass('search icon');
            $('#oculto').prop('hidden', false);
            index2();
        }, 300);
    });

    $('#bkeywords').on('keyup', function () {
        filainicial = 0;

        delay(function () {
            $('#imagen4').addClass('search icon');
            $('#oculto').prop('hidden', false);
            index2();
        }, 300);
    });

//    $('#bprogramaac').on('keyup', function () {
//        filainicial = 0;
//
//        delay(function () {
//            $('#imagen5').addClass('search icon');
//            $('#oculto').prop('hidden', false);
//            index2();
//        }, 300);
//    });

    $('#bprogramaac').on('change', function () {
        filainicial = 0;

        index2();

    });

    var delay = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    //////////////////






    function pagination2(r, busqueda) {
        //podemos optimizar de forma que en index no llame esta funcion mas adelante

        $("#next").on('click', function () {

            filainicial = filainicial + r;
            if (busqueda) {
                index2();
            } else {
                index();
            }
        });

        $("#previous").on('click', function () {

            filainicial = filainicial - r;
            if (busqueda) {
                index2();
            } else {
                index();
            }
        });

    }
    function eventoNumeroFilas(busqueda) {
        $('#paginas').unbind('change');
        $('#paginas').change(function () {
            filainicial = 0;
            if (busqueda) {
                index2();
            } else {
                index();
            }
        });

    }

    function eventoFuser() {

        $('#fid').on('keyup', function () {
            filainicial = 0;
            $('#imagen').addClass('search icon');
            index();
        });
    }

    function asignarEventos() {

        var tam = $('table tbody tr').length;
        //aca modifique
        tamtabla = tam;


        for (var i = 0; i < tam; i++) {

            $('#' + i).on('click', function () {
                var id = $(this).children().first().text();
                filactual = $(this).attr('id');
                //este es el id de del primer hijo de la fila o sea el id de la solicitud

                mostrarCaja(id);
                //aca modifique
                //  eventoCadena($(this).attr('id'));
            });

        }
    }

    function mostrarCaja(e) {


        $('#pestaña2').prop('disabled', false);

        ajax(e);

        mostrarPestaña(e);
    }


    function ajax(e) {
        //datos solicitud e historial solicitud
        $('#loader1').addClass('active');
        // $('#loader2').addClass('active');
        $.ajax({
            'url': 'http://' + dominio + '/usuario_admin/ajax_tesis_id',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'id': e},
            'success': function (data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#formulario');
                if (data) {
                    container.html(data);
                    cargar();
                    $('#loader1').removeClass('active');
                    evento_userfile();


                }

            },
            error: function (e) {

                alert("error");
            }
        });


    }

    function mostrarPestaña(id) {


        // botonActualizar();
        botonVisualizar(id);

        // botonesSgteAtras();

        $('#principal').tab('change tab', 'p2');
        $('#pestaña1').tab('change tab', 'p2');
        $('#pestaña2').tab('change tab', 'p2');

    }

    function cargar() {

        //   $('form').addClass('ui form');
        $('.ui.accordion').accordion();
    }

    function botonVisualizar(id) {
        $("#visualizar").unbind('click');
        $("#visualizar").on('click', function () {


            window.open('visualizar/' + id, '_blank');


        });

    }

    function evento_userfile() {
        $('#userfile').unbind('change');
        $('#userfile').on('change', function (e) {
            //  alert("funciona");
            console.log(e.target.files[0].name);

            if (e.target.files[0].name !== '') {

                $('#marvel').html('<p>' + e.target.files[0].name + '</p><i class="file icon"></i>');

            }
        });

    }


});