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
    $id= $_GET["usuario_id"];
    $stu = new Student();
    $datos = $stu->searchStudent($id);

    if(isset($_POST["actualizar"])){
       
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $clave = $_POST["clave"];

        require_once("../class/Student.php");
        $stu = new Student();
        $stu->updateStudent($id, $nombre, $apellido, $email, $clave);

    }

    ?>

    <h2>Editar un estudiante</h2>
    <form action="" method="post">
<?php 
   foreach ($datos as $dato) {
?>
  
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="nombre" required value="<?php echo $dato['usuario_nombre']?>"><br>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required value="<?php echo $dato['usuario_apellido']?>"><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required value="<?php echo $dato['usuario_email']?>"><br>

    <label for="clave">clave:</label>
    <input type="text" id="clave" name="clave" required value="<?php echo $dato['usuario_clave']?>"><br>
    <?php }?>
    
    <input type="submit" name="actualizar" value="Actualizar">
    </form>
</body>
</html>