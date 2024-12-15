<?php

require_once('../../class/Login.php');

$login = new Login();
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';


// Buscar al usuario
$user = $login->searchUser($email);

if ($user) {
    $email_tabla = $user['email'];
    $password_tabla = $user['password_user'];
    $estado_tabla = $user['estado'];

    //valido la password convirtiendola primero

    $verify_password = password_verify($password, $password_tabla);
   session_start();
    if ($verify_password) {
        $_SESSION['sesion_email']= $email;
        $_SESSION['mensaje']= "Bienvenido al sistema";
        $_SESSION['icono'] = "success";
        header("Location: ../../index.php");
    } else {
        $_SESSION['mensaje']= "Las credenciales no coinciden";
        $_SESSION['icono'] = "error";
        header("Location: ../../view/login/index.php"); 
    }
    
}

