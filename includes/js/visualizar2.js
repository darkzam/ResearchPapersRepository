
var pdfFile;
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

PDFJS.disableStream = true;
//PDFJS.disableWorker=true;
var rendering = false;

var totalpaginas = 0;

crearFrame();

$(function() {
	$(this).bind("contextmenu", function(e) {
		e.preventDefault();
	});
});

function crearFrame() {
    $("#spiner").prop("hidden", false);
    var id = $('#idtg').val();
    var pag = $('#pagina').val();


    $.ajax({
        'dataType': "json",
        'url': 'http://localhost/SistemaConsultas/usuario_public/pdfajax',
        'type': 'POST', //the way you want to send data to your URL
        'data': {'idtg': id, 'pagina': pag},
        'success': function(data) { //probably this request will return anything, it'll be put in var "data"

            if (data) {
             //   console.log(data);
                if (data['existe']) {
                    getPdf(data['path']);
                    totalpaginas = data['npaginas'];
                    $("#page_count").text(totalpaginas);
                    eventos();
                    $("#spiner").prop("hidden", true);
                }
            }

        },
        error: function(e) {

         //   alert("error");
            console.log(e);

        }
    });

}

function getPdf(url) {

    PDFJS.getDocument(url).then(function(pdf) {
        pdfFile = pdf;

        openPage();

    }, function(error) {
        console.error("Error: " + error);
    });

}
var openPage = function() {

    pdfFile.getPage(1).then(function(page) {

        viewport = page.getViewport(canvas.width / page.getViewport(1.0).width);
        canvas.height = viewport.height;

        var renderContext = {
            canvasContext: context,
            viewport: viewport
        };

        var pageRendering = page.render(renderContext);

        var completeCallback = pageRendering.internalRenderTask.callback;
        pageRendering.internalRenderTask.callback = function(error) {
            //Step 2: what you want to do before calling the complete method 
            //  alert("awdawdaw");
            completeCallback.call(this, error);
            //Step 3: do some more stuff

        };

    });
};





function eventos() {

    $('#sgte').unbind('click');
    $('#sgte').on('click', function() {


        pagina = $('#pagina').val();
        valor = parseInt(pagina);
        if (valor < totalpaginas) {
            valor = valor + 1;
            $('#pagina').val(valor);

            $('#page_num').text(valor);

            crearFrame();
        }

    });

    $('#atras').unbind('click');
    $('#atras').on('click', function() {

        pagina = $('#pagina').val();
        valor = parseInt(pagina);
        if (valor > 1) {
            valor = valor - 1;
            $('#pagina').val(valor);

            $('#page_num').text(valor);

            crearFrame();
        }
    });

    $('#ir').unbind('click');
    $('#ir').on('click', function() {
        pagina = $('#pagina').val();
        $('#page_num').text(pagina);
        crearFrame();
    });

}




///SPINER



