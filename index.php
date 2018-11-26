<?php
// To display special characters
header('Content-Type: text/html; charset=ISO-8859-1');

include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/author.php';
 
$database = new Database();
$db = $database->getConnection();
 
$book = new Book($db);
$author = new Author($db);


if($_POST) {
	$book->titulo = $_POST['titulo'];	
    $book->fecha_edicion = $_POST['fecha_edicion'];
    $nroautores = $_POST['nro_autores'];

    $stmt = $book->search($book->titulo, $book->fecha_edicion, $nroautores);
	$num = $stmt->rowCount();

}else {
	$stmt = $book->findAll();
	$num = $stmt->rowCount();
}


$page_title = "Listar Libros";
include_once "header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='create_book.php' class='btn btn-default pull-right'>Agregar Libro</a>";
echo "</div>";

?>

<div class="container">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div class="row">
			<div class='col-md-4'>
				<p>
					<label>T&iacute;tulo &nbsp;&nbsp; </label>    		
		    		<input type="text" name="titulo">
	    		</p>
	    	</div>
	    	<div class='col-md-4'>
	    		<p class="pull-right">  		
		    		<label>Autores </label>
		    		<input type="text" name="nro_autores">
	    		</p>  
	    	</div>		
		</div>
	    <div class="row">    	
	        <div class='col-md-4'>
	        	<p>
	        	<label>Edici&oacute;n </label>
                <span class="datepicker">
                    <input type="text" id="datepicker">     
                    <i class="fa fa-calendar" id="calendar-icon" aria-hidden="true"></i>
                </span>
                <input type="hidden" id="dbdatepicker" name="fecha_edicion">
	        	</p>
	        </div>
	        <div class='col-md-4'>
	        	<p>
	    			<button type="submit" class="btn btn-primary pull-right">Buscar</button>
	    		</p>
	    	</div>

	    </div>
	</form>
</div>
</p>
<hr>


<?php

// display the books if there are any
if($num > 0){
 	echo "<div class='table-responsive'>";
    echo "<table class='table table-hover table-bordered table-striped'>";
        echo "<tr>";
            echo "<th>T&iacute;tulo</th>";
            echo "<th>Edici&oacute;n</th>";
            echo "<th>Autores</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
                echo "<td><a href='create_book.php?id_libro={$id_libro}'>{$titulo}</a></td>";
                echo "<td>{$fecha_edicion}</td>";
                echo "<td>{$nro_autores}</td>";
 
            echo "</tr>";
 
        }
 
    echo "</table>";
    echo "</div>"; 
   
}
 
else{
    echo "<div class='alert alert-info'>No books found.</div>";
} 

include_once "footer.php";
?>