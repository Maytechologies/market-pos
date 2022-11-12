

var table;
var items = []; // SE USA PARA EL INPUT DE AUTOCOMPLETE
var itemProducto = 1;

$(document).ready(function(){


 /* ======================================================================================
 INICIALIZAR LA TABLA DE VENTAS
 ======================================================================================*/
    table = $('#lstProductosVenta').DataTable({
        "columns": [
            {"data": "id" },
            {"data": "codigo_producto" },
            {"data": "id_categoria" },
            {"data": "nombre_categoria" },
            {"data": "descripcion_producto" },
            {"data": "cantidad" },
            {"data": "precio_venta_producto" },
            {"data": "total" },
            {"data": "acciones" },
            {"data": "aplica_peso" },
            {"data": "precio_oferta_producto" },
            {"data": "precio_mayor_producto" }
        ],
        columnDefs: [{
                targets: 0,
                visible: false
            },
            {
                targets: 3,
                visible: false
            },
            {
                targets: 2,
                visible: false
            },
            {
                targets: 6,
                orderable: false
            },
            {
                targets: 9,
                visible: false
            },
            {
                targets: 10,
                visible: false
            },
            {
                targets: 11,
                visible: false
            }
        ],
        "order": [
            [0, 'desc']
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });

    /* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE AUTOCOMPLETADO
    ======================================================================================*/
    $.ajax({
        async: false,
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: {
            'accion': 6
        },
        dataType: 'json',
        success: function(respuesta) {

            for (let i = 0; i < respuesta.length; i++) {
                items.push(respuesta[i]['descripcion_producto'])
            }

            $("#iptCodigoVenta").autocomplete({

                source: items,
                select: function(event, ui) {

                    // console.log("🚀 ~ file: ventas.php ~ line 313 ~ $ ~ ui.item.value", ui.item.value)
                    CargarProductos(ui.item.value);                                    
                    
                    
                    $("#iptCodigoVenta").val("");

                    $("#iptCodigoVenta").focus();

                    return false;
                }
            })


        }
    });

    /* ======================================================================================
    == EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESA EL CODIGO DE BARRAS
    ======================================================================================*/
    $("#iptCodigoVenta").change(function() {
        CargarProductos();        
    });

    /* ======================================================================================
    == EVENTO PARA ELIMINAR UN PRODUCTO DEL LISTADO
    ======================================================================================*/
    $('#lstProductosVenta tbody').on('click', '.btnEliminarproducto', function() {
        table.row($(this).parents('tr')).remove().draw();
        recalcularTotales();
    });

    /* ======================================================================================
    EVENTO PARA INGRESAR EL PESO DEL PRODUCTO
    ====================================================================================== */
   $('#lstProductosVenta tbody').on('click', '.btnIngresarPeso', function() {

    var data = table.row($(this).parents('tr')).data();

    Swal.fire({
        title: "",
        text: "Peso del Producto (Grms):",
        input: 'text',
        width: 300,
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        
    }).then((result) => {

        if (result.value) {
            
            cantidad = result.value;

            var idx = table.row($(this).parents('tr')).index();

            table.cell(idx, 5).data(cantidad + ' Kg(s)').draw();

            NuevoPrecio = ((parseFloat(data['cantidad']) * data['precio_venta_producto'].replace("$ ", "")).toFixed(2));
            NuevoPrecio = "$ " + NuevoPrecio;

            table.cell(idx, 7).data(NuevoPrecio).draw();

            recalcularTotales();

        }

    });


   });

   
     /* ======================================================================================
    EVENTO PARA INGRESAR EL PESO DEL PRODUCTO
    ====================================================================================== */
    $('#lstProductosVenta tbody').on('click', '.btnIngresarPeso', function() {

            var data = table.row($(this).parents('tr')).data();

            Swal.fire({
                title: "",
                text: "Peso del Producto (Grms):",
                input: 'text',
                width: 300,
                confirmButtonText: 'Aceptar',
                showCancelButton: true,
            }).then((result) => {

                if (result.value) {
                    
                    cantidad = result.value;

                    var idx = table.row($(this).parents('tr')).index();

                    table.cell(idx, 5).data(cantidad + ' Kg(s)').draw();

                    NuevoPrecio = ((parseFloat(data['cantidad']) * data['precio_venta_producto'].replace("$", "")).toFixed(2));
                    NuevoPrecio = "$" + NuevoPrecio;

                    table.cell(idx, 7).data(NuevoPrecio).draw();

                    recalcularTotales();

                }

            });


     });


    /* ======================================================================================
    == EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
    ====================================================================================== */
    $('#lstProductosVenta tbody').on('click', '.btnAumentarCantidad', function() {


        var data = table.row($(this).parents('tr')).data(); //Recuperar los datos de la fila

        var idx = table.row($(this).parents('tr')).index();  // Recuperar el Indice de la Fila

        var codigo_producto = data['codigo_producto'];
        var cantidad = data['cantidad'];

        $.ajax({
            async: false,
            url: "ajax/productos.ajax.php",
            method: "POST",
            data: {
                'accion': 8,
                'codigo_producto': codigo_producto,
                'cantidad_a_comprar': cantidad
            },

            dataType: 'json',
            success: function(respuesta) {

            if (parseInt(respuesta['existe']) == 0) {

                Toast.fire({
                    icon: 'error',
                    title: ' El producto ' + data['descripcion_producto'] + ' YA no Tiene Stock Suficiente'
                })

                $("#iptCodigoVenta").val("");// limpiamos el input de busqueda de producto ("codigoVenta")
                $("#iptCodigoVenta").focus();// Mantenemos el focus en el input 

            } else {

                cantidad = parseInt(data['cantidad']) + 1;// capturamos la cantiadad actual y le sumamos 1 

                table.cell(idx, 5).data(cantidad + ' Und(s)').draw();


                               // la columna cantidad la multiplicamos por el precio de venta
                NuevoPrecio = (parseInt(data['cantidad']) * data['precio_venta_producto'].replace("$", "")).toFixed(2);

                // le asignamos el simbolo de moneda al nuevoPrecio
                NuevoPrecio = "$" + NuevoPrecio;
                
                table.cell(idx, 7).data(NuevoPrecio).draw();

                recalcularTotales(); //ejecutamos la funcion recalcularTotales
              }
           }
        });


    }); //FINAL AUMENTAR CANTIDAD

    /* ======================================================================================
    EVENTO PARA DESMINUIR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
    ======================================================================================*/
   $('#lstProductosVenta tbody').on('click', '.btnDisminuirCantidad', function() {

        var data = table.row($(this).parents('tr')).data();

        if (data['cantidad'].replace('Und(s)', '') >= 2) {// si la cantidad en stock es mayor a 2 podra disminuir

            cantidad = parseInt(data['cantidad'].replace('Und(s)', '')) - 1;// restamo una unidad por cada click

            var idx = table.row($(this).parents('tr')).index();//capturamos por medio del index 5 de nuestra tabla

            table.cell(idx, 5).data(cantidad + ' Und(s)').draw();//indico que a la tabla en la celda 5 seteamos  la nueva  cantidad 

            NuevoPrecio = (parseInt(data['cantidad']) * data['precio_venta_producto'].replace("$", "")).toFixed(2);
            NuevoPrecio = "$" + NuevoPrecio;

            table.cell(idx, 7).data(NuevoPrecio).draw();

      }

     recalcularTotales();
  });

   /* ======================================================================================
    EVENTO PARA MODIFICAR EL PRECIO DE VENTA DEL PRODUCTO
    ======================================================================================*/
    $('#lstProductosVenta tbody').on('click', '.dropdown-item', function() { 
        
        codigo_producto = $(this).attr("codigo");
        precio_venta = parseFloat($(this).attr("precio").replaceAll("$","")).toFixed(2);
        
        recalcularMontos(codigo_producto,precio_venta);
    });

  




}) /* END DOCUMENT READY */

 /*===================================================================*/
//FUNCION PARA RECALCULAR MOTOS DEL PRODUCTO EN LISTA
/*===================================================================*/
function recalcularMontos(codigo_producto,  precio_venta){
    table.rows().eq(0).each(function(index) {

        var row = table.row(index);

        var data = row.data();

        if (data['codigo_producto'] == codigo_producto){

            //AUMENTAR EN UN EL VALOR DE LA CANTIDAD
            table.cell(index, 6).data("$" + parseFloat(precio_venta).toFixed(2)).draw();
            
            // ACTUALIZA EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
            nuevoPrecio = (parseFloat(data['cantidad']) * data['precio_venta_producto'].replaceAll("$", "")).toFixed(2);
            nuevoPrecio = "$" + nuevoPrecio;
            table.cell(index, 7).data(NuevoPrecio).draw();

        }

    });

    //RECALCULAMOS TOTALES 
    recalcularTotales();
}

/*===================================================================*/
//FUNCION PARA RECALCULAR LOS TOTALES DE VENTA
/*===================================================================*/
function recalcularTotales(){

var TotalVenta = 0.00;

table.rows().eq(0).each(function(index) {

    var row = table.row(index);
    var data = row.data();

    TotalVenta = parseFloat(TotalVenta) + parseFloat(data['total'].replace("$", ""));

});

$("#totalVenta").html("");
$("#totalVenta").html(TotalVenta.toFixed(2));

var totalVenta = $("#totalVenta").html();
var impuesto = parseFloat(totalVenta) * 0.19
var subtotal = parseFloat(totalVenta) - parseFloat(impuesto);

$("#totalVentaRegistrar").html(totalVenta);

$("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
$("#boleta_impuesto").html(parseFloat(impuesto).toFixed(2));
$("#boleta_total").html(parseFloat(totalVenta).toFixed(2));

//limpiamos el input de efectivo exacto; desmarcamos el check de efectivo exacto
//borramos los datos de efectivo entregado y vuelto
$("#iptEfectivoRecibido").val("");
$("#chkEfectivoExacto").prop('checked', false);
$("#EfectivoEntregado").html("0.00");
$("#Vuelto").html("0.00");

$("#iptCodigoVenta").val("");
$("#iptCodigoVenta").focus();

}/*Fin Recalcular Totales*/

/*===================================================================*/
//FUNCION PARA CARGAR PRODUCTOS EN EL DATATABLE
/*===================================================================*/
function CargarProductos(producto = "") {

    if (producto != "") {
        var codigo_producto = producto;
        
    } else {
        var codigo_producto = $("#iptCodigoVenta").val();
    }

    var producto_repetido = 0;

    /*===================================================================*/
    // AUMENTAMOS LA CANTIDAD SI EL PRODUCTO YA EXISTE EN EL LISTADO
    /*===================================================================*/
    table.rows().eq(0).each(function(index) {

        var row = table.row(index);
        var data = row.data();

        if (parseInt(codigo_producto) == data['codigo_producto']) {

            producto_repetido = 1;

            $.ajax({
                async: false,
                url: "ajax/productos.ajax.php",
                method: "POST",
                data: {
                    'accion': 8,
                    'codigo_producto': data['codigo_producto'],
                    'cantidad_a_comprar': data['cantidad']
                },
                dataType: 'json',
                success: function(respuesta) {

                    if (parseInt(respuesta['existe']) == 0) {

                        Toast.fire({
                            icon: 'error',
                            title: ' El producto ' + data['descripcion_producto'] + ' ya no tiene stock'
                        })

                        $("#iptCodigoVenta").val("");
                        $("#iptCodigoVenta").focus();
                        

                    } else {

                        // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
                        table.cell(index, 5).data(parseFloat(data['cantidad']) + 1 + ' Und(s)').draw();

                        // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
                        NuevoPrecio = (parseInt(data['cantidad']) * data['precio_venta_producto'].replace("S./ ", "")).toFixed(2);
                        NuevoPrecio = "S./ " + NuevoPrecio;
                        table.cell(index, 7).data(NuevoPrecio).draw();

                        // RECALCULAMOS TOTALES
                        recalcularTotales();
                    }
                }
            });

        }
    });

    if(producto_repetido == 1){
        return;   
    } 

    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: {
            'accion': 7, //BUSCAR PRODUCTOS POR SU CODIGO DE BARRAS
            'codigo_producto': codigo_producto
        },
        dataType: 'json',
        success: function(respuesta) {
            
            /*===================================================================*/
            //SI LA RESPUESTA ES VERDADERO, TRAE ALGUN DATO
            /*===================================================================*/
            if (respuesta) {

                var TotalVenta = 0.00;

                if (respuesta['aplica_peso'] == 1) {

                    table.row.add({
                        'id': itemProducto,
                        'codigo_producto':respuesta['codigo_producto'],
                        'id_categoria':respuesta['id_categoria'],
                        'nombre_categoria': respuesta['nombre_categoria'],
                        'descripcion_producto':respuesta['descripcion_producto'],
                        'cantidad': respuesta['cantidad'] + ' Kg(s)',
                        'precio_venta_producto': respuesta['precio_venta_producto'],
                        'total': respuesta['total'],
                        'acciones':"<center>" +
                        "<span class='btnIngresarPeso text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                        "<i class='fas fa-balance-scale fs-5'></i> " +
                        "</span> " +
                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                        "<i class='fas fa-trash fs-5'> </i> " +
                        "</span>" +

                        "<div class='btn-group'>" +
                            "<button type='button' class=' p-0 btn btn-primary transparentbar dropdown-toggle btn-sm' data-bs-toggle='dropdown' aria-expanded='false' style='background-image: none; background-color: transparent; border:none;'>" +
                            "<i class='fas fa-cog text-primary fs-5'></i> <i class='fas fa-chevron-down text-primary'></i>" +
                            "</button>" +

                            "<ul class='dropdown-menu'>" +
                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_venta_producto'] + "' style='cursor:pointer; font-size:14px;'>Normal ($ " + respuesta['precio_venta_producto'] + ")</a></li>" +
                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_oferta_producto'] + "' style='cursor:pointer; font-size:14px;'>Oferta ($ " + parseFloat(respuesta['precio_oferta_producto']).toFixed(2) + ")</a></li>" +
                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_mayor_producto'] + "' style='cursor:pointer; font-size:14px;'>Por Mayor ($ " + parseFloat(respuesta['precio_mayor_producto']).toFixed(2) + ")</a></li>" +
                            "</ul>" +
                        "</div>" +

                        "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'precio_oferta_producto': respuesta['precio_oferta_producto'],
                        'precio_mayor_producto': respuesta['precio_mayor_producto']
                    }).draw();

                    itemProducto = itemProducto + 1;

                } else {

                    table.row.add({
                        'id': itemProducto,
                        'codigo_producto': respuesta['codigo_producto'],
                        'id_categoria': respuesta['id_categoria'],
                        'nombre_categoria': respuesta['nombre_categoria'],
                        'descripcion_producto': respuesta['descripcion_producto'],
                        'cantidad': respuesta['cantidad'] + ' Und(s)',
                        'precio_venta_producto': respuesta ['precio_venta_producto'],
                        'total': respuesta['total'],
                        'acciones':"<center>" +
                        "<span class='btnAumentarCantidad text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                        "<i class='fas fa-cart-plus fs-5'></i> " +
                        "</span> " +
                        "<span class='btnDisminuirCantidad text-warning px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Disminuir Stock'> " +
                        "<i class='fas fa-cart-arrow-down fs-5'></i> " +
                        "</span> " +
                        "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                        "<i class='fas fa-trash fs-5'> </i> " +
                        "</span>" +

                        "<div class='btn-group'>" +
                        "<button type='button' class=' p-0 btn btn-primary transparentbar dropdown-toggle btn-sm' data-bs-toggle='dropdown' aria-expanded='false' style='background-image: none; background-color: transparent; border:none;'>" +
                            "<i class='fas fa-cog text-primary fs-5'></i> <i class='fas fa-chevron-down text-primary'></i>" +
                            "</button>" +

                            "<ul class='dropdown-menu'>" +
                            "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_venta_producto'] + "' style='cursor:pointer; font-size:14px;'>Normal ($ " + respuesta['precio_venta_producto'] + ")</a></li>" +
                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_oferta_producto'] + "' style='cursor:pointer; font-size:14px;'>Oferta ($ " + parseFloat(respuesta['precio_oferta_producto']).toFixed(2) + ")</a></li>" +
                                "<li><a class='dropdown-item' codigo = '" + respuesta['codigo_producto'] + "' precio=' " + respuesta['precio_mayor_producto'] + "' style='cursor:pointer; font-size:14px;'>Por Mayor ($ " + parseFloat(respuesta['precio_mayor_producto']).toFixed(2) + ")</a></li>" +
                            "</ul>" +
                        "</div>" +

                        "</center>",
                        'aplica_peso': respuesta['aplica_peso'],
                        'precio_oferta_producto': respuesta['precio_oferta_producto'],
                        'precio_mayor_producto': respuesta['precio_mayor_producto']
                    }).draw();

                    itemProducto = itemProducto + 1;

                }

                /*************************************/
                //  Recalculamos el total de la venta
                /*************************************/
                table.rows().eq(0).each(function(index) {
                    var row = table.row(index);

                    var data = row.data();
                    TotalVenta = parseFloat(TotalVenta) + parseFloat(data['total'].replace("$", ""));

                 

                });

                /* TotalVenta = parseFloat(TotalVenta).toFixed(2); */

                $("#totalVenta").html("");
                $("#totalVenta").html(TotalVenta.toFixed(2));                                                    

                $("#iptCodigoVenta").val("");

                var impuesto = parseFloat(TotalVenta) * 0.19;
                var subtotal = parseFloat(TotalVenta) - parseFloat(impuesto);
                

                

                $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
                $("#boleta_impuesto").html(parseFloat(impuesto).toFixed(2));
                $("#boleta_total").html(parseFloat(TotalVenta).toFixed(2));

                $("#totalVentaRegistrar").html(TotalVenta.toFixed(2));
                $("#boleta_total").html(TotalVenta.toFixed(2));

            /*===================================================================*/
            //SI LA RESPUESTA ES FALSO, NO TRAE ALGUN DATO
            /*===================================================================*/
            } else {
                
                Toast.fire({
                    icon: 'error',
                    title: ' El producto no existe o no tiene stock'
                });

                $("#iptCodigoVenta").val("");
                $("#iptCodigoVenta").focus();

            }

        }
    });      

}/* FIN CargarProductos */