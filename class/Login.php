
<?php
require_once('Connection.php');

class Login extends Connection{
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
        
            // Obtener un único resultado como array asociativo
            $user = $result->fetch_assoc();
        
            // Cerrar el statement
            $stmt->close();
        
            return $user; // Devuelve el usuario como un array asociativo o `null`
        
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    
    
}