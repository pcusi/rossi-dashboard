<?php

require_once('../models/conexion.php');
$conn = new Conexion();
if (isset($_SESSION["idUsu"])) {
    require_once('../models/pintura.php');
    $pintura = new Pintura();
    $pint = $pintura->getPinturas();


?>


    <?php include './header.php' ?>

    <?php include './sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div id="resultado"></div>
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Galería de Pinturas</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="panel-body table-responsive">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#galeriaModal" id="add-pintura">Agregar</button>
                    <table id="tabla-galeria" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Titulo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="galeriaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <form id="galeria-form" method="post">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="file" name="foto" id="foto">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <select class="form-control" name="pintura" id="pintura">

                                                <option value="0">Seleccione</option>

                                                <?php

                                                for ($i = 0; $i < sizeof($pint); $i++) {

                                                ?>
                                                    <option value="<?php echo $pint[$i]["idPin"] ?>" id="opcion"><?php echo $pint[$i]["titulo"]; ?></option>
                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-md btn-primary" id="submit" name="submit">
                                    Agregar Foto
                                </button>
                                <input type="hidden" name="idFoto" id="idFoto">
                                <input type="hidden" name="idPin" id="idPin">
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <span id="foto_muestra"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include './footer.php' ?>

<?php
} else {
    header("Location:" . $conn->ruta() . "index.php");
    exit();
}
?>