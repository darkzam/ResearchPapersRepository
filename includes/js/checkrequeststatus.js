
filainicial = 0;

$(document).on('ready', function() {
   

    index();

    function index() {
        $.ajax({
            'url': 'http://localhost/SistemaConsultas/usuario_public/get_request_status',
            'type': 'POST', //the way you want to send data to your URL
            'data': { 'fila': filainicial, 'regmax': '5'},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#solicitudes'); //jquery selector (get element by id)
                if (data) {
                    container.html(data);
                }
             
                pagination2(5);
            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
    }
    
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

});