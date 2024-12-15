<?php
require_once('Connection.php');

class Reserva extends Connection {
    public function __construct() {
        parent::__construct();
    }

    public function searchPacienteXFechaHoraReserva($id_paciente, $fecha_cita, $estado, $hora_cita, $end_time) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM tb_reservas 
                WHERE (id_paciente = ? AND fecha_cita = ? AND estado = '1')
                OR (fecha_cita = ? AND hora_cita BETWEEN ? AND ? AND estado = '1')");
    
            $stmt->bind_param("issss", $id_paciente, $fecha_cita, $fecha_cita, $hora_cita, $end_time);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Recuperar los resultados
            $result = $stmt->get_result();
    
            // Verificar si se encontró algún registro
            $found = $result->num_rows > 0;
    
            // Cerrar el statement
            $stmt->close();
           
            return $found;
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    public function searchReservas() {
        try {
            $stmt = $this->con->prepare("SELECT title, start, end, 
            backgroundColor, borderColor, hora_cita, realizada
            FROM tb_reservas WHERE estado='1'");
            $stmt->execute();
            $result = $stmt->get_result();
            $reservas = $result->fetch_all(MYSQLI_ASSOC); // Traer todos los registros
         
            $stmt->close();
            return $reservas;
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    public function searchReservaMismaFechaHora($fecha, $hora) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM tb_reservas 
              WHERE fecha_cita = ? AND hora_cita = ? 
              and estado='1'");

            $stmt->bind_param("ss", $fecha, $hora);
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Verificar si se encontró algún registro
            $found = $result->num_rows > 0;
    
            // Cerrar el statement
            $stmt->close();
           
            return $found;
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    public function searchReservaPorRealizada( $fecha, $hora, $id_paciente) {
        try {
            $stmt = $this->con->prepare("SELECT realizada FROM tb_reservas 
              WHERE fecha_cita = ? AND hora_cita = ? 
              and id_paciente =? ");

            $stmt->bind_param("ssi", $fecha, $hora, $id_paciente);
    
            $stmt->execute();
            $result = $stmt->get_result();
            $realizada = $result->fetch_all(MYSQLI_ASSOC); // Traer todos los registros
         
            $stmt->close();
            return $realizada;
            
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    
    
    public function insertReserva($id_paciente, $fecha_cita, $hora_cita, $title, $start, $end, $fyh_creacion, $estado, $background, $color) {
        $estado = 1; // Estado activo por defecto
    
        // Consulta SQL corregida
        $stmt = $this->con->prepare("INSERT INTO tb_reservas 
            (id_paciente, fecha_cita, hora_cita, title, start, end, fyh_creacion, estado, backgroundColor, borderColor) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        // Corregir los parámetros y sus tipos
        $stmt->bind_param("issssssiss", $id_paciente, $fecha_cita, $hora_cita, $title, $start, $end, $fyh_creacion, $estado, $background, $color);
    
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $stmt->close();
        return true;
    }
    
    public function updateReserva($hora, $title, $fyh_actualizacion, $fecha, $title_anterior) {
        // Consulta corregida con placeholders `?` en lugar de `:`
        $stmt = $this->con->prepare(
            "UPDATE tb_reservas 
            SET hora_cita = ?, 
                title = ?,
                fyh_actualizacion = ?
            WHERE title = ? AND fecha_cita = ?"
        );
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        // Vincula los parámetros correctamente
        $stmt->bind_param("sssss", $hora, $title, $fyh_actualizacion, $title_anterior, $fecha);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $stmt->close();
        return false;
    }

    public function updateRealizadaONoRealizada($realizada, $fyh_actualizacion, $backgroundColor, $borderColor, $fecha, $hora, $id_paciente) {
        $stmt = $this->con->prepare(
            "UPDATE tb_reservas 
            SET realizada = ?,
                fyh_actualizacion = ?,
                backgroundColor = ?,
                borderColor = ?
            WHERE fecha_cita = ? AND hora_cita = ? AND id_paciente = ?"
        );
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        // Vincula los parámetros
        $stmt->bind_param(
            "isssssi", 
            $realizada, 
            $fyh_actualizacion, 
            $backgroundColor, 
            $borderColor, 
            $fecha, 
            $hora, 
            $id_paciente
        );
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    }
    
    public function changeTitleColor($background, $borderColor, $fyh_actualizacion, $fecha, $hora, $id_paciente) {
        // Consulta corregida con placeholders `?` en lugar de `:`
        $stmt = $this->con->prepare(
            "UPDATE tb_reservas 
            SET backgoundColor = ?,
                borderColor = ?,
                fyh_actualizacion = ?
            WHERE title = ?"
        );
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        // Vincula los parámetros correctamente
        $stmt->bind_param("sssssi", $background, $borderColor, $fyh_actualizacion, $fecha, $hora, $id_paciente);
    
        // Ejecuta la consulta
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $stmt->close();
        return false;
    }
    
    public function deleteReserva($fecha, $hora, $estado, $fyh_actualizacion) {
        try {
            // Preparamos la consulta
            $stmt = $this->con->prepare("UPDATE tb_reservas SET
            estado = ?,
            fyh_actualizacion = ?
            WHERE fecha_cita = ? AND hora_cita = ?");
        
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
        
            // Vinculamos los parámetros
            $stmt->bind_param("isss", $estado, $fyh_actualizacion, $fecha, $hora);        
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

    public function updateFechaReserva($fecha_inicial, $fecha, $hora_inicial, $hora, $title_nuevo, $start, $end, $fyh_actualizacion, $id_paciente) {
        // Consulta SQL con placeholders `?`
       
        echo "Fecha Inicial: " . $fecha_inicial . "<br>";
        echo "Fecha Nueva: " . $fecha . "<br>";
        echo "Hora Inicial: " . $hora_inicial . "<br>";
        echo "Hora Nueva: " . $hora . "<br>";
        echo "Title Nuevo: " . $title_nuevo . "<br>";
        echo "Start: " . $start . "<br>";
        echo "End: " . $end . "<br>";
        echo "Paciente ID: " . $id_paciente . "<br>";
       
        $stmt = $this->con->prepare(
            "UPDATE tb_reservas SET 
            fecha_cita = ?, 
            hora_cita = ?, 
            title = ?, 
            start = ?, 
            end = ?, 
            fyh_actualizacion = ? 
            WHERE fecha_cita = ? AND hora_cita = ? AND id_paciente = ?"
        );
        // Verificar si la consulta fue preparada correctamente
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        // Vincular los parámetros
        $stmt->bind_param(
            "ssssssssi", 
            $fecha,            // Nueva fecha
            $hora,             // Nueva hora
            $title_nuevo,      // Nuevo título
            $start,            // Nueva hora de inicio
            $end,              // Nueva hora de fin
            $fyh_actualizacion, // Fecha y hora de actualización
            $fecha_inicial,    // Fecha inicial
            $hora_inicial,     // Hora inicial
            $id_paciente       // ID del paciente
        );
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Si la consulta fue exitosa
        } else {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $stmt->close();
        return false; // Devuelve false si algo salió mal
    }
    
}
    


    
    
    
    
    
    

