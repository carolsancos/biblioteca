<?php
class Book {

	private $conn;
    private $table_name = "libro";
 
    // object properties
    public $id_libro;
    public $titulo;
    public $fecha_edicion;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id_libro, titulo, fecha_edicion
                FROM
                    " . $this->table_name . "
                ORDER BY
                    titulo";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

    function findAll() {

        $query = "SELECT DISTINCT
                    libro.id_libro, libro.titulo, libro.fecha_edicion, COUNT(DISTINCT autor.id_autor) AS nro_autores
                FROM
                    " . $this->table_name . "
                INNER JOIN autor_libro 
                    ON autor_libro.id_libro = libro.id_libro 
                INNER JOIN autor 
                    ON autor.id_autor = autor_libro.id_autor                    
                GROUP BY libro.id_libro
                ORDER BY libro.titulo";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;

    }

    function search($titulo, $fecha_edicion, $nro_autores) {
        $query = "SELECT DISTINCT
            libro.id_libro, libro.titulo, libro.fecha_edicion, COUNT(DISTINCT autor.id_autor) AS nro_autores
        FROM
            " . $this->table_name . "
        INNER JOIN autor_libro 
            ON autor_libro.id_libro = libro.id_libro 
        INNER JOIN autor 
            ON autor.id_autor = autor_libro.id_autor
        WHERE libro.titulo LIKE '%{$titulo}' 
            AND libro.fecha_edicion LIKE '%{$fecha_edicion}'              
        GROUP BY libro.id_libro
        ORDER BY libro.titulo";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;

    }

    function insertAuthorBook($id_autor, $id_libro) {

        $query = "INSERT INTO
            autor_libro
        SET
            id_autor=:id_autor, id_libro=:id_libro";
 
        $stmt = $this->conn->prepare($query);
 
        $this->id_autor=htmlspecialchars(strip_tags($id_autor));
        $this->id_libro=htmlspecialchars(strip_tags($id_libro));
 
        $stmt->bindParam(":id_autor", $id_autor);
        $stmt->bindParam(":id_libro", $id_libro);

 
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }  

    }

    function createBook($id_autor){        
        
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    titulo=:titulo, fecha_edicion=:fecha_edicion";
 
        $stmt = $this->conn->prepare($query);
 
        $this->titulo=htmlspecialchars(strip_tags($this->titulo));
        $this->fecha_edicion=htmlspecialchars(strip_tags($this->fecha_edicion));
 
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":fecha_edicion", $this->fecha_edicion);

 
        if($stmt->execute()){
            $lastBookId = $this->conn->lastInsertId();
            if(isset($lastBookId)) {
                $this->insertAuthorBook($id_autor, $lastBookId);
            }
            
            return true;
        }else{
            return false;
        }        
 
    }

    function findById($id_libro) {

        $query = "SELECT
                    libro.titulo, libro.fecha_edicion, autor.id_autor, autor.nombre
                FROM
                    " . $this->table_name . "
                INNER JOIN autor_libro 
                    ON autor_libro.id_libro = libro.id_libro 
                INNER JOIN autor 
                    ON autor.id_autor = autor_libro.id_autor
                WHERE autor_libro.id_libro = {$id_libro}  limit 0,1    
                ";        

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;

    }

    
}
?>