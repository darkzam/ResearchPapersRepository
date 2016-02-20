


<div class="two fields"> 
    <div class=" field"> 
        <label>Id: </label>
        <input readonly="" name="identificacion" type="text" value="<?php echo $tesis['Id'] ?>" required="true"/>
    </div>
    <div class=" field"> 
        <label>Programa Academico: </label>
        <input name="programa" type="text" value="<?php echo $tesis['Programa'] ?>" required="true"/>


    </div>
    <?php
    
//    $string = $tesis['path'];
//    $string = urldecode($string);
//    $path_parts = explode('/', $string);

    ?>
<!--    <div class="field">
        <label>Programa Academico: </label>
        <select name="programa" required>
            <option selected value="0">ADMINISTRACIÓN DE EMPRESAS</option>
            <option value="1">CONTADURÍA PÚBLICA</option>
            <option value="2">EDU FISICA</option>
            <option value="3">INGENIERIA INDUSTRIAL</option>
            <option value="4">PSICOLOGIA</option>
        </select>
    </div>-->

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



<div class="field">
    <label for="userfile" class="ui icon button">Subir Nuevo Archivo 
        <i class="file icon"></i>
    </label>
    <input id="userfile" style="display:none" type="file" name="userfile" size="20" />
</div>


<input class="ui button" type="submit" value="Actualizar" />




