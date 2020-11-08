<?php

require_once("../models/conexion.php");

$conn = new Conexion();

if (isset($_SESSION["idUsu"])) {


?>




  <?php include('./header.php'); ?>


  <?php include('./sidebar.php') ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div id="resultado"></div>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pinturas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="panel-body table-responsive">
          <button class="btn btn-primary" data-toggle="modal" data-target="#pinturaModal" id="add-pintura">Agregar</button>
          <table id="tabla" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Fecha Creación</th>
                <th>Foto</th>
                <th>Galería</th>
                <th>Estado</th>
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

  <div class="modal fade" id="pinturaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar pintura</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-8">
              <form id="pintura-form" method="post">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="text" name="titulo" id="titulo" required class="form-control"
                      placeholder="Título pintura ...">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="text" name="precio" id="precio" required class="form-control"
                      placeholder="Precio...">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <textarea name="descripcion" id="descripcion" cols="30" rows="10" 
                      class="form-control" placeholder="Descripción de la pintura ..."></textarea>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <input type="file" name="foto" id="foto">
                    </div>
                  </div>
                </div>
                <button class="btn btn-md btn-primary" id="submit" name="submit">Agregar Pintura</button>
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

  <?php include('./footer.php') ?>


<?php

} else {

  header("Location:" . $conn->ruta() . "index.php");
}

?>