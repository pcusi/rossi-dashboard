<?php

declare(strict_types=1);
require_once("conexion.php");

class Pintura extends Conexion
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPinturas()
    {
        $conn = parent::conexion();
        $sql = "SELECT *FROM PINTURA";
        $sql = $conn->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPinturaById($idPin)
    {
        $conn = parent::conexion();
        $sql = "SELECT *FROM PINTURA where idPin = ?";
        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $idPin);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function issetPintura($titulo)
    {
        $conn = parent::conexion();
        $sql = "SELECT *FROM PINTURA where titulo = ?";
        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $titulo);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearPintura($titulo, $descripcion, $precio, $foto)
    {
        $conn = parent::conexion();

        $image = '';

        if ($_FILES["foto"]["name"] != '') {
            $image = $this->upload_image();
        }


        $sql = "INSERT INTO PINTURA (titulo, descripcion, precio, foto)
        VALUES (?, ?, ?, ?)";



        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $_POST['titulo']);
        $sql->bindValue(2, $_POST['descripcion']);
        $sql->bindValue(3, $_POST['precio']);
        $sql->bindValue(4, $image);
        $sql->execute();
    }

    public function editarPintura($idPin, $titulo, $descripcion, $precio, $foto)
    {
        $conn = parent::conexion();

        $foto = '';

        if ($_FILES["foto"]["name"] != '') {
            $foto = $this->upload_image();
        } else {

            $foto = $_POST["foto_hidden"];
        }

        $sql = "UPDATE PINTURA SET titulo = ?, 
        descripcion = ?, 
        precio = ?,
        foto = ?
        where idPin = ?";

        $sql = $conn->prepare($sql);
        $sql->bindValue(1, $_POST['titulo']);
        $sql->bindValue(2, $_POST['descripcion']);
        $sql->bindValue(3, $_POST['precio']);
        $sql->bindValue(4, $foto);
        $sql->bindValue(5, $_POST['idPin']);
        $sql->execute();
    }

    public function estadoPintura($idPin, $estado) {
        $conn = parent::conexion();

        if($_POST['est']== 0) {
            $estado = 1;
        } else {
            $estado = 0;
        }

        $sql = "UPDATE PINTURA SET estado = ? where idPin = ?";

        $sql->$conn->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $idPin);
        $sql->execute();

    }

    public function eliminarPintura($idPin) {
        $conn = parent::conexion();

        $sql = "DELETE FROM PINTURA WHERE idPin = ?";

        $sql->$conn->prepare($sql);
        $sql->bindValue(1, $idPin);
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
