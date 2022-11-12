 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Inventario / Productos</h1>
             </div><!-- /.col -->
             <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                     <li class="breadcrumb-item active">Inventario / Productos</li>
                 </ol>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">

         <!-- row para criterios de busqueda -->
         <div class="row">

             <div class="col-lg-12">

                 <div class="card card-info">
                     <div class="card-header">
                         <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>
                         <div class="card-tools">
                             <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                             </button>
                             <button type="button" class="btn btn-tool text-danger" id="btnLimpiarBusqueda">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div> <!-- ./ end card-tools -->
                     </div> <!-- ./ end card-header -->
                     <div class="card-body">

                         <div class="row">

                            <div class="col-lg-12 d-lg-flex">

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptCodigoBarras"
                                            class="form-control"
                                            data-index="2">
                                    <label for="iptCodigoBarras">Código de Barras</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptCategoria"
                                            class="form-control"
                                            data-index="4">
                                    <label for="iptCategoria">Categoría</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptProducto"
                                            class="form-control"
                                            data-index="5">
                                    <label for="iptProducto">Producto</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptPrecioVentaDesde"
                                            class="form-control">
                                    <label for="iptPrecioVentaDesde">P. Venta Desde</label>
                                </div>

                                <div style="width: 20%;" class="form-floating mx-1">
                                    <input 
                                            type="text" 
                                            id="iptPrecioVentaHasta"
                                            class="form-control">
                                    <label for="iptPrecioVentaHasta">P. Venta Hasta</label>
                                </div>
                            </div>

                         </div>
                     </div> <!-- ./ end card-body -->
                 </div>

             </div>
             
         </div>

         <!-- row para listado de productos/inventario -->
         <div class="row">
             <div class="col-lg-12">
                 <table id="tbl_productos" class="table table-striped w-100 shadow">
                     <thead class="bg-info">
                         <tr style="font-size: 15px;">
                             <th></th>
                             <th>id</th>
                             <th>Codigo</th>
                             <th>Id Categoria</th>
                             <th>Categoría</th>
                             <th>Producto</th>
                             <th>P. Compra</th>
                             <th>P. Venta</th>
                             <th>Utilidad</th>
                             <th>Stock</th>
                             <th>Min. Stock</th>
                             <th>Ventas</th>
                             <th>Fecha Creación</th>
                             <th>Fecha Actualización</th>
                             <th class="text-cetner">Opciones</th>
                         </tr>
                     </thead>
                     <tbody class="text-small">
                     </tbody>
                 </table>
             </div>
         </div>
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->

 <!-- Ventana Modal para ingresar o modificar un Productos -->
<div class="modal fade" id="mdlGestionarProducto" role="dialog">

    <div class="modal-dialog modal-lg">

        <!-- contenido del modal -->
        <div class="modal-content">

            <!-- cabecera del modal -->
            <div class="modal-header bg-gray py-1 align-items-center">
                <h5 class="modal-title">Agregar Producto</h5>
                <button type="button" class="btn btn-outline-primary text-white border-0 fs-5" data-bs-dismiss="modal" id="btnCerrarModal">
                        <i class="far fa-times-circle"></i>
                </button>
            </div>

            <!-- cuerpo del modal -->
            <div class="modal-body">

                <!-- Abrimos una fila -->
                <div class="row">

                    <!-- Columna para registro del codigo de barras -->
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="" for="iptCodigoReg"><i class="fas fa-barcode fs-6"></i>
                                <span class="small">Código de Barras</span><span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="iptCodigoReg"
                                name="iptCodigoReg" placeholder="Código de Barras" required>
                            <span id="validate_codigo" class="text-danger small fst-italic"
                                style="display:none">Debe Ingresar el Codigo de barras</span>
                        </div>
                    </div>

                    <!-- Columna para registro de la categoría del producto -->
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="" for="selCategoriaReg"><i class="fas fa-dumpster fs-6"></i>
                                <span class="small">Categoría</span><span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                id="selCategoriaReg">
                            </select>
                            <span id="validate_categoria" class="text-danger small fst-italic"
                                style="display:none">Debe Ingresar la categoria del producto</span>
                        </div>
                    </div>

                    <!-- Columna para registro de la descripción del producto -->
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="" for="iptDescripcionReg"><i
                                    class="fas fa-file-signature fs-6"></i> <span
                                    class="small">Descripción</span><span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="iptDescripcionReg"
                                placeholder="Descripción">
                            <span id="validate_descripcion" class="text-danger small fst-italic"
                                style="display:none">Debe Ingresar la descripción del producto</span>
                        </div>
                    </div>

                    <!-- Columna para registro del Precio de Compra -->
                    <div class="col-lg-4">
                        <div class="form-group mb-2">
                            <label class="" for="iptPrecioCompraReg"><i
                                    class="fas fa-dollar-sign fs-6"></i> <span class="small">Precio
                                    Compra</span><span class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control form-control-sm"
                                id="iptPrecioCompraReg" placeholder="Precio de Compra">
                            <span id="validate_precio_compra" class="text-danger small fst-italic"
                                style="display:none">Debe ingresar el precio de compra</span>
                        </div>
                    </div>

                    <!-- Columna para registro del Precio de Venta -->
                    <div class="col-lg-4">
                        <div class="form-group mb-2">
                            <label class="" for="iptPrecioVentaReg"><i
                                    class="fas fa-dollar-sign fs-6"></i> <span class="small">Precio
                                    Venta</span><span class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control form-control-sm" id="iptPrecioVentaReg"
                                placeholder="Precio de Venta">
                            <span id="validate_precio_venta" class="text-danger small fst-italic"
                                style="display:none">Debe ingresar el precio de venta</span>
                        </div>
                    </div>

                    <!-- Columna para registro de la Utilidad -->
                    <div class="col-lg-4">
                        <div class="form-group mb-2">
                            <label class="" for="iptUtilidadReg"><i
                                    class="fas fa-dollar-sign fs-6"></i> <span class="small">Utilidad</span></label>
                            <input type="number" min="0" class="form-control form-control-sm" id="iptUtilidadReg"
                                placeholder="Utilidad" disabled>
                        </div>
                    </div>

                    <!-- Columna para registro del Stock del producto -->
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockReg"><i class="fas fa-plus-circle fs-6"></i>
                                <span class="small">Stock</span><span class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control form-control-sm" id="iptStockReg"
                                placeholder="Stock">
                            <span id="validate_stock" class="text-danger small fst-italic" style="display:none">Debe
                                ingresar el stock del producto</span>
                        </div>
                    </div>

                    <!-- Columna para registro del Minimo de Stock -->
                    <div class="col-lg-6">
                        <div class="form-group mb-2">
                            <label class="" for="iptMinimoStockReg"><i
                                    class="fas fa-minus-circle fs-6"></i> <span class="small">Mínimo
                                    Stock</span><span class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control form-control-sm" id="iptMinimoStockReg"
                                placeholder="Mínimo Stock">
                            <span id="validate_min_stock" class="text-danger small fst-italic"
                                style="display:none">Debe ingresar el mínimo de stock del producto</span>
                        </div>
                    </div>

                     <!-- creacion de botones para cancelar y guardar el producto -->
                     <button type="button" class="btn btn-danger mt-3 mx-2" style="width:170px;"
                        data-bs-dismiss="modal" id="btnCancelarRegistro">Cancelar</button>

                    <button type="button" style="width:170px;" class="btn btn-primary mt-3 mx-2"
                        id="btnGuardarProducto" onclick="formSubmitClick()">Guardar Producto</button>

                </div>

            </div>

        </div>
    </div>
</div>


<script>

    var accion;
    var table;
    
    var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000
    });

    

    $(document).ready(function() {

        $.ajax({
            url: "ajax/productos.ajax.php",
            type: "POST",
            data: {
                'accion': 1
            }, //1: LISTAR PRODUCTOS
            dataType: 'json',
            success: function(respuesta) {
                console.log("respuesta", respuesta);
            }
        });

        //SOLICITUD AJAX PARA CARGAR SELECT DE CATEGORIAS
        $.ajax({
            url: "ajax/categorias.ajax.php",
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(respuesta) {

                var options = '<option selected value="0">Seleccione una categoría</option>';

                for (let index = 0; index < respuesta.length; index++) {
                    options = options + '<option value=' + respuesta[index][0] + '>' + respuesta[index][1] + '</option>';
                }

                $("#selCategoriaReg").html(options);
            }
        });
        
        /*===================================================================*/
        // CARGA DEL LISTADO CON EL PLUGIN DATATABLE JS
        /*===================================================================*/
        table = $("#tbl_productos").DataTable({

            dom: 'Bfrtip',
            buttons: [{
                    text: 'Agregar Producto',
                    className: 'addNewRecord',
                    action: function(e, dt, node, config) {
                        $("#mdlGestionarProducto").modal('show');
                        accion = 2; //registrar
                    }
                },
                'excel', 'print', 'pageLength'
            ],
            pageLength: [5, 10, 15, 30, 50, 100],
            pageLength: 10,
            ajax: {
                url: "ajax/productos.ajax.php",
                dataSrc: '',
                type: "POST",
                data: {
                    'accion': 1
                }, //1: LISTAR PRODUCTOS
            },
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [{
                    targets: 0,
                    orderable: false,
                    className: 'control'
                },
                {
                    targets: 1,
                    visible: false
                },
                {
                    targets: 3,
                    visible: false
                },
                {
                    targets: 9,
                    createdCell: function(td, cellData, rowData, row, col){
                        if(parseFloat(rowData[9]) <= parseFloat(rowData[10])){
                            $(td).parent().css('background','#FF5733')
                        }
                    }
                },
                {
                    targets: 11,
                    visible: false
                },
                {
                    targets: 12,
                    visible: false
                },
                {
                    targets: 13,
                    visible: false
                },
                {
                    targets: 14,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return "<center>" +
                            "<span class='btnEditarProducto text-primary px-1' style='cursor:pointer;'>" +
                            "<i class='fas fa-pencil-alt fs-5'></i>" +
                            "</span>" +
                            "<span class='btnAumentarStock text-success px-1' style='cursor:pointer;'>" +
                            "<i class='fas fa-plus-circle fs-5'></i>" +
                            "</span>" +
                            "<span class='btnDisminuirStock text-warning px-1' style='cursor:pointer;'>" +
                            "<i class='fas fa-minus-circle fs-5'></i>" +
                            "</span>" +
                            "<span class='btnEliminarProducto text-danger px-1' style='cursor:pointer;'>" +
                            "<i class='fas fa-trash fs-5'></i>" +
                            "</span>" +
                            "</center>"
                    }
                }

            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });

        /*===================================================================*/
        // EVENTOS PARA CRITERIOS DE BUSQUEDA (CODIGO, CATEGORIA Y PRODUCTO)
        /*===================================================================*/
        $("#iptCodigoBarras").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
        })

        $("#iptCategoria").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
        })

        $("#iptProducto").keyup(function(){
            table.column($(this).data('index')).search(this.value).draw();
        })

        /*===================================================================*/
        // EVENTOS PARA CRITERIOS DE BUSQUEDA POR RANGO (PREVIO VENTA)
        /*===================================================================*/
        $("#iptPrecioVentaDesde, #iptPrecioVentaHasta").keyup(function(){
            table.draw();
        })

        $.fn.dataTable.ext.search.push(

            function(settings, data, dataIndex){

                var precioDesde = parseFloat($("#iptPrecioVentaDesde").val());
                var precioHasta = parseFloat($("#iptPrecioVentaHasta").val());

                var col_venta = parseFloat(data[7]);

                if((isNaN(precioDesde) && isNaN(precioHasta)) ||
                    (isNaN(precioDesde) && col_venta <=  precioHasta) ||
                    (precioDesde <= col_venta && isNaN(precioHasta)) ||
                    (precioDesde <= col_venta && col_venta <= precioHasta)){
                        return true;
                }

                return false;
            }
        )

        /*===================================================================*/
        // EVENTO PARA LIMPIAR INPUTS DE CRITERIOS DE BUSQUEDA
        /*===================================================================*/
        $("#btnLimpiarBusqueda").on('click',function(){
            
            $("#iptCodigoBarras").val('')
            $("#iptCategoria").val('')
            $("#iptProducto").val('')
            $("#iptPrecioVentaDesde").val('')
            $("#iptPrecioVentaHasta").val('')

            table.search('').columns().search('').draw();
        })

        $("#btnCancelarRegistro, #btnCerrarModal").on('click', function() {

            $("#validate_codigo").css("display", "none");
            $("#validate_categoria").css("display", "none");
            $("#validate_descripcion").css("display", "none");
            $("#validate_precio_compra").css("display", "none");
            $("#validate_precio_venta").css("display", "none");
            $("#validate_stock").css("display", "none");
            $("#validate_min_stock").css("display", "none");

            $("#iptCodigoReg").val("");
            $("#selCategoriaReg").val(0);
            $("#iptDescripcionReg").val("");
            $("#iptPrecioCompraReg").val("");
            $("#iptPrecioVentaReg").val("");
            $("#iptUtilidadReg").val("");
            $("#iptStockReg").val("");
            $("#iptMinimoStockReg").val("");

        })

        $("#iptPrecioCompraReg, #iptPrecioVentaReg").keyup(function() {
            calcularUtilidad();
        });

        $("#iptPrecioCompraReg, #iptPrecioVentaReg").change(function() {
            calcularUtilidad();
        });



    })


    // CALCULA LA UTILIDAD
    function calcularUtilidad() {

        var iptPrecioCompraReg = $("#iptPrecioCompraReg").val();
        var iptPrecioVentaReg = $("#iptPrecioVentaReg").val();
        var Utilidad = iptPrecioVentaReg - iptPrecioCompraReg;
        $("#iptUtilidadReg").val(Utilidad.toFixed(2));

    }

    function formSubmitClick() {

        //validar ingreso de campos o inputs


        Swal.fire({
            title: 'Está seguro de registrar el producto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, deseo registrarlo!',
            cancelButtonText: 'Cancelar',
        }).then((result) => {

            if (result.isConfirmed) {

                var datos = new FormData();

                datos.append("accion", accion);
                datos.append("codigo_producto", $("#iptCodigoReg").val()); //codigo_producto
                datos.append("id_categoria_producto", $("#selCategoriaReg").val()); //id_categoria_producto
                datos.append("descripcion_producto", $("#iptDescripcionReg").val()); //descripcion_producto
                datos.append("precio_compra_producto", $("#iptPrecioCompraReg").val()); //precio_compra_producto
                datos.append("precio_venta_producto", $("#iptPrecioVentaReg").val()); //precio_venta_producto
                datos.append("utilidad", $("#iptUtilidadReg").val()); //utilidad
                datos.append("stock_producto", $("#iptStockReg").val()); //stock_producto
                datos.append("minimo_stock_producto", $("#iptMinimoStockReg").val()); //minimo_stock_producto  
                datos.append("ventas_producto", 0); //ventas_producto
                // datos.append("fecha_actualizacion_producto");//fecha_actualizacion_producto

                $.ajax({
                    url: "ajax/productos.ajax.php",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(respuesta) {
                         console.log(respuesta)

                        if (respuesta == "ok") {
                            
                            Toast.fire({
                                icon: 'success',
                                title: 'El producto se registró correctamente'
                            });

                            table.ajax.reload();

                            $("#mdlGestionarProducto").modal('hide');

                            $("#iptCodigoReg").val("");
                            $("#selCategoriaReg").val(0);
                            $("#iptDescripcionReg").val("");
                            $("#iptPrecioCompraReg").val("");
                            $("#iptPrecioVentaReg").val("");
                            $("#iptUtilidadReg").val("");
                            $("#iptStockReg").val("");
                            $("#iptMinimoStockReg").val("");

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'El producto no se pudo registrar'
                            });
                        }

                    }
                });

            }
        })
    }
 </script>