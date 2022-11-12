 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Carga Masiva de Productos</h1>
             </div><!-- /.col -->
             <div class="col-sm-6">
                 <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                     <li class="breadcrumb-item active">Carga Masiva de Productos</li>
                 </ol>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
         <div class="row">
             <div class="col-lg-12">

                 <!--  ROW END ELEMENTS IMPORT FILE -->
                 <div class="card card-info">
                     <div class="card-header">
                         <h3 class="card-title">Selecionar Archivos (Excel)</h3>
                         <div class="card-tools">
                             <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                 <i class="fas fa-minus"></i>
                             </button>
                             <button type="button" class="btn btn-tool" data-card-widget="remove">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div> <!-- ./ end card-tools -->
                     </div> <!-- ./ end card-header -->
                     <div class="card-body">
                         <form method="POST" enctype="multipart/form-data" id="form_carga_productos">
                             <div class="row">
                                 <div class="col-lg-10">
                                     <input type="file" name="fileProductos" id="fileProductos" class="form-control" accept=".xls, xlsx">
                                 </div>
                                 <div class="col-lg-2">
                                     <button type="submit" value="Cargar Productos" class="btn btn-primary" id="btnCargar">
                                         Importar
                                     </button>
                                 </div>
                             </div>
                         </form>
                     </div> <!-- ./ end card-body -->
                 </div><!--  /END ELEMENTS IMPORT FILE -->

                 <!--  ROW GIF FILE -->
                 <div class="row">
                     <div class="col-lg-12 text-center">
                         <img src="Vistas/assets/image/loading.gif" style="display: none;">
                     </div>
                 </div>

             </div>
         </div>

     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->

 <script>
     $(document).ready(function() {
         //Al hacer Click en el bototn Importar

         $("#form_carga_productos").on('submit', function(e) {

             e.preventDefault();

             /*==================================================*/
             //    VALIDAR QUE EL INPUT NO SE ENVIE VACIO
             /*==================================================*/

             if ($("#fileProductos").get(0).files.length == 0) {

                 Swal.fire({
                     position: 'center',
                     icon: 'warning',
                     title: 'Debe seleccionar un archivo (Excel).',
                     showConfirmButton: false,
                     timer: 2000
                 })

             }else{

            /*====================================================*/
             //  VALIDAR QUE EL FORMATO DEL ARCHIVO SEA XLS Ó XLSX
             /*====================================================*/
                var extensiones_permitidas = [".xlsx",".xls"];
                var input_file_productos = $("#fileProductos");
                var exp_reg = new RegExp("([a-zA-Z0-9\s_\\-.\:])+(" + extensiones_permitidas.join('|') + ")$");

                if(!exp_reg.test(input_file_productos.val().toLowerCase())){//si no cumple cel input file con el test
                    //Mostrar la siguiente Alerta
                    Swal.fire({
                        position:'center',
                        icon:'error',
                        title: 'Error Formato De Archivo no Permitido.!!',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    return false;

                }

                var datos = new FormData($(form_carga_productos)[0]);

                $("#btnCargar").prop("disabled",true);
                

                let timerInterval
                    Swal.fire({
                        title: 'Importando Archivo',
                        html: '<p style = "color:orange">Esperar por Favór</p>',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerRight()
                            }, 2000)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }

                    }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('I was closed by the time')
                     }
                    })



                    $.ajax({
                    url:"ajax/productos.ajax.php",
                    type: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success:function(respuesta){

                       /*  console.log("respuesta",respuesta); */
                        /* if(){ */
                        

                         //IF ARRAYS CATEGORIES AND PRODUCTS > 0 REGISTER 
                        if(respuesta['totalCategorias'] > 0 && respuesta['totalProductos'] > 0 ){
                        
                            Swal.fire({
                                position:'center',
                                icon:'success',
                                title: 'Se registraron ' + respuesta['totalCategorias'] + 'Categorias y' + respuesta['totalProductos'] + 'productos correctamente!',
                                showConfirmButton: false,
                                timer: 1000
                            })

                            $("#btnCargar").prop("disabled",false);
                            
                        }else{

                            Swal.fire({
                                position:'center',
                                icon:'error',
                                title: 'Se presento un error al momento de realizar el Registro de Categorías y/o Productos!',
                                showConfirmButton: false,
                                timer: 3000
                            })

                            $("#btnCargar").prop("disabled",false);
                           

                        }
                    }

                });



             }



         })/* fin form_carga */

        


     }) /* fin */
 </script>