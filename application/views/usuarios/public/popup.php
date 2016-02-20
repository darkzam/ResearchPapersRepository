
<input name="idtg" value="<?php echo $ficha['Id'] ?>" hidden=""/>
    <div class="field">
        <label>Titulo</label>
        <input readonly id="titulo" value="<?php echo $ficha['Titulo'] ?>"/>
    </div>

    <div class="field">
        <label>Autor</label>
        <input readonly id="autor" value="<?php echo $ficha['Autor'] ?>"/>  

    </div>

    <div class="field">
        <label>Palabras Clave</label>
        <input readonly id="resumen" value="<?php echo $ficha['Keywords'] ?>"/>    

    </div>

    <div class="ui two fields">

        <div class="field">
            <label>Director</label>
            <input readonly id="director" value="<?php echo $ficha['Director'] ?>"/>   

        </div>

        <div class="field">
            <label>Año</label>
            <input readonly id="año" value="<?php echo $ficha['Año'] ?>"/>   

        </div>
    </div>
   
    
        <div class="field">
            <label>Resumen</label>

            <textarea class="justifyText" readonly=""  id="keywords"><?php echo $ficha['Resumen'] ?></textarea>  


        </div>
    





