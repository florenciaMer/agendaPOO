<?php
require_once("../class/Student.php");

try {
    $stu = new Student();

    // Validar que el ID se haya recibido correctamente
    if (!isset($_GET['usuario_id']) || !is_numeric($_GET['usuario_id'])) {
        throw new Exception("ID de usuario no válido o no proporcionado.");
    }

    $id = (int) $_GET['usuario_id']; // Convertir a entero para evitar problemas
    $stu->deleteStudent($id);

} catch (Exception $e) {
    // Manejo de errores
    $msg = "Error: " . $e->getMessage();
    header("Location: ../student/list.php?msg=" . urlencode($msg));
    exit;
}
