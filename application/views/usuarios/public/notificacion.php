
<?php if( $notificacion){ ?>
<div class="ui positive message">
    <div class="header">
         Solicitud Creada!
    </div>
        <p>Espere respuesta del administrador dentro de 5 dias habiles a partir de la fecha. </p>
    </div>

<?php } else{ ?>
<div class="ui negative message">
    <div class="header">
        Error: Solicitud Duplicada
    </div>
        <p>Usted ya realizo una solicitud para este trabajo de grado, por favor espere su respuesta. </p>
    </div>  
<?php } ?>
