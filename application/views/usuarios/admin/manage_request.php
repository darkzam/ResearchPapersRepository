


<?php
if (isset($solicitudes) && count($solicitudes)) :
    $item_per_page = $regmax;
    $contador = 0;
    ?>



    <table class="ui red celled table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Codigo/Cedula</th>
                <th>Ficha</th>
                <th>Fecha Creacion</th>
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
                <tr id="<?php echo '' . $contador; ?>">
                    <td id="pid"><?php echo $solicitudes[$i]['id']; ?></td>
                    <td><?php echo $solicitudes[$i]['uacc_username']; ?></td>
                    <td><?php echo $solicitudes[$i]['id_ficha']; ?></td>
                    <td><?php echo $solicitudes[$i]['fecha']; ?></td>
                    <td><?php echo $solicitudes[$i]['estado']; ?></td>
                    <td><?php echo $solicitudes[$i]['paginas']; ?></td>
                    <td><?php echo $solicitudes[$i]['comentarios']; ?></td>
                </tr>

                <?php
                $contador += 1;
            }
            ?>
        </tbody>
    </table>

    <div id="divpag" >  <?php
        /*
          //crear links
          //break total records into pages
          $pages = ceil(count($solicitudes) / $item_per_page);
          //create pagination
          $pagination = '';
          if ($pages > 1) {
          $pagination .= '<ul id="paginacion" class="paginate">';
          for ($i = 1; $i < $pages + 1; $i++) {
          $pagination .= '<li><button class="paginate_click" id="' . $i . '-page">' . $i . '</button></li>';
          }
          $pagination .= '</ul>';
          }
          echo $pagination; */
        //echo 'numero registros traidos'.count($solicitudes);
        ?>
    </div> 
    <div id="divpag2" >
        <?php
        if (count($solicitudes) > $regmax) {

            if ($fila > 0) {
                echo '<button class="ui tiny left labeled icon button" id="previous">'
                .'<i class="left arrow icon"></i>'
                        .'</button>';
            }
            echo '<button class="ui tiny right labeled icon button" id="next">'
            . '<i class="right arrow icon"></i>'
                    . '</button>';
        } else if (count($solicitudes) <= $regmax && $fila > 0) {

            echo '<button class="ui tiny left labeled icon button" id="previous">'
            . '<i class="left arrow icon"></i>'
                    .'</button>';
        }
        ?>

    </div>


<?php else : ?>
    <h3>No hay solicitudes pendientes</h3>


<?php endif; ?>