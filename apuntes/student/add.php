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

    if (isset($_POST['registrar'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $clave = $_POST['clave'];
        require_once("../class/Student.php");
        $stu = new Student();
        $stu->insertStudent($nombre, $apellido, $email, $clave);
        header("Location: list.php");
    }
    ?>

    <h2>Agregar nuevo estudiante</h2>
    <form action="" method="post">

    <label for="name">Nombre:</label>
    <input type="text" id="name" name="nombre" required><br>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="clave">clave:</label>
    <input type="text" id="clave" name="clave" required><br>

    <input type="submit" name="registrar" value="Registrar">
    </form>
</body>
</html>