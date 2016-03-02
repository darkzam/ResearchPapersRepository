//dominio = "sistemaconsultas.com";
dominio = location.host;

numpagina = '';
filainicial = 0;



$(document).on('ready', function() {
    w = $(this).width();
    h = $(this).height();

    cargarComponentes();

    index();
    eventoNumeroFilas();
    eventoFestado();
    eventoFuser();

    function index() {

        var opcion = $('#paginas').find(":selected").text();
        registrosporpagina = parseInt(opcion);
        
        var festado = $('#bestado').find(":selected").val();
        var fuser = $('#busuario').val();
        
        $('#pestaña2').prop('disabled', true);



        $('#loader0').addClass('active');
        $.ajax({
            'url': 'http://'+dominio+'/usuario_admin/manage_request',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': numpagina, 'fila': filainicial, 'regmax': registrosporpagina, 'festado': festado, 'fuser': fuser},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#manage'); //jquery selector (get element by id)
                if (data) {

                    container.html(data);
                    $('#imagen').removeClass('search icon');

                    $('#loader0').removeClass('active');

                    $('#pestaña1').addClass('active');
                    $('#pc1').addClass('active');
                    $('#pestaña2').removeClass('active');
                    $('#pc2').removeClass('active');

                    asignarEventos();
                }

                // pagination();
                // mostrarFilas();
                pagination2(registrosporpagina);

            },
            error: function(e) {

                // alert("error index");
                console.log(e);

            }
        });
    }

    function asignarEventos() {
        /* var indice;
         if (numpagina === '') {
         indice = numpagina;
         }
         else {
         indice = (parseInt(numpagina) * 10) - 10;
         } */
        var tam = $('table tbody tr').length;
        //aca modifique
        tamtabla = tam;
        //alert("numero filas "+tam);

        for (var i = 0; i < tam; i++) {

            $('#' + i).on('click', function() {
                var id = $(this).children().first().text();
                filactual = $(this).attr('id');
                //este es el id de del primer hijo de la fila o sea el id de la solicitud

                mostrarCaja(id, filactual);
                //aca modifique
                //  eventoCadena($(this).attr('id'));
            });

        }
    }


    function mostrarCaja(e, fila) {

        //  $.tab('change tab' , 'first');
        //obtener los datos de la ficha pasandole como parametro el id

        //antes que abra el modal cambiar la primera pestaña a active
        /*    $('#item1').addClass('active');
         $('#contenido1').addClass('active');
         $('#historial').removeClass('active');
         $('#fragment-2').removeClass('active');*/
        //cargar pestaña2 de principal
        //habilitar tab
        $('#pestaña2').prop('disabled', false);
        //replegar acordeon de texto
        // $('.ui.styled.accordion .title .content').removeClass('active');

        //cargar el segundo tab con opciones para que se abra el item1 siempre
        $('#secundario').tab('change tab', 'first');
        $('#item1').tab('change tab', 'first');
        $('#historial').tab('change tab', 'first');

        /*$('#cambiar').on('click', function(){
         
         $('.menu .item').tab('change tab' , 'p2');
         });*/


        ajax(e, fila);
        mostrarPestaña(e, fila);
    }

    function ajax(e) {
        //datos solicitud e historial solicitud
        $('#loader1').addClass('active');
        $('#loader2').addClass('active');
        $.ajax({
            'url': 'http://'+dominio+'/usuario_admin/get_request_data',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': e},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#datos');
                if (data) {
                    container.html(data);
                    $('#loader1').removeClass('active');



                }


                //  exportar(e);
                /*   if (secuenciaActivada()) {
                 eventoCadena(fila);
                 mostrarBotones();
                 }*/
            },
            error: function(e) {

                alert("error");
            }
        });

        $.ajax({
            'url': 'http://'+dominio+'/usuario_admin/historial_solicitud',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'clave': e},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#datos2');
                if (data) {
                    container.html(data);
                    $('#loader2').removeClass('active');


                }

            }
            ,
            error: function(e) {
                // alert("error");
            }
        });



    }

    function mostrarPestaña(id) {

        $('#comentario').val('');
        $('#acordeon1').removeClass('active');
        $('#acordeon2').removeClass('active');
        /*    $('#show').modal({onApprove: function() {
         //   ajax(id,fila);
         aprobar(id);
         index();
         //  return false;
         },
         onDeny:function(){
         // ajax(id,fila);
         denegar(id);
         
         // return false;
         },  autofocus: true, duration: 0
         
         });
         $('#show').modal('show');*/

        /*  $('#pestaña2').addClass('active');
         $('#pc2').addClass('active');
         $('#pestaña1').removeClass('active');
         $('#pc1').removeClass('active');
         */

        aprobar(id);
        denegar(id);
        eventoBotonesSgteAtras(id);
        // mostrarBotones();
        $('#principal').tab('change tab', 'p2');
        $('#pestaña1').tab('change tab', 'p2');
        $('#pestaña2').tab('change tab', 'p2');
    }

    function aprobar(id) {
        // se envia por ajax el id de la solicitud que se desee aprobar
        $("#aprobar").unbind('click');
        $("#aprobar").on('click', function() {

            var string = $('#comentario').val();
            $.ajax({
                'url': 'http://'+dominio+'/usuario_admin/aprobar',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'clave': id, 'observacion': string},
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    if (data) {

                    }
                    ajax(id);
                }
                ,
                error: function(e) {
                    alert("error");
                }
            });


        });
    }

    function denegar(id) {
        $("#denegar").unbind('click');
        $("#denegar").on('click', function() {

            var string = $('#comentario').val();
            $.ajax({
                'url': 'http://'+dominio+'/usuario_admin/denegar',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'clave': id, 'observacion': string},
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    if (data) {

                    }
                    ajax(id);
                }
                ,
                error: function(e) {
                    alert("error");
                }
            });

        });
    }



    // function exportar() {//pendiente }



    function pagination2(r) {
        //podemos optimizar de forma que en index no llame esta funcion mas adelante
        $("#next").on('click', function() {

            filainicial = filainicial + r;
            index();
        });

        $("#previous").on('click', function() {

            filainicial = filainicial - r;
            index();
        });

    }

    function eventoNumeroFilas() {

        $('#paginas').change(function() {
            filainicial = 0;
            // $('#manage').empty();
            index();
        });

    }

    function eventoFestado() {

        $('#bestado').change(function() {
            filainicial = 0;
            // $('#manage').empty();

            index();
        });

    }

    function eventoFuser() {

        $('#busuario').on('keyup', function() {
            filainicial = 0;
            $('#imagen').addClass('search icon');
            index();
        });
    }

    function eventoCadena(fila) {

        $('#atras').on('click', function() {

            var nfila = parseInt(fila) - 1;

            $('#' + nfila.toString()).trigger('click');

        });

        $('#sgte').on('click', function() {

            var nfila = parseInt(fila) + 1;

            $('#' + nfila.toString()).trigger('click');

        });

    }

    function secuenciaActivada() {
        if ($('#cadena').is(':checked')) {
            return true;

        } else {

            return false;
        }
    }

    function eventoBotonesSgteAtras(id) {

        var estado = $('#bestado').find(":selected").val();

        $('#sgte').unbind('click');
        $('#sgte').on('click', function() {
            //  alert(estado);
            $.ajax({
                'dataType': 'json',
                'url': 'http://'+dominio+'/usuario_admin/get_solicitud_sgte_atras',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'id': id, 'estado': estado, 'boton': 1},
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"

                    if (data) {
//                       alert(data);
                        if (data > 0) {
                            ajax(data);
//                            aprobar(data);
//                            denegar(data);
//                            eventoBotonesSgteAtras(data);
                            mostrarPestaña(data);
                        }
                        //mandar mensaje de que llego al tope
                    }

                }
                ,
                error: function(e) {
                    alert("error");
                }
            });
        });

        $('#atras').unbind('click');
        $('#atras').on('click', function() {
            //alert(estado);
            $.ajax({
                'dataType': 'json',
                'url': 'http://'+dominio+'/usuario_admin/get_solicitud_sgte_atras',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'id': id, 'estado': estado, 'boton': 0},
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"

                    if (data) {
//                         alert(data);
                        if (data > 0) {
                            ajax(data);
//                            aprobar(data);
//                            denegar(data);
//                            eventoBotonesSgteAtras(data);
                            mostrarPestaña(data);
                        }
                        //mandar mensaje de que llego al tope
                    }

                }
                ,
                error: function(e) {
                    alert("error");
                }
            });
        });

    }

    function cargarComponentes() {

        /*  $('#show').modal({onApprove: function() {
         //index();
         return false;
         }, autofocus: false, duration: 0,
         onHide: function() {
         //  $('#item1').off('click');
         
         }
         }); */

        /*   $('.menu .item').tab({
         history: false,
         onVisible: function() {
         // alert('hey');
         
         }
         
         
         });*/
        //tab principal

        $('#principal').tab();
        $('#pestaña1').tab();
        $('#pestaña2').tab();


        $('.ui.accordion').accordion();
     
    }





});

 