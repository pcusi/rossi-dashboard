<?php

require_once '../models/galeria.php';
require_once '../models/conexion.php';

$galeria = new Galeria();

$idPin = isset($_POST['idPin']);
$foto = isset($_POST['foto']);
$idFoto = isset($_POST['idFoto']);

switch ($_GET["op"]) {
    case "guardar":
        $datos = $galeria->issetFoto($_POST["idPin"]);
        if (empty($_POST["idFoto"])) {

            /*verificamos si existe la categoria en la base de datos, si ya existe un registro con la categoria entonces no se registra*/

            if (is_array($datos) == true and count($datos) == 0) {

                $galeria->crearFoto($foto, $idPin);

                $messages[] = "La pintura se registró correctamente";
            } else {

                $errors[] = "La pintura ya existe";
            }
        } else {

            $galeria->editarGaleria($idFoto, $foto, $idPin);

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
        $datos = $galeria->getFotoById($_POST["idFoto"]);


        // si existe el id de la categoria entonces recorre el array
        if (is_array($datos) == true and count($datos) > 0) {


            foreach ($datos as $row) {
                $output["foto"] = $row["foto"];
                $output["idPin"] = $row["idPin"];
                $output["titulo"] = $row["titulo"];
                $output["idFoto"] = $row["idFoto"];

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
        $datos = $galeria->getFotos();

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


            if ($row['foto'] != '') {
                $sub_array[] =
                    '
                <img src="upload/' . $row["foto"] . '" class="img-thumbnail" width="50" height="50" />
                <input type="hidden" name="foto_hidden" value="' . $row["foto"] . '"/>
				';
            } else {
                $sub_array[] = '<button type="button" id="" class="btn btn-primary btn-md"><i class="fa fa-picture-o" aria-hidden="true"></i>Sin imagen</button>';
            }

            $sub_array[] = $row["titulo"];



            $sub_array[] = '<button type="button" 
            onClick="mostrarGaleria(' . $row["idFoto"] . ');"  id="' . $row["idFoto"] . '"
            class="btn btn-warning btn-xs update">
            <i class="fa fa-edit text-white"></i></button>';

            $sub_array[] = '
            <div class="estado-pintura">
                <span class="' . $span . '"
                onClick="estadoGaleria(' . $row["idFoto"] . ', ' . $row["estado"] . ');"  
                id="' . $row["idFoto"] . '">' . $est . '</span>
            </div>
            ';

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
        $datos = $galeria->getFotoById($_POST["idFoto"]);
        if (is_array($datos) and count($datos) > 0) {
            $galeria->estadoFoto($_POST["idFoto"], $_POST["est"]);
        }
        break;
}
