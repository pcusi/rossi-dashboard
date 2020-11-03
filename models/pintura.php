<?php

include './conexion.php';

$conn = new Conexion();

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_creacion = $_POST['fecha_creacion'];
$fotos_galeria = $_POST['fotos_galeria'];
$foto = $_POST['foto'];
$precio = $_POST['precio'];

class Pintura
{

    public function insertar()
    {
        if (isset($_POST['submit'])) {
            if (
                isset($titulo) && isset($descripcion) && isset($fecha_creacion)
                && isset($fotos_galeria) && isset($foto) && isset($precio)
            ) {
                if (
                    !empty($titulo) && !empty($descripcion) && !empty($fecha_creacion)
                    && !empty($fotos_galeria) && !empty($foto) && !empty($precio)
                ) {

                    $query = "INSERT INTO Pintura(titulo, descripcion, fecha_creacion, precio) VALUES 
                    ('$titulo', '$descripcion', '$fecha_creacion', '$precio')";

                    if ($sql = $this->conn->exec($query)) {
                        echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            La pintura fue creada correctamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
                    } else {
                        echo '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            La pintura no pudo crearse.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
                    }
                } else {
                    echo '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>¡Oops!</strong> Los campos no pueden ir vacíos
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
                }
            }
        }
    }
}
