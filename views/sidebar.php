<?php


require_once("../models/conexion.php");

$conn = new Conexion();

if (isset($_SESSION["idUsu"])) {

?>



    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="../dist/img/7.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Carolina de Rossi</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div class="user-avatar">
                        <p><?php echo $_SESSION["usuario"] ?></p>
                    </div>
                    <img src="../dist/img/7.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo $_SESSION["usuario"] ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li>
                        <a href="pinturaVista.php" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Pinturas
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

<?php

} else {

    header("Location:" . $conn->ruta() . "index.php");
    exit();
}
?>