<?php
require_once "conexion.php";

class CategoriasModelo{

    static public function mldListarCategorias(){
        $stmt = Conexion::conectar()->prepare(
        "SELECT id_categoria, nombre_categoria 
        FROM categorias c ORDER BY id_categoria DESC");
        $stmt ->execute();

        return $stmt->fetchAll();
    } 
}