<?php
require_once('Connection.php');

class Valor extends Connection{
    public function __construct(){
        //utilizar la con para tomar todos los valores
        parent::__construct();
    }
    public function searchValoresPacientes() {
        $estado = 1; // activos
        try {
            // Preparar la consulta con un marcador de posición
            $stmt = $this->con->prepare("SELECT tb_valores.*, tb_pacientes.nombre, tb_pacientes.apellido
            FROM tb_valores
            INNER JOIN tb_pacientes ON tb_valores.id_paciente_valor = tb_pacientes.id_paciente
            WHERE tb_valores.estado = ?
            ORDER BY tb_pacientes.nombre, tb_valores.desde DESC");
            
            // Enlazar el parámetro
            $stmt->bind_param("i", $estado);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Recuperar los resultados
            $result = $stmt->get_result();
            
            // Verificar si se encontró algún registro
            $valor = $result->fetch_all(MYSQLI_ASSOC); // Traer todos los registros
            
            // Cerrar el statement
            $stmt->close();
            
            return $valor; 
        } catch (Exception $e) {
            throw new Exception("Error en la consulta: " . $e->getMessage());
        }
    }
        public function searchValor($id) {
            try {
                $estado = 1; // activos
                $facturado = 0; // no facturado

                $stmt = $this->con->prepare(
                "SELECT * FROM tb_valores
                    INNER JOIN tb_pacientes ON tb_pacientes.id_paciente = tb_valores.id_paciente_valor
                    WHERE tb_valores.id_valor = ? 
                    AND tb_valores.estado = ? 
                    AND tb_valores.facturado = ?;");
        
                if (!$stmt) {
                    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
                }
        
                $stmt->bind_param("iii", $id, $estado, $facturado);
                $stmt->execute();
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
        public function searchValorFacturado($id) {
            try {
                $facturado = 1; // Solo valores facturados
                
                $stmt = $this->con->prepare(
                    "SELECT * FROM tb_valores
                        WHERE id_valor = ? 
                        AND tb_valores.facturado = ?;"
                );
            
                if (!$stmt) {
                    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
                }
            
                $stmt->bind_param("ii", $id, $facturado);
                $stmt->execute();
                $result = $stmt->get_result();
            
                if (!$result) {
                    throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
                }
            
                $valor = $result->fetch_assoc(); // Obtener el resultado
                $stmt->close();
            
                // Verificar si se obtuvo algún resultado
                if ($valor) {
                    return true;  // Valor facturado
                }
            
                return false; // No está facturado
            
            } catch (Exception $e) {
                throw new Exception("Error en la consulta: " . $e->getMessage());
            }
        }
        public function searchValorPacienteFecha($id_paciente, $desde) {
            $estado = 1; // Estado fijo
            try {
                // Preparar la consulta con marcadores de posición
                $stmt = $this->con->prepare("SELECT * FROM `tb_valores` 
                                             WHERE id_paciente_valor = ? 
                                             AND ? BETWEEN desde AND hasta 
                                             AND estado = ?");
                // Enlazar los parámetros
                $stmt->bind_param("isi", $id_paciente, $desde, $estado);
        
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
        
        
        public function updateValor($id_valor, $precio, $fyh_actualizacion) {
            // Preparamos la consulta de actualización
            $stmt = $this->con->prepare("UPDATE tb_valores SET precio = ?, fyh_actualizacion = ? 
            WHERE id_valor = ?");

            
            
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->con->error);
            }
            
            // Vinculamos los parámetros correctamente (en el tipo de datos 's' para string y 'i' para integer)
            $stmt->bind_param("dsi", $precio, $fyh_actualizacion, $id_valor);

            
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
    
        public function deleteValor($id, $fechaHora) {
            $estado = 0;
            try {
                // Preparamos la consulta
                $stmt = $this->con->prepare("UPDATE tb_valores SET estado = ?, fyh_actualizacion = ? WHERE id_valor = ?");
            
                if (!$stmt) {
                    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
                }
            
                // Vinculamos los parámetros
                $stmt->bind_param("isi", $estado,$fechaHora, $id);
            
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

        public function insertValor($id_paciente,$desde, $hasta,$precio,$estado, $fyh_creacion) {
           
            
            // Consulta SQL corregida para incluir todos los campos
            $stmt = $this->con->prepare("INSERT INTO tb_valores
             (id_paciente_valor, desde, hasta, precio, estado, fyh_creacion) VALUES (?,?,?,?,?,?)");
            
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->con->error);
            }
            
            // Corregir los parámetros y sus tipos
            $stmt->bind_param("issiis",$id_paciente, $desde, $hasta, $precio, $estado, $fyh_creacion);
            
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
            
            $stmt->close();
            return true;
        }
    }
    
  