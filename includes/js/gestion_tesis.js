
$(document).on('ready', function () {


    $('.ui.accordion').accordion();

   
   $('#userfile').on('change', function(e){
       console.log(e.target.files[0].name);
       
       if(e.target.files[0].name !== ''){
           
           $('#marvel').html(e.target.files[0].name + '<i class="file icon"></i>');
           
       }
   });

});