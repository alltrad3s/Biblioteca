<?php
class Libro {
    private $conn;
    private $table = "libros";
    
    // Propiedades
    public $id;
    public $titulo;
    public $autor;
    public $categoria;
    public $isbn;
    public $disponible;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Crear nuevo libro
    public function crear() {
        $query = "INSERT INTO " . $this->table . " 
                 SET titulo=:titulo, autor=:autor, categoria=:categoria, 
                     isbn=:isbn, disponible=:disponible";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->isbn = htmlspecialchars(strip_tags($this->isbn));
        
        // Vincular valores
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":disponible", $this->disponible);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Leer todos los libros
    public function leer() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Buscar libros
    public function buscar($termino) {
        // Si es un ID (número)
        if (is_numeric($termino)) {
            $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$termino]);
        } else {
            // Si es una búsqueda por término
            $query = "SELECT * FROM " . $this->table . " 
                     WHERE titulo LIKE :termino 
                     OR autor LIKE :termino 
                     OR categoria LIKE :termino";
                     
            $stmt = $this->conn->prepare($query);
            $termino = "%{$termino}%";
            $stmt->bindParam(":termino", $termino);
            $stmt->execute();
        }
        return $stmt;
    }

    // Editar libro
    public function editar() {
        $query = "UPDATE " . $this->table . "
                SET titulo=:titulo, autor=:autor, 
                    categoria=:categoria, isbn=:isbn 
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->isbn = htmlspecialchars(strip_tags($this->isbn));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar libro
    public function eliminar() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}