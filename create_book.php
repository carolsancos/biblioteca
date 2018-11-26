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

$page_title = "Crear Libro";
include_once "header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Ver Libros</a>";
echo "</div>";

if(isset($_GET['id_libro'])) {
    $id_libro = intval($_GET['id_libro']);
    $stmt = $book->findById($id_libro);
    $num = $stmt->rowCount();
}

 
?>

<?php 

if($_POST){
 
    $book->titulo = $_POST['titulo'];
    $book->fecha_edicion = $_POST['fecha_edicion'];
    if(!empty($_POST['check_autores'])) {
        $autoresList = $_POST['check_autores'];

        foreach ($autoresList as $autorId) {
            echo "ID AUTOR ".$autorId; echo "<br />";
            $bookCreated = $book->createBook($autorId);
            if($bookCreated){
                echo "<div class='alert alert-success'>El libro fue creado.</div>";
            }else{
                echo "<div class='alert alert-danger'>No se pudo crear el libro.</div>";
            }

        }

    }

    echo $book->titulo; echo "<br/>";
    echo $book->fecha_edicion; echo "<br/>";    
    
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <?php         
        if(isset($num) && $num > 0) {
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $time = strtotime($fecha_edicion);
                $newformatedDate = date('d-m-Y', $time);

            }
        }
    ?>
    <div class='table-responsive'>
        <div class="container">
            <div class="row">
                <div class='col-md-6'>
                    <div class="row">
                        <p>
                            <label><b>T&iacute;tulo &nbsp;&nbsp; </b></label>          
                            <input type="text" name="titulo" value="<?php if(isset($titulo)) echo $titulo; ?>">
                        </p>
                    </div>
                    <div class="row">
                        <p>
                            <label><b>Edici&oacute;n </b></label>          
                            <span class="datepicker">
                                <input type="text" id="datepicker" value="<?php if(isset($newformatedDate)) echo $newformatedDate; ?>">     
                                <i class="fa fa-calendar" id="calendar-icon" aria-hidden="true"></i>
                            </span>
                            <input type="hidden" id="dbdatepicker" name="fecha_edicion" value="<?php if(isset($newformatedDate)) echo $newformatedDate; ?>">
                        </p>
                    </div>
                    
                </div>
                <div class='col-md-6'>
                    <div class="row">
                        <label><b>Lista de Autores </b></label>
                    </div>
                    <div class="row">
                        <?php

                            $authors = $author->read();
                            $row_author = $authors->fetch(PDO::FETCH_ASSOC);

                            echo "<table class='table table-hover table-bordered table-striped'>";

                            while ($row_author = $authors->fetch(PDO::FETCH_ASSOC)){
                                extract($row_author);
                                echo "<tr>";
                                echo "<td>";
                                echo "<input type='checkbox' name='check_autores[]'' value='{$id_autor}'>  ".$nombre;
                                echo "</td>";
                                echo "</tr>";
                            }
                            
                            echo "</table>";                
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-md-6 text-center'>                    
                    <button type="submit" class="btn btn-primary">Guardar</button>                
                </div>
                <div class='col-md-6 pull-left'>            
                    <button type="submit" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div> 

</form>

<?php
include_once "footer.php";
?>