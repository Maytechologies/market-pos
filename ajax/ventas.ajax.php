<?php

//Requerimos las carpetas y archivos necesarios CONTROLADORES Y MODELOS (VENTAS)
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";


class AjaxVentas{

    public function ajaxObtenerNroBoleta(){

        $nroBoleta = VentasControlador::ctrObtenerNroBoleta();

        echo json_encode($nroBoleta,JSON_UNESCAPED_UNICODE);

    }

    public function ajaxRegistrarVenta($datos,$nro_boleta,$total_venta, $descripcion_venta){


        //Solicitamos al controlador VentasControlador con parametros del array y campos adicionales del modulo de ventas
        $registroVenta = VentasControlador::ctrRegistrarVenta($datos,$nro_boleta,$total_venta, $descripcion_venta);

        //la repuesta optenida del MODELO la retornamos unicamente como datos codificados en fromato JSON 
        echo json_encode($registroVenta,JSON_UNESCAPED_UNICODE);

    }





}//End AjaxVentas

//EJECUTAMOS LAS FUNCIONES QUE SE ENCUENTRA EN AjaxVentas

if(isset($_POST["accion"]) && $_POST["accion"] == 1){
	
	$nroBoleta = new AjaxVentas();
    $nroBoleta -> ajaxObtenerNroBoleta();

}else {
    if ((isset($_POST["arr"]))){
        //llamamos a la clase AjaxVentas
        $registrar = new AjaxVentas();
        //Ejecutamos el metodo ajaxRegistrarVentas concatenamos el Arrau [arr] y datos adicionales y los enviamos como parametros
        $registrar -> ajaxRegistrarVenta($_POST["arr"],$_POST['nro_boleta'], $_POST['total_venta'], $_POST['descripcion_venta']);
    }

    
}





