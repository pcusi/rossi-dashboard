<?php

require_once '../models/pintura.php';
require_once '../models/conexion.php';

$pintura = new Pintura();

$titulo = isset($_POST['titulo']);
$descripcion = isset($_POST['descripcion']);
$precio = isset($_POST['precio']);
$idPin = isset($_POST['idPin']);
$foto = isset($_POST['foto']);

switch ($_GET["op"]) {
    case "guardaryeditar":
        $datos = $pintura->issetPintura($_POST["titulo"]);
        if (empty($_POST["idPin"])) {

            /*verificamos si existe la categoria en la base de datos, si ya existe un registro con la categoria entonces no se registra*/

            if (is_array($datos) == true and count($datos) == 0) {

                $pintura->crearPintura($titulo, $descripcion, $precio, $foto);

                $messages[] = "La pintura se registró correctamente";
            } else {

                $errors[] = "La pintura ya existe";
            }
        } else {

            $pintura->editarPintura($idPin, $titulo, $descripcion, $precio, $foto);

            $messages[] = "La pintura se editó correctamente";
        }



        //mensaje success
        if (isset($messages)) {

?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>¡Bien hecho!</strong>
                <?php
                foreach ($messages as $message) {
                    echo $message;
                }
                ?>
            </div>
        <?php
        }
        //fin success

        //mensaje error
        if (isset($errors)) {

        ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong>
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
        <?php

        }

        //fin mensaje error
        break;
    case "mostrar":
        $datos = $pintura->getPinturaById($_POST["idPin"]);


        // si existe el id de la categoria entonces recorre el array
        if (is_array($datos) == true and count($datos) > 0) {


            foreach ($datos as $row) {
                $output["titulo"] = $row["titulo"];
                $output["descripcion"] = $row["descripcion"];
                $output["precio"] = $row["precio"];
                $output["idPin"] = $row["idPin"];

                if ($row["foto"] != '') {
                    $output["foto"] = '<img src="upload/' . $row["foto"] . '"class="img-thumbnail" width="300" height="50"/>
                    <input type="hidden" name="foto_hidden" value="' . $row["foto"] . '"/>';
                } else {
                    $output["foto"] = '<input type="hidden" name="foto_hidden" value="" />';
                }
            }


            echo json_encode($output);
        } else {

            //si no existe la categoria entonces no recorre el array
            $errors[] = "La pintura no existe";
        }


        //inicio de mensaje de error

        if (isset($errors)) {

        ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong>
                <?php
                foreach ($errors as $error) {
                    echo $error;
                }
                ?>
            </div>
<?php
        }

        //fin de mensaje de error
        break;
    case "listar":
        $datos = $pintura->getPinturas();

        //Vamos a declarar un array
        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();

            $est = '';
            $attrib = 'btn btn-success';
            $span = 'badge badge-success';

            if ($row['estado'] == 0) {
                $est = 'Inactivo';
                $attrib = 'btn btn-danger';
                $span = 'badge badge-danger';
            } else {
                if ($row['estado'] == 1) {
                    $est = 'Activo';
                }
            }

            $sub_array[] = $row["titulo"];
            $sub_array[] = $row["descripcion"];
            $sub_array[] = $row["precio"];
            $sub_array[] = $row["fecha_creacion"];

            if ($row['foto'] != '') {
                $sub_array[] =
                    '
                <img src="upload/' . $row["foto"] . '" class="img-thumbnail" width="50" height="50" />
                <input type="hidden" name="foto_hidden" value="' . $row["foto"] . '"/>
				';
            } else {
                $sub_array[] = '<button type="button" id="" class="btn btn-primary btn-md"><i class="fa fa-picture-o" aria-hidden="true"></i>Sin imagen</button>';
            }

            $sub_array[] = '
            <button type="button" 
            onClick="mostrar(' . $row["idPin"] . ');"  id="' . $row["idPin"] . '"
            class="btn btn-warning btn-md update">
            Agregar fotos</button>
            ';

            $sub_array[] = '
            <div class="estado-pintura">
                <span class="' . $span . '"
                onClick="estado(' . $row["idPin"] . ', ' . $row["estado"] . ');"  
                id="' . $row["idPin"] . '">' . $est . '</span>
            </div>
            ';

            $sub_array[] = '<button type="button" 
            onClick="mostrar(' . $row["idPin"] . ');"  id="' . $row["idPin"] . '"
            class="btn btn-warning btn-md update">
            <i class="fa fa-edit text-white"></i></button>';

            $sub_array[] = '<button type="button" 
            onClick="eliminar(' . $row["idPin"] . ');" 
            id="' . $row["idPin"] . '"class="btn btn-danger btn-md">
            <i class="fa fa-eraser text-white"></i>
            </button>';

            $data[] = $sub_array;
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);


        break;
    case "estado":
        $datos = $pintura->getPinturaById($_POST["idPin"]);
        if (is_array($datos) and count($datos) > 0) {
            $pintura->estadoPintura($_POST["idPin"], $_POST["est"]);
        }
        break;
    case "eliminar":
        $datos = $pintura->getPinturaById($_POST["idPin"]);
        if (is_array($datos) and count($datos) > 0) {
            $pintura->eliminarPintura($_POST["idPin"]);
        }
        break;
}
