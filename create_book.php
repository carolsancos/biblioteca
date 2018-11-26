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
    $autoresList = $_POST['check_autores'];
    if(!empty($autoresList) && !empty($book->titulo) && !empty($book->fecha_edicion)) {

        foreach ($autoresList as $autorId) {
            $bookCreated = $book->createBook($autorId);
            if($bookCreated){
                echo "<div class='alert alert-success'>El libro fue creado.</div>";
            }else{
                echo "<div class='alert alert-danger'>No se pudo crear el libro.</div>";
            }

        }

    }
   
    
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <?php
        $i = 0;         
        if(isset($num) && $num > 0) {
            $autores_array = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $time = strtotime($fecha_edicion);
                $newformatedDate = date('d-m-Y', $time);

                $autores_array[$i] = $id_autor;

                $i++;

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
                                
                                if(!empty($autores_array)) {
                                    foreach ($autores_array as $idAutor) {
                                                                                
                                        if($id_autor == $idAutor){
                                            $checked = 'checked';
                                        }else {
                                            $checked = '';
                                        }
                                    }
                                }

                                echo "<input type='checkbox' name='check_autores[]'' value='{$id_autor}' ".$checked." >  ".$nombre;
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
                    <a href="index.php" id="cancel" name="cancel" class="btn btn-danger">Cancelar</a>       
                </div>
            </div>
        </div>
    </div> 

</form>

<?php
include_once "footer.php";
?>