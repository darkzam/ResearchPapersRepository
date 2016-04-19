

<div class="three fields">
    <div class="field"><label>Id</label>
        <input readonly="" type="text" id="idsolicit" value="<?php echo $solicitud['Id'] ?>" >
    </div>
    <div class="field"><label>Estado</label>
        <input readonly="" type="text" id="estad" value="<?php echo $solicitud['Estado'] ?>" >
    </div>
    <div class="field"><label>Paginas</label>
        <input readonly="" type="text" id="pags" value="<?php echo $solicitud['Paginas'] ?>" >

    </div>
</div>

<div class="two fields">
    <div class="field"><label>Nombre</label>
        <input readonly="" type="text" id="nombre" value="<?php echo $user['upro_first_name'] . " " . $user['upro_last_name']; ?>" >
    </div>
    <div class="field"><label>Codigo</label>
        <input readonly="" type="text" id="codigo" value="<?php echo $user['uacc_username'] ?>" >


    </div>
</div>
<div class="two fields">
    <div class="field"><label>Email</label>
        <input readonly="" type="text" id="email" value="<?php echo $user['uacc_email'] ?>" >


    </div>
    <div class="field"><label>Telefono</label>
        <input readonly="" type="text" id="tel" value="<?php echo $user['upro_phone'] ?>" >


    </div>
</div>
<div class="two fields">
    <div class="field">
        <label>Programa Academico</label>


        <input readonly type="text" id="prog" value="<?php
        foreach ($programas as $programa) {

            if ($user['upro_programa'] === $programa['id']) {
                echo $programa['codigo'] . '-' . $programa['nombre'];
            }
        }
        ?>" >
    </div>
    <!--
        <div class="field"><label>Programa Academico</label>
            <input readonly="" type="text" id="prog" value="<?php echo $user['upro_programa'] ?>" >
        </div>-->
    <div class="field"><label>Sede</label>
        <input readonly="" type="text" id="tel" value="<?php echo $user['upro_sede'] ?>" >


    </div>

</div>

<div class="field">
    <label>Tesis A Solicitar</label>
    <input readonly="" type="text" id="title" value="<?php echo $tesis['Titulo']; ?>" >
</div>
















