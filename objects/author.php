<?php
class Author{
 
    private $conn;
    private $table_name = "autor";
 
    public $id_autor;
    public $nombre;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    function read(){
        
        $query = "SELECT
                    id_autor, nombre
                FROM
                    " . $this->table_name . "
                ORDER BY
                    nombre";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }
 
}
?>