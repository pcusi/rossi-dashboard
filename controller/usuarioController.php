<?php

require_once '../models/usuario.php';
require_once '../models/conexion.php';

$usuario = new Usuario();


switch ($_GET["op"]) {
    case "logout":
        $usuario->logout();
    break;
}
