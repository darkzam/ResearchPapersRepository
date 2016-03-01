

<?php
if (isset($resultados) && count($resultados)) :
    $item_per_page = $regmax;
    $contador = 0;
  
    ?>
    <table class="ui padded red table table-hover">
        <thead>
            <tr>
                <th hidden="true">Id</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Año</th>
                <th>Director</th>
                <th>Palabras Claves</th>  
                <th>Programa</th>  
            </tr>
        </thead>
        <tbody>
           
            <?php
            for ($i = 0; $i < count($resultados); $i++) {
                if ($contador == $item_per_page) {

                    break;
                }
                ?>
            <tr id="<?php echo '' . $contador; ?>" class="justifyText" >
                    <td id="pid" hidden="true"><?php echo $resultados[$i]['Id']; ?></td>
                    <td><?php echo $resultados[$i]['Titulo']; ?></td>
                    <td><?php echo $resultados[$i]['Autor']; ?></td>
                    <td><?php echo $resultados[$i]['Año']; ?></td>
                    <td><?php echo $resultados[$i]['Director']; ?></td>
                    <td><?php echo $resultados[$i]['Keywords']; ?></td>
                    <td><?php
                        foreach ($programas as $programa) {
                            if ($resultados[$i]['Programa'] === $programa['id']) {
                                echo $programa['codigo'] . "\n" . $programa['nombre'];
                                break;
                            }
                        }
                       
                        ?>
                    </td>
                </tr>
               
                <?php
                $contador += 1;
            };
            ?>
        </tbody>
    </table>

    <div id="divpag2" >
        <?php
        if (count($resultados) > $regmax) {

            if ($fila > 0) {
                echo '<button class="ui tiny left labeled icon button" id="previous">'
                .'<i class="left arrow icon"></i>'
                        .'</button>';
            }
            echo '<button class="ui tiny right labeled icon button" id="next">'
            . '<i class="right arrow icon"></i>'
                    . '</button>';
        } else if (count($resultados) <= $regmax && $fila > 0) {

            echo '<button class="ui tiny left labeled icon button" id="previous">'
            . '<i class="left arrow icon"></i>'
                    .'</button>';
        }
        ?>

    </div>  


<?php else : ?>
    <h3>No se encontraron resultados.</h3>


<?php endif; ?>