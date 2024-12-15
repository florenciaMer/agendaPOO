<?php
require_once('Connection.php');

class Pago extends Connection {
    public function __construct() {
        parent::__construct();
    }

    public function searchCitasNoPagasPorPaciente($id_paciente, $desde, $hasta) {
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
                AND tb_reservas.facturado = 1
                AND tb_reservas.realizada = 1;
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

    public function setPagoPorPaciente($citas_no_pagadas) {
        try {
            // Validar que haya citas para actualizar
            if (empty($citas_no_pagadas)) {
                throw new Exception("No hay citas para actualizar.");
            }
    
            // Generar los placeholders dinámicamente
            $placeholders = implode(",", array_fill(0, count($citas_no_pagadas), "?"));
    
            // Iniciar la transacción
            if (!$this->con->begin_transaction()) {
                throw new Exception("Error al iniciar la transacción: " . $this->con->error);
            }
    
            // Preparar la consulta SQL
            $stmt = $this->con->prepare(
                "UPDATE tb_reservas SET pagado = 1 WHERE id_reserva IN ($placeholders)"
            );
    
            // Verificar la preparación de la consulta
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->con->error);
            }
    
            // Construir los tipos de parámetros
            $types = str_repeat("i", count($citas_no_pagadas));
    
            // Enlazar los parámetros
            if (!$stmt->bind_param($types, ...$citas_no_pagadas)) {
                throw new Exception("Error al enlazar parámetros: " . $stmt->error);
            }
    
            // Ejecutar la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
    
            // Confirmar la transacción
            $this->con->commit();
    
            // Cerrar la declaración
            $stmt->close();
    
            return true; // Operación exitosa
    
        } catch (Exception $e) {
            // Deshacer la transacción en caso de error
            $this->con->rollback();
    
            // Lanzar la excepción con el mensaje de error
            throw new Exception("Error en setPagoPorPaciente: " . $e->getMessage());
        }
    }
    
}

    


    
    
    
    
    
    

