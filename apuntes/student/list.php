<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <title>Listado</title>

</head>
<body>
    <?php 
    //instancio la clase student
    require_once("../class/Student.php");
    $stu = new Student();
    $liststudents = $stu->getStudent0();
    ?>
<a href="add.php" class="btn btn-primary">Agregar</a>
    <table class="table table-striped">

        <thead>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Clave</th>
            <th>Acción</th>
        </thead>
        <tbody>
            <?php foreach($liststudents as $student):?>
                <tr>
                    <td><?php echo $student['usuario_nombre'];?></td>
                    <td><?php echo $student['usuario_apellido'];?></td>
                    <td><?php echo $student['usuario_email'];?></td>
                    <td><?php echo $student['usuario_clave'];?></td>
                    <td>
                        <a href="edit.php?usuario_id=<?php echo $student['usuario_id'];?>">Editar</a>
                        <a href="delete.php?usuario_id=<?php echo $student['usuario_id'];?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
        echo "<div class='alert alert-success'>$msg</div>";
    }
    ?>
</body>
</html>