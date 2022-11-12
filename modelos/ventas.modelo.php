<?php

require_once "conexion.php";

class VentasModelo{
    
    public $resultado;

    static public function mdlObtenerNroBoleta(){

        $stmt = Conexion::conectar()->prepare("call prc_obtenerNroBoleta()");

        $stmt -> execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    static public function mdlRegistrarVenta($datos,$nro_boleta,$total_venta,$descripcion_venta){


        //Los parametros recibidos del controlador lo usamos como valores y asi registrar en la tabla VENTA_CABECERA
        //Un nuevo registro 
        $stmt = Conexion::conectar()->prepare("INSERT INTO venta_cabecera(nro_boleta,descripcion,total_venta)         
                                                VALUES(:nro_boleta,:descripcion,:total_venta)");

        $stmt -> bindParam(":nro_boleta", $nro_boleta , PDO::PARAM_STR);
        $stmt -> bindParam(":descripcion", $descripcion_venta, PDO::PARAM_STR);
        $stmt -> bindParam(":total_venta", $total_venta , PDO::PARAM_STR);
        
         
        //Si se ejecuto correctamente la variable $stmt entonces ejecuta
        if($stmt -> execute()){
            
            $stmt = null;
            
            //Actualizamo el numero_correlativo_ventas en la tabla empresa
            $stmt = Conexion::conectar()->prepare("UPDATE empresa SET nro_correlativo_venta = LPAD(nro_correlativo_venta + 1,8,'0')");

            

            if($stmt -> execute()){//si se realizo con exito 

                $listaProductos = [];//declaramos un arreglo vacio


                //Antes de registrar EJECUTAMOS un Foreach que nos permita contar cuantos arreglos recibimos en la variable $datos
                for ($i = 0; $i < count($datos); ++$i){


                    //exportamos a una variable $listarProductos los datos recibidos por el foreach le asignamos un indice 
                    $listaProductos = explode(",",$datos[$i]);
        
                    $stmt = Conexion::conectar()->prepare("INSERT INTO venta_detalle(nro_boleta,codigo_producto, cantidad, total_venta) 
                                                        VALUES(:nro_boleta,:codigo_producto,:cantidad,:total_venta)");
        
                    //asignamos a string el valor de cada campo optenido en el foreach

                    $stmt -> bindParam(":nro_boleta", $nro_boleta , PDO::PARAM_STR);
                    $stmt -> bindParam(":codigo_producto", $listaProductos[0] , PDO::PARAM_STR);
                    $stmt -> bindParam(":cantidad", $listaProductos[1] , PDO::PARAM_STR);
                    $stmt -> bindParam(":total_venta", $listaProductos[2] , PDO::PARAM_STR);
        
                    
                     
                    if($stmt -> execute()){

                        $stmt = null;
                        //conectamos con nuestra DB y ejecutamos un UPDATE logrando asi actualizar el campo stock y cantidad
                        $stmt = Conexion::conectar()->prepare("UPDATE PRODUCTOS SET stock_producto = stock_producto - :cantidad, ventas_producto = ventas_producto + :cantidad
                                                                WHERE codigo_producto = :codigo_producto");
        
                        $stmt -> bindParam(":codigo_producto", $listaProductos[0] , PDO::PARAM_STR);
                        $stmt -> bindParam(":cantidad", $listaProductos[1] , PDO::PARAM_STR);
        
                        if($stmt -> execute()){
                            $resultado = "Registro de Venta Correctamente.";
                        }else{
                            $resultado = "Error al actualizar el stock";
                        }
                        
                    }else{
                        $resultado = "Error al Registrar la Venta";
                    }   
                }
        
        
                 return $resultado;
        
                 $stmt = null;
            }
            
        }

       
    }

}