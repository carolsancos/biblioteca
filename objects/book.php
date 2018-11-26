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

    
}
?>