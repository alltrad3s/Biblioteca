<?php
class Prestamo {
    private $conn;
    private $table = "prestamos";
    
    public $id;
    public $libro_id;
    public $usuario_id;
    public $fecha_prestamo;
    public $fecha_devolucion;
    public $estado;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function registrarPrestamo() {
        // Verificar disponibilidad del libro
        $query = "SELECT disponible FROM libros WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->libro_id]);
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$libro['disponible']) {
            return false;
        }
        
        // Iniciar transacción
        $this->conn->beginTransaction();
        
        try {
            // Registrar préstamo
            $query = "INSERT INTO " . $this->table . " 
                     SET libro_id=:libro_id, usuario_id=:usuario_id, 
                         fecha_prestamo=:fecha_prestamo, 
                         fecha_devolucion=:fecha_devolucion, 
                         estado='activo'";
                         
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":libro_id", $this->libro_id);
            $stmt->bindParam(":usuario_id", $this->usuario_id);
            $stmt->bindParam(":fecha_prestamo", $this->fecha_prestamo);
            $stmt->bindParam(":fecha_devolucion", $this->fecha_devolucion);
            
            $stmt->execute();
            
            // Actualizar estado del libro
            $query = "UPDATE libros SET disponible = 0 WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$this->libro_id]);
            
            $this->conn->commit();
            return true;
            
        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Obtener todos los préstamos
    public function obtenerPrestamos() {
        $query = "SELECT p.*, l.titulo as libro_titulo 
                 FROM " . $this->table . " p
                 JOIN libros l ON p.libro_id = l.id
                 ORDER BY p.fecha_prestamo DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}