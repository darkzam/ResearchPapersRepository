
$(document).on('ready', function() {
    var unavez = true;
    var unavez2 = true;
   
     $('.menu .item').tab();
   
    index1();
    index2();
    eventosBusqueda();

    function index1() {
        $("#loader0").addClass('active');
        $.ajax({
            'dataType': "json",
            'url': 'http://localhost/SistemaConsultas/usuario_admin/get_estadisticas',
            'type': 'POST', //the way you want to send data to your URL
            'data': null,
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"

                if (data) {
                  //  console.log(data);

                    dibujarPie(data['naprob'], data['ndeneg'], data['npendi']);
                    insertarTabla(data['naprob'], data['ndeneg'], data['npendi']);
                    $("#loader0").removeClass('active');
                }


            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
    }
    function index2() {
         $("#loader1").addClass('active');
        
        var opcion = $('#bfecha').find(":selected").val();
        seleccion = parseInt(opcion);
        seleccion2 = null;

        if (!seleccion) {
            $('#busquedas').show();
            seleccion2 = $('#saño').find(":selected").text();
            if (unavez2) {
                setearSelects();
                unavez2 = false;
            }
        } else {
            $('#busquedas').hide();

        }
        $.ajax({
            'dataType': "json",
            'url': 'http://localhost/SistemaConsultas/usuario_admin/get_estadisticas_ingresos',
            'type': 'POST', //the way you want to send data to your URL
            'data': {'opcion1': seleccion, 'opcion2': seleccion2},
            'success': function(data) { //probably this request will return anything, it'll be put in var "data"

                if (data) {
                  //  console.log(data);
                    dibujarGraficaLinea(data, seleccion);
                      $("#loader1").removeClass('active');
                }


            },
            error: function(e) {

                alert("error");
                console.log(e);

            }
        });
    }

    function dibujarPie(naprob, ndeneg, npendi) {

        var mydata1 = [
            {
                value: naprob,
                color: "Green",
                title: "Aprobadas"
            },
            {
                value: ndeneg,
                color: "Red",
                title: "Denegadas"
            },
            {
                value: npendi,
                color: "Blue",
                title: "Pendientes"
            }

        ];


        var varcrosstxt = {
            canvasBordersWidth: 3,
            canvasBordersColor: "black",
            crossText: ["Total:\n#sum#"],
            crossTextIter: ["all"],
            crossTextOverlay: [true],
            crossTextFontSize: [50],
            crossTextFontColor: ["black"],
            crossTextRelativePosX: [2],
            crossTextRelativePosY: [2],
            crossTextAlign: ["center"],
            crossTextBaseline: ["middle"],
            inGraphDataShow: true,
            legend: true,
            canvasBorders: false,
            graphTitle: "Solicitudes en el Sistema",
            graphTitleFontFamily: "'Arial'",
            graphTitleFontSize: 24,
            graphTitleFontStyle: "bold",
            graphTitleFontColor: "#666"

        };

        function roundToNumber(num, place) {
            var newval = 1 * num;

            if (typeof (newval) == "number") {
                if (place <= 0) {
                    var roundVal = -place;
                    newval = +(Math.round(newval + "e+" + roundVal) + "e-" + roundVal);
                }
                else {
                    var roundVal = place;
                    var divval = "1e+" + roundVal;
                    newval = +(Math.round(newval / divval)) * divval;
                }
            }
            return(newval);
        }
        ;



        stats(mydata1, varcrosstxt);

        var pie = new Chart(document.getElementById("canvas1").getContext("2d")).Doughnut(mydata1, varcrosstxt);
      //      console.log(pie);
    }

    function dibujarGraficaLinea(datos, seleccion) {
        var titulo = '';
        var b = new Array();
        var c = new Array();
        var string = '<select name="lineagraf" id="saño">';

        if (seleccion) {
            titulo = 'Grafica Año-Mes';
            for (var index in datos) {
                if (!datos.hasOwnProperty(index)) {
                    continue;
                }
                b.push(index);
                c.push(datos[index]);

                if (unavez) {
                    string = string + '<option>' + index + '</option>';
                }
            }
            if (unavez) {
                string =  string + '</select>';
                $('#busquedas').html(string);
                unavez = false;
            }
            var data = {
                labels: b,
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: c,
                        title: ''
                    }


                ]
            };
        } else {
            titulo = 'Grafica Mes-Dia';
            for (var i = 0; i < datos.length; i++) {

                b.push(datos[i]['fecha_login']);
                c.push(datos[i]['numero_logins']);

                var data = {
                    labels: b,
                    datasets: [
                        {
                            label: "My First dataset",
                            fillColor: "rgba(151,187,205,0.2)",
                            strokeColor: "rgba(151,187,205,1)",
                            pointColor: "rgba(151,187,205,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: c,
                            title: ''
                        }


                    ]
                };

            }






        }
        var opt1 = {
            animationStartWithDataset: 1,
            animationStartWithData: 1,
            animationSteps: 69,
            canvasBorders: true,
            canvasBordersWidth: 1,
            canvasBordersColor: "black",
            graphTitle: titulo,
            legend: true,
            inGraphDataShow: true,
            annotateDisplay: true,
            graphTitleFontSize: 18,
            yAxisMinimumInterval: 50,
            yAxisLabel: 'Numero Logueos',
            title: '',
            responsive: false

        };


        var myLineChart = new Chart(document.getElementById("canvas2").getContext("2d")).Line(data, opt1);

    }
    function eventosBusqueda() {

        $('#bfecha').change(function() {
            limpiar();
            index2();
        });

    }

    function setearSelects() {

        $('#saño').change(function() {
            limpiar();
            index2();
        });

    }

    function limpiar() {

        $('#canvas2').remove();
        $('#contenedor2').html('<canvas  id="canvas2" height="600" width="700"></canvas>');


    }

    function insertarTabla(aprob, den, pend) {
        
        var total = (aprob+den+pend);

        $('#tablapie').html('<table class="ui red celled table"><thead><tr><th>Estado</th><th>Numero</th><th>Porcentaje del Total</th></tr></thead>' +
                '<tbody>' +
                '<tr><td>Todas</td><td id="ntod">'+total+'</td><td>100%</td></tr>' +
                '<tr><td>Pendientes</td><td id="npend">'+pend+'</td><td>'+porcentage(pend,total)+'%</td></tr>' +
                '<tr><td>Aprobadas</td> <td id="naprob">'+aprob+'</td><td>'+porcentage(aprob,total)+'%</td> </tr>' +
                '<tr><td>Denegadas</td> <td id="nden">'+den+'</td><td>'+porcentage(den,total)+'%</td>  </tr>' +
                '</tbody> </table>');

    }
    
    function porcentage(numero, total){
        
        var porcent =  numero * 100/total ;
        var resultado = Math.round( porcent * 10 ) / 10;;
        return resultado;
    }



});