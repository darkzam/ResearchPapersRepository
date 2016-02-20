

$(document).on('ready', function() {
    var inicio = true;
    var pagina = 1;
    var numpaginas = 0;

    crearFrame();

    function crearFrame() {

        var id = $('#idtg').val();
        var pag = $('#pagina').val();

        $.ajax({
            'dataType': "json",
            'url': 'http://localhost/SistemaConsultas/usuario_public/pdfajax',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'idtg': id, 'pagina': pag},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#contenedor');
                if (data) {
                    console.log(data);
                    var string = "<iframe src=" +
                            data['path'] +
                            " style='width: 100%; height: 800px;'" +
                            " frameborder='0' scrolling='no'>" +
                            "</iframe>"
                    container.html(string);
                 
                    if (inicio) {
                        numpaginas = data['totalpaginas'];
                        //    alert(numpaginas);
                        $('#npaginas').text("Numero de paginas: " + numpaginas);
                        inicio = false;
                    }
                          alert(numpaginas);
                    eventos();
                }

            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });

    }

    function eventos() {

        $('#sgte').unbind('click');
        $('#sgte').on('click', function() {

            pagina = $('#pagina').val();
            pagina = parseInt(pagina) + 1;
            $('#pagina').val(pagina);

            crearFrame();
        });

        $('#atras').unbind('click');
        $('#atras').on('click', function() {

            pagina = $('#pagina').val();
            pagina = parseInt(pagina) - 1;
            $('#pagina').val(pagina);
            crearFrame();
        });

    }





});