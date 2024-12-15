<?php
require_once('Connection.php');

class Paciente extends Connection {
    public function __construct() {
        parent::__construct();
    }

    public function searchPacientes() {
        try {
            $stmt = $this->con->prepare("SELECT * FROM tb_pacientes WHERE estado = 1 ORDER BY nombre");
            $stmt->execute();
            $result = $stmt->get_result();
            $pacientes = $result->fetch_all(MYSQLI_ASSOC); // Traer todos los registros
            $stmt->close();
            return $pacientes;
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    public function searchPaciente($id) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM tb_pacientes WHERE id_paciente = ?");
    
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
    
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if (!$result) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
    
            $paciente = $result->fetch_assoc(); // Obtener el resultado
            $stmt->close();
    
            // Verificar si se obtuvo algún resultado
            if (!$paciente) {
                throw new Exception("No se encontró ningún paciente con ID: $id");
            }
    
            return $paciente;
    
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function searchPacienteByEmailPaciente($email, $id_paciente) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM tb_pacientes WHERE email = ? AND id_paciente != ?");
    
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
    
            $stmt->bind_param("si", $email, $id_paciente);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if (!$result) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
    
            $paciente = $result->fetch_assoc(); // Obtener el resultado
            $stmt->close();
    
            // Verificar si se obtuvo algún resultado
            if ($paciente) {
                $paciente = true;
            }else{
                $paciente = false;
            }
    
            return $paciente;
    
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function searchIdPacienteByNombreApellido($nombre, $apellido) {
        try {
            $stmt = $this->con->prepare("SELECT id_paciente FROM tb_pacientes 
            WHERE nombre = ?
            AND apellido = ?");
    
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
    
            $stmt->bind_param("ss", $nombre, $apellido);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if (!$result) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
    
            $paciente = $result->fetch_assoc(); // Obtener el resultado
            $stmt->close();
    
            // Verificar si se obtuvo algún resultado
            if (!$paciente) {
                throw new Exception("No se encontró ningún paciente");
            }
    
            return $paciente;
    
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function insertPaciente($nombre, $apellido, $direccion, $telefono, $celular, $email, $fyh_creacion) {
        $estado = 1; // Estado activo por defecto
        
        // Consulta SQL corregida para incluir todos los campos
        $stmt = $this->con->prepare("INSERT INTO tb_pacientes (nombre, apellido, direccion, telefono, celular, email, estado, fyh_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
        
        // Corregir los parámetros y sus tipos
        $stmt->bind_param("ssssssis", $nombre, $apellido, $direccion, $telefono, $celular, $email, $estado, $fyh_creacion);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        $stmt->close();
        return true;
    }

    
    public function updatePaciente($nombre, $apellido, $direccion, $telefono, $celular, $email, $fyh_actualizacion, $estado, $id_paciente) {
        // Preparamos la consulta de actualización
        $stmt = $this->con->prepare("UPDATE tb_pacientes SET nombre = ?, apellido = ?, direccion = ?, telefono = ?, celular = ?,  email = ?,
        fyh_actualizacion = ?, estado = ? WHERE id_paciente = ?");
        
        
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
        
        // Vinculamos los parámetros correctamente (en el tipo de datos 's' para string y 'i' para integer)
        $stmt->bind_param("sssiissii", $nombre, $apellido, $direccion, $telefono, $celular, $email,$fyh_actualizacion, $estado,
        $id_paciente);
        
        // Ejecutamos la consulta
        if ($stmt->execute()) {
            // Si la consulta se ejecuta correctamente, devolvemos true
            $stmt->close();
            return true;
        } else {
            // Si hay un error en la ejecución, lanzamos una excepción
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        $stmt->close();
        return false;  // Devolver false si algo salió mal
    }
    public function searchValoresDePaciente($id) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM tb_valores WHERE id_paciente_valor = ?");
    
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
    
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Verificar si se encontró algún registro
            $found = $result->num_rows > 0;
            
            // Cerrar el statement
            $stmt->close();
            
            return $found; // Devuelve true si hay registros, false si no
    
            // Verificar si se obtuvo algún resultado
               
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    public function searchReservasDePaciente($id, $fechaHora) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM tb_reservas WHERE id_paciente = ? AND fecha_cita >?");
    
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
    
            $stmt->bind_param("is", $id, $fechaHora);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Verificar si se encontró algún registro
            $found = $result->num_rows > 0;
            
            // Cerrar el statement
            $stmt->close();
            
            return $found; // Devuelve true si hay registros, false si no
    
            // Verificar si se obtuvo algún resultado
               
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    public function deletePaciente($id, $estado) {
        try {
            // Preparamos la consulta
            $stmt = $this->con->prepare("UPDATE tb_pacientes SET estado = ? WHERE id_paciente = ?");
        
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
        
            // Vinculamos los parámetros
            $stmt->bind_param("ii", $estado, $id);
        
            // Ejecutamos la consulta
            if ($stmt->execute()) {
                $stmt->close();
                return true;  // Devolvemos true si la consulta fue exitosa
            } else {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    
}
    


    
    
    
    
    
    

