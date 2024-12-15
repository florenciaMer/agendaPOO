<?php
require_once('../../class/Usuario.php');

try {
    // Capturar los datos del formulario
    $email = $_POST['email'];
    $password_user = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    $estado = 1;
    $user = new Usuario();
    $result = $user->searchUser($email);

    session_start();
    if (!$result) {
        if ($password_user !== $password_repeat) {
            $_SESSION['mensaje']= "Error las contraseñas no coinciden";
            $_SESSION['icono'] = "error";
            echo "<script>
            window.history.back(); // Regresa a la página anterior
            </script>";
        }else{
    
        // Encriptar la contraseña
        $password = password_hash($password_user, PASSWORD_DEFAULT);
    
        // Crear instancia del usuario y ejecutar inserción
        
        $user->insertUser($email, $password, $estado, $fechaHora);
    
        // Redirigir a index.php si la inserción es exitosa
        header("Location: ../../index.php");
        exit();
        } // Asegurarse de detener la ejecución después de redirigir
    } else {
       
        $_SESSION['mensaje']= "Error ya existe un usuario con ese email en la base de datos";
        $_SESSION['icono'] = "error";
         echo "<script>
        window.history.back(); // Regresa a la página anterior
        </script>";
    }
    
    // Validar que las contraseñas coincidan
   
} catch (Exception $e) {
    // Mostrar mensaje de error en caso de fallo
    echo "<script>
        alert('Error: " . $e->getMessage() . "');
        window.history.back(); // Regresa a la página anterior
    </script>";
}
