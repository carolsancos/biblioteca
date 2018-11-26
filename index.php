<?php

// include database and object files
include_once 'config/database.php';
include_once 'objects/book.php';
include_once 'objects/author.php';
 
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
 
$book = new Book($db);
$author = new Author($db);
 
$stmt = $book->findAll();
$num = $stmt->rowCount();

$page_title = "Listar Libros";
include_once "header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='create_book.php' class='btn btn-default pull-right'>Agregar Libro</a>";
echo "</div>";

?>

<div class="container">
	<div class="row">
		<div class='col-md-4'>
			<p>
				<label>T&iacute;tulo </label>    		
	    		<input type="text" name="titulo">
    		</p>
    	</div>
    	<div class='col-md-4'>
    		<p>  		
	    		<label>Autores </label>
	    		<input type="text" name="autor">
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

        	</p>
        </div>
        <div class='col-md-4'>
        	<p>
    		<button>Buscar</button>
    		</p>
    	</div>

    </div>
</div>
</p>
<hr>

<?php
include_once "footer.php";
?>