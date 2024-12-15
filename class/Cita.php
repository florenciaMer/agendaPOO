<?php
require_once('Connection.php');

class Cita extends Connection {
    public function __construct() {
        parent::__construct();
    }

    public function searchCitas() {
        try {
            $stmt = $this->con->prepare(
                "SELECT 
                r.*, 
                p.nombre, 
                p.apellido, 
                COALESCE(v.precio, 0) AS precio
            FROM 
                tb_reservas r
            LEFT JOIN 
                tb_valores v
                ON r.id_paciente = v.id_paciente_valor 
                AND r.fecha_cita BETWEEN v.desde AND v.hasta
            INNER JOIN 
                tb_pacientes p
                ON p.id_paciente = r.id_paciente
            WHERE 
                r.estado = 1
            ORDER BY 
                p.nombre, p.apellido, r.fecha_cita DESC;
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

    public function searchCitasNoPagasPorPacienteNoFacturadas($id_paciente, $desde, $hasta) {
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

    


    
    
    
    
    
    

