

<?php
if (isset($tesis) && count($tesis)) :
    $item_per_page = $regmax;
    $contador = 0;
    ?>

    <table class="ui red celled table table-hover">


        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Director</th>
                <th>Año</th>
                <th>Palabras Clave</th>
                <th>Programa</th>
    <!--                <th>Palabras Clave</th>-->
    <!--                <th>Resumen</th>-->
            </tr>
        </thead>
        <tbody>

            <?php
            for ($i = 0; $i < count($tesis); $i++) {
                if ($contador == $item_per_page) {

                    break;
                }
                ?>
                <tr id="<?php echo '' . $contador; ?>">
                    <td id="pid"><?php echo $tesis[$i]['Id']; ?></td>
                    <td><?php echo $tesis[$i]['Titulo']; ?></td>
                    <td><?php echo $tesis[$i]['Autor']; ?></td>
                    <td><?php echo $tesis[$i]['Director']; ?></td>
                    <td><?php echo $tesis[$i]['Año']; ?></td>
                    <td><?php echo $tesis[$i]['Keywords']; ?></td>
                    <td><?php echo $tesis[$i]['Programa']; ?></td>
                           <!--                    <td><?php // echo $tesis[$i]['Resumen'];           ?></td>-->
                </tr>

                <?php
                $contador += 1;
            };
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
        if (count($tesis) > $regmax) {

            if ($fila > 0) {
                echo '<button class="ui tiny left labeled icon button" id="previous">'
                . '<i class="left arrow icon"></i>'
                . '</button>';
            }
            echo '<button class="ui tiny right labeled icon button" id="next">'
            . '<i class="right arrow icon"></i>'
            . '</button>';
        } else if (count($tesis) <= $regmax && $fila > 0) {

            echo '<button class="ui tiny left labeled icon button" id="previous">'
            . '<i class="left arrow icon"></i>'
            . '</button>';
        }
        ?>

        <!--        <button id="sgte" class="ui right labeled icon button">
                    <i class="right arrow icon"></i>
                    Siguiente
                </button>-->

    </div>


<?php else : ?>
    <h3>No hay fichas con ese parametro</h3>


<?php endif; ?>