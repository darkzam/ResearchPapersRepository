


<div class="two fields"> 
    <div class=" field"> 
        <label>Id: </label>
        <input readonly="" name="identificacion" type="text" value="<?php echo $tesis['Id'] ?>" required="true"/>
    </div>
    <!--    <div class=" field"> 
            <label>Programa Academico: </label>
            <input name="programa" type="text" value="<?php //echo $tesis['Programa']           ?>" required="true"/>
        </div>-->

    <div class="field">
        <label>Programa Academico: </label>
        <select name="programa" required>
            <?php
            $seleccionado = false;
            foreach ($programas as $programa) {
                ?>

                <?php
                if ($tesis['Programa'] === $programa['id']) {
                    $seleccionado = true;
                }
                ?>

                <option <?php
                if ($seleccionado) {
                    echo "selected";
                }
                ?> value="<?php echo $programa['id']; ?>">
                        <?php
                        if ($seleccionado) {
                            echo "**";
                        }
                        echo $programa['codigo'] . "-" . $programa['nombre'];
                        if ($seleccionado) {
                            echo "**";
                        }
                        ?>
                </option>

                <?php
                $seleccionado = false;
            }
            ?>
        </select>
    </div>

</div>

<div class="two fields">
    <div class="field">
        <label>Director(es): </label>
        <input type="text" name="director" value="<?php echo $tesis['Director'] ?>" required="true"/>
    </div>
    <div class="field">
        <label>Año de Publicacion: </label>
        <input type="text" name="ano" value="<?php echo $tesis['Año'] ?>" required="true"/>
    </div>

</div>
<div class="field">
    <label>Autor(es): </label>
    <input type="text" name="autor" value="<?php echo $tesis['Autor'] ?>" required="true"/>
</div>

<div class="field"> 
    <label>Titulo: </label>
    <input type="text" name="titulo" value="<?php echo $tesis['Titulo'] ?>" required="true"/>
</div>


<div class="field">
    <label>Palabras Claves: </label>
    <input type="text" name="keywords" value="<?php echo $tesis['Keywords'] ?>" required="true"/>
</div>




<div class="field">
    <div class="ui accordion">
        <div class="title">
            <i class="dropdown icon"></i>
            <strong>Resumen</strong> 
        </div>

        <div class="content">
            <textarea name="resumen" value="" required="true"><?php echo $tesis['Resumen'] ?></textarea>
        </div>

    </div>
</div>

<?php
$string1 = $tesis['Path'];
$string2 = urldecode($string1);
?>

<div class="field">
    <label>Archivo pdf: </label>
    <div><?php echo $string2; ?></div>
</div>



<div class="field">
    <label id="marvel" for="userfile" class="ui icon button elegance">Subir Nuevo Archivo 
        <i class="file icon"></i>
    </label>
    <input id="userfile" style="display:none" type="file" name="userfile" size="20" />
</div>


<input class="ui button" type="submit" value="Actualizar" />




