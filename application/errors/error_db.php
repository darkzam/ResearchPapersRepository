<!DOCTYPE html>
<html lang="en">
<head>
<title>Error de Base de Datos</title>
    <link rel="stylesheet" href="../includes/css/semantic.min.css">
    <link rel="stylesheet" href="../includes/css/estiloError.css">
</head>
<body>

	<div id="cabecera">
           	<div id="menu" class="ui borderless menu" >
     <div class="item">
        <img class="ui image" src="../includes/images/univallepalmira.png"/>
    </div>
    <div class="right menu">
        <div class="item">
            <img class="ui medium right floated image" src="../includes/images/manuelita2.png"/>
        </div>
    </div>
		</div> 
    </div>


	 <div class="ui three column centered grid">

	

	 <div class="column">
		<div id="container" class="ui segment">
			<h1 class="ui centered header"><?php echo $heading; ?></h1>
			<div class="ui divider"></div>
			<?php echo $message; ?>
		</div>
	</div>
	</div>
</body>
    
</html>