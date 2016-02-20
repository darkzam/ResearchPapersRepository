<?php

if (isset($detalles) && count($detalles)) :
    $item_per_page = 50;
    $contador = 0;
    ?>

   

<table class="ui celled table">
        <thead>
            <tr>
                <th>Id</th>
               
                <th>Codigo/Cedula</th>
                <th>Fecha Modificacion</th>
                <th>Estado</th>
                <th>Observacion</th>
            </tr>
        </thead>
        <tbody>

           <?php
            for ($i = 0; $i < count($detalles); $i++) {
                if ($contador == $item_per_page) {

                    break;
                }
                ?>
                <tr id="<?php echo 'h' . $contador; ?>">
                    <td><?php echo $detalles[$i]['id_solicitud']; ?></td>
<!--                    <td><?php //echo $detalles[$i]['upro_codigo']; ?></td>-->
                    <td><?php echo $detalles[$i]['uacc_username']; ?></td>
                    <td><?php echo $detalles[$i]['fecha_mod']; ?></td>
                    <td><?php echo $detalles[$i]['modificacion']; ?></td>
                    <td><?php echo $detalles[$i]['comentarios']; ?></td>
                </tr>

                <?php
                $contador += 1;
            };
            ?>
        </tbody>
    </table>

<?php else : ?>
    <h3>No hay cambios para esta solicitud</h3>


<?php endif; ?>

