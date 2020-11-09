<?php

declare(strict_types=1);
require_once("conexion.php");

class Galeria extends Conexion
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getFotos()
    {
        $conn = parent::conexion();
        $sql = "SELECT p.titulo as titulo, p.idPin as idPin, f.idFoto, f.foto, f.estado as estado
        FROM PINTURA p INNER JOIN FOTO_PINTURA f on f.idPin = p.idPin";
        $sql = $conn->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function issetFoto($idPin) {
        $conn = parent::conexion();
        $sql = "SELECT *FROM FOTO_PINTURA where idPin = ?";
        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $idPin);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function getFotoById($idPin)
    {
        $conn = parent::conexion();
        $sql = "SELECT p.titulo as titulo, p.idPin as idPin, f.idFoto as idFoto, f.foto as foto
        FROM PINTURA p INNER JOIN FOTO_PINTURA f on f.idPin = p.idPin
        where idFoto = ?";
        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $idPin);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function crearFoto($foto, $idPin)
    {
        $conn = parent::conexion();

        $image = '';

        if ($_FILES["foto"]["name"] != '') {
            $image = $this->upload_image();
        }

        $sql = "INSERT INTO FOTO_PINTURA (foto, idPin)
        VALUES (?, ?)";

        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $image);
        $sql->bindValue(2, $_POST['pintura']);
        $sql->execute();
    }

    public function editarGaleria($idFoto, $foto, $idPin)
    {
        $conn = parent::conexion();

        $foto = '';

        if ($_FILES["foto"]["name"] != '') {
            $foto = $this->upload_image();
        } else {

            $foto = $_POST["foto_hidden"];
        }

        $sql = "UPDATE FOTO_PINTURA SET foto = ?, idPin = ?
        where idFoto = ?";

        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $foto);
        $sql->bindValue(2, $_POST['pintura']);
        $sql->bindValue(3, $_POST['idFoto']);
        $sql->execute();
    }

    public function estadoFoto($idFoto, $estado)
    {
        $conn = parent::conexion();

        if ($_POST['est'] == 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $sql = "UPDATE FOTO_PINTURA SET estado = ? where idFoto = ?";

        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $idFoto);
        $sql->execute();
    }

    /*poner la ruta vistas/upload*/
    public function upload_image()
    {

        if (isset($_FILES["foto"])) {
            $extension = explode('.', $_FILES['foto']['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = '../views/upload/' . $new_name;
            move_uploaded_file($_FILES['foto']['tmp_name'], $destination);
            return $new_name;
        }
    }
}
