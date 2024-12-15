<?php
require_once('Connection.php');

class Factura extends Connection {
    public function __construct() {
        parent::__construct();
    }

    public function setCitasNoFacturadas($citas_no_facturadas, $placeholders) {
        try {
            // Iniciar una transacción para garantizar consistencia
            $this->con->begin_transaction();
    
            // Preparar la consulta SQL para actualizar el campo "estado"
            $stmt = $this->con->prepare(
                "UPDATE tb_reservas SET facturado = 1 WHERE id_reserva IN ($placeholders)"
            );
    
            // Verificar si la consulta se preparó correctamente
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->con->error);
            }
    
            // Construir el tipo de parámetros para bind_param
            $types = str_repeat("i", count($citas_no_facturadas)); // Suponiendo que los valores son enteros
            
            // Enlazar los parámetros a la consulta
            $stmt->bind_param($types, ...$citas_no_facturadas);
    
            // Ejecutar la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta para las reservas: " . $stmt->error);
            }
    
            // Confirmar la transacción
            $this->con->commit();
    
            // Cerrar la declaración
            $stmt->close();
    
            // Retornar un mensaje de éxito o true
            return true;
    
        } catch (Exception $e) {
            // En caso de error, deshacer la transacción
            $this->con->rollback();
    
            // Lanzar la excepción con el mensaje de error
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    
    

    public function searchPrecioParaFacturar($citas_no_facturadas) {
        try {
            $placeholders = implode(',', array_fill(0, count($citas_no_facturadas), '?'));
            
            $sql = "
                SELECT COUNT(*) as total
                FROM tb_reservas
                INNER JOIN tb_valores
                ON tb_reservas.id_paciente = tb_valores.id_paciente_valor
                WHERE tb_reservas.id_reserva IN ($placeholders)
                AND tb_reservas.fecha_cita BETWEEN tb_valores.desde AND tb_valores.hasta
                AND tb_valores.precio IS NOT NULL
                AND tb_valores.precio != ''
            ";
    
            $stmt = $this->con->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }
    
            $stmt->bind_param(str_repeat('i', count($citas_no_facturadas)), ...$citas_no_facturadas);
            $stmt->execute();
            $result = $stmt->get_result();
    
            $row = $result->fetch_assoc();
            $stmt->close();
    
            return $row['total'] > 0; // Devuelve true si hay citas con precio
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    
    public function searchCitasFacturadas() {
        try {
           $stmt = $this->con->prepare(
                "SELECT 
                tb_reservas.*, 
                tb_pacientes.nombre, 
                tb_pacientes.apellido, 
                COALESCE(tb_valores.precio, NULL) AS precio
            FROM 
                tb_reservas
            LEFT JOIN 
                tb_valores 
                ON tb_reservas.id_paciente = tb_valores.id_paciente_valor 
                AND tb_reservas.fecha_cita BETWEEN tb_valores.desde AND tb_valores.hasta
            INNER JOIN 
                tb_pacientes 
                ON tb_pacientes.id_paciente = tb_reservas.id_paciente
            WHERE  
                tb_reservas.estado = 1
                AND tb_reservas.facturado = 1;
            "
            );

           
            $stmt->execute();
            $result = $stmt->get_result();

            $reservas = [];
            while ($row = $result->fetch_assoc()) {
                $reservas[] = $row;
            }

            $stmt->close();
            return $reservas;

        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function searchCitasNoFacturadas() {
        try {
           $stmt = $this->con->prepare(
                "SELECT 
                tb_reservas.*, 
                tb_pacientes.nombre, 
                tb_pacientes.apellido, 
                COALESCE(tb_valores.precio, NULL) AS precio
            FROM 
                tb_reservas
            LEFT JOIN 
                tb_valores 
                ON tb_reservas.id_paciente = tb_valores.id_paciente_valor 
                AND tb_reservas.fecha_cita BETWEEN tb_valores.desde AND tb_valores.hasta
            INNER JOIN 
                tb_pacientes 
                ON tb_pacientes.id_paciente = tb_reservas.id_paciente
            WHERE  
                tb_reservas.estado = 1
                AND tb_reservas.facturado = 0;
            "
            );

           
            $stmt->execute();
            $result = $stmt->get_result();

            $reservas = [];
            while ($row = $result->fetch_assoc()) {
                $reservas[] = $row;
            }

            $stmt->close();
            return $reservas;

        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }

    public function searchCitasFacturadasPorPaciente($id_paciente, $desde, $hasta) {
        try {
           $stmt = $this->con->prepare(
                "SELECT 
                tb_reservas.*, 
                tb_pacientes.nombre, 
                tb_pacientes.apellido, 
                COALESCE(tb_valores.precio, NULL) AS precio
            FROM 
                tb_reservas
            LEFT JOIN 
                tb_valores 
                ON tb_reservas.id_paciente = tb_valores.id_paciente_valor 
                AND tb_reservas.fecha_cita BETWEEN tb_valores.desde AND tb_valores.hasta
            INNER JOIN 
                tb_pacientes 
                ON tb_pacientes.id_paciente = tb_reservas.id_paciente
            WHERE 
                tb_reservas.id_paciente = ? 
                AND tb_reservas.start >= ? 
                AND tb_reservas.end <= ? 
                AND tb_reservas.estado = 1
                AND tb_reservas.pagado = 0
                AND tb_reservas.facturado = 1;
            "
            );

            $stmt->bind_param("iss", $id_paciente, $desde, $hasta);
            $stmt->execute();
            $result = $stmt->get_result();

            $reservas = [];
            while ($row = $result->fetch_assoc()) {
                $reservas[] = $row;
            }

            $stmt->close();
            return $reservas;

        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    public function searchCitasNoFacturadasPorPaciente($id_paciente, $desde, $hasta) {
        try {
           $stmt = $this->con->prepare(
                "SELECT 
                tb_reservas.*, 
                tb_pacientes.nombre, 
                tb_pacientes.apellido, 
                COALESCE(tb_valores.precio, NULL) AS precio
            FROM 
                tb_reservas
            LEFT JOIN 
                tb_valores 
                ON tb_reservas.id_paciente = tb_valores.id_paciente_valor 
                AND tb_reservas.fecha_cita BETWEEN tb_valores.desde AND tb_valores.hasta
            INNER JOIN 
                tb_pacientes 
                ON tb_pacientes.id_paciente = tb_reservas.id_paciente
            WHERE 
                tb_reservas.id_paciente = ? 
                AND tb_reservas.start >= ? 
                AND tb_reservas.end <= ? 
                AND tb_reservas.estado = 1
                AND tb_reservas.pagado = 0
                AND tb_reservas.facturado = 0;
            "
            );

            $stmt->bind_param("iss", $id_paciente, $desde, $hasta);
            $stmt->execute();
            $result = $stmt->get_result();

            $reservas = [];
            while ($row = $result->fetch_assoc()) {
                $reservas[] = $row;
            }

            $stmt->close();
            return $reservas;

        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
    
}

    


    
    
    
    
    
    

