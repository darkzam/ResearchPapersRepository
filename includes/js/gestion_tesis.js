
$(document).on('ready', function () {


    $('.ui.accordion').accordion();


    $('#userfile').on('change', function (e) {
        console.log(e.target.files[0]);

        if (e.target.files[0].name !== '') {

            $('#marvel').html('<p>' + e.target.files[0].name + '</p><i class="file icon"></i>');

        }
    });

});