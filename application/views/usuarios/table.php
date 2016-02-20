<?php

if(isset($title) && !empty($title)) : ?>
    <h1><?php echo $title; ?></h1>
<?php endif; ?>
 
<?php if(isset($fichas) && count($fichas)) : ?>
    <table>
        <thead>
            <tr>
            	<th>Id</th>
            	<th>Titulo</th>
            	<th>Autor</th>
                <th>Año</th>
                <th>Director</th>
                <th>Palabras Claves</th>  
            </tr>
        </thead>
        <tbody>
            <?php foreach($fichas as $row) : ?>
                <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo $row['Titulo']; ?></td>
                    <td><?php echo $row['Autor']; ?></td>
                    <td><?php echo $row['Año']; ?></td>
                    <td><?php echo $row['Director']; ?></td>
                    <td><?php echo $row['Keywords']; ?></td>
                  
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <h3>No results found!</h3>
<?php endif; ?>