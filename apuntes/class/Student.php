<?php

require_once('connection.php');
class Student extends Connection{
    public function __construct(){
        //utilizar la con para tomar todos los valores
        parent::__construct();
    }
    public function getStudent0(){
        $result = $this->con->query("SELECT * FROM usuarios");
        //convierto a array $result
        $liststudent = $result->fetch_all(MYSQLI_ASSOC);
        return $liststudent;
    }

    public function insertStudent($nombre, $apellido, $email, $clave) {
        $stmt = $this->con->prepare("INSERT INTO usuarios (usuario_nombre, usuario_apellido, usuario_email, usuario_clave) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $clave);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $stmt->close();
        return true;
    }
    
    public function deleteStudent($id) {
        try {
            // Validar que el ID sea un número
            if (!is_numeric($id)) {
                throw new Exception("El ID proporcionado no es válido.");
            }
    
            // Preparar la consulta
            $stmt = $this->con->prepare("DELETE FROM usuarios WHERE usuario_id = ?");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->con->error);
            }
    
            // Vincular el parámetro
            $stmt->bind_param("i", $id);
            
            // Ejecutar la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
    
            // Verificar si realmente se eliminó un registro
            if ($stmt->affected_rows === 0) {
                throw new Exception("No se encontró un estudiante con el ID proporcionado.");
            }
    
            // Cerrar el statement
            $stmt->close();
    
            // Mensaje de éxito
            $msg = "Estudiante eliminado correctamente";
            header("Location: ../student/list.php?msg=" . urlencode($msg));
            exit;
    
        } catch (Exception $e) {
            // Mensaje de error detallado para depuración
            $msg = "Error al eliminar: " . $e->getMessage();
            error_log($msg); // Registrarlo en el log
            header("Location: ../student/list.php?msg=" . urlencode($msg));
            exit;
        }
    }

    public function searchStudent($id) {
        try {
            // Preparar la consulta con un marcador de posición
            $stmt = $this->con->prepare("SELECT * FROM usuarios WHERE usuario_id = ?");
    
            // Enlazar el parámetro
            $stmt->bind_param("i", $id); // 'i' indica que el parámetro es un entero (int)
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Recuperar los resultados
            $result = $stmt->get_result(); // Obtener el resultado de la consulta
    
            // Recuperar todos los resultados en un array asociativo
            $list = $result->fetch_all(MYSQLI_ASSOC);
    
            // Cerrar el statement
            $stmt->close();
    
            return $list;
    
        } catch (Exception $e) {
            // Manejo de errores
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }


    public function updateStudent($id, $nombre, $apellido, $email, $clave) {
        // Preparamos la consulta de actualización
        $stmt = $this->con->prepare("UPDATE usuarios SET usuario_nombre = ?, usuario_apellido = ?, usuario_email = ?, usuario_clave = ? WHERE usuario_id = ?");
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        // Vinculamos los parámetros
        $stmt->bind_param("ssssi", $nombre, $apellido, $email, $clave, $id); // 'i' es para el ID (entero) y 's' para las cadenas
    
        // Ejecutamos la consulta
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        // Cerramos la declaración
        $stmt->close();
    
        // Mensaje de éxito
        $msg = "El registro fue actualizado correctamente";
        header("Location: list.php?msg=" . urlencode($msg)); // Asegúrate de usar `urlencode` para los parámetros en la URL
        exit;
    }
    
    
    
    
    }
    
    

