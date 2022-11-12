<?php


class CategoriasControlador{

    static public function ctrListarCategorias(){

        $categorias = CategoriasModelo:: mldListarCategorias();

        return $categorias;

    }
}