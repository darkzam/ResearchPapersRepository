
<?php
if (isset($solicitudes) && count($solicitudes)) :
    $item_per_page = $regmax;
    $contador = 0;
    ?>

    <table class="ui red celled table table-hover">
        <thead>
            <tr>
    <!--                <th hidden="true">Id</th>-->
                <th>Usuario</th>
                <th>Titulo</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Paginas</th>
                <th>Observacion</th>

            </tr>
        </thead>
        <tbody>

            <?php
            for ($i = 0; $i < count($solicitudes); $i++) {
                if ($contador == $item_per_page) {

                    break;
                }
                ?>
                <tr id="<?php echo '' . $contador; ?>" class="justifyText">
        <!--                    <td hidden="true" id="pid"><?php //echo $solicitudes[$i]['Id'];   ?></td>-->
                    <td class="single line"><?php echo $user['upro_first_name'] . " " . $user['upro_last_name']; ?></td>
                    <td><?php echo $solicitudes[$i]['titulo']; ?></td>
                    <td class="single line"><?php echo $solicitudes[$i]['fecha']; ?></td>
                    <td><?php echo $solicitudes[$i]['estado']; ?></td>
                    <td><?php echo $solicitudes[$i]['paginas']; ?></td>
                    <td><?php echo $solicitudes[$i]['comentarios']; ?></td>
                </tr>

                <?php
                $contador += 1;
            };
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="single line">
                    
                        <?php
                        if (count($solicitudes) > $regmax) {

                            if ($fila > 0) {
                                echo '<button class="ui tiny left labeled icon button" id="previous">'
                                . '<i class="left arrow icon"></i>'
                                . '</button>';
                            }
                            echo '<button class="ui tiny right labeled icon button" id="next">'
                            . '<i class="right arrow icon"></i>'
                            . '</button>';
                        } else if (count($solicitudes) <= $regmax && $fila > 0) {

                            echo '<button class="ui tiny left labeled icon button" id="previous">'
                            . '<i class="left arrow icon"></i>'
                            . '</button>';
                        }
                        ?>
                  
                </td>
            </tr>
        </tfoot>
    </table>



<?php else : ?>
    <h3>No has realizado ninguna solicitud</h3>


<?php endif; ?>