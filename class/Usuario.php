<?php
require_once('Connection.php');

class Usuario extends Connection{
    public function __construct(){
        //utilizar la con para tomar todos los valores
        parent::__construct();
    }
    public function searchUser($email) {
        try {
            // Preparar la consulta con un marcador de posición
            $stmt = $this->con->prepare("SELECT * FROM tb_usuarios WHERE email = ?");
            
            // Enlazar el parámetro
            $stmt->bind_param("s", $email);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Recuperar los resultados
            $result = $stmt->get_result();
            
            // Verificar si se encontró algún registro
            $found = $result->num_rows > 0;
            
            // Cerrar el statement
            $stmt->close();
            
            return $found; // Devuelve true si hay registros, false si no
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    
    public function insertUser($email, $password, $estado, $fechaHora) {

        $stmt = $this->con->prepare("INSERT INTO tb_usuarios (email, password_user, estado, fyh_creacion) VALUES (?,?,?, ?)");
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        $stmt->bind_param("ssis", $email, $password, $estado, $fechaHora);
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $stmt->close();
        return true;
    }
}