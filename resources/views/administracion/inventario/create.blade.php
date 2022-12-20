@extends('layouts.base')

@section('content')

    {{-- INICIO DEL CUERPO --}}
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-0">
                  <div class="col-sm-6 mb-0">
                      <h1>Agregar producto en almacén</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="">Inicio</a></li>
                          <li class="breadcrumb-item"><a href="{{route('inventario.index')}}">Inventario</a></li>
                          <li class="breadcrumb-item active">Agregar producto</li>
                      </ol>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </section>
     
      @php
           {{$id_inventario = uniqid();}}
      @endphp
      <!-- Main content -->

      <section class="content">
        <div class="container-fluid">
            <form method="POST" id="form_inventario" name="form_inventario" action="{{ route('inventario.store') }}" autocomplete="off">
                @method('POST')
                @csrf
                <div class="card card-outline card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Agregar producto en almacén</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div><!--/.card-header-->

                    <div class="card-body">
                   
                        <!-- /input-group -->
                        <div class="form-group mb-0">
                            <div class="row">
                                <input type="hidden" id="id_producto" name="id_producto"/>
                                <input type="hidden" id="id_inventario" name="id_inventario" value="{{$id_inventario}}"/>

                                <div class="col-12 col-sm-4">
                                    <label >Producto</label> 
                                    <div class="input-group input-group-sm mb-0 eliminarbtn">
                                        <input type="text" class="form-control" id="nombre" name="nombre" data-toggle="tooltip" data-placement="bottom" title="Producto" disabled>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat" title="Lista de producto" data-toggle="modal" data-target="#lista"><i class="fas fa-list-ol"></i></button>
                                        </span>
                                    </div>
                                    <div class="row mb-0 px-2">
                                        <small for="codigo" id ="resultado_error" class="text-danger"></small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                    <label>Descripción</label> 
                                    <input class="form-control form-control-sm me-md-8" id="descripcion" name="descripcion" type="text" disabled />
                                </div>
                                <div class="col-12 col-sm-4 mb-2">
                                  <label for="id_almacen">Almacén</label>
                                  <select class="form-control form-control-sm"  id="id_almacen" name="id_almacen"  required>
                                    <option selected disabled value="">Seleccionar almacén</option>
                                      @foreach ($almacenes as $almacen)
                                      <option value="{{$almacen->id}}">{{$almacen->sigla}}</option>
                                      @endforeach
                                  </select>
                                  <div class="invalid-feedback">Seleccione un almacén.</div>
                                    @error('id_almacen')
                                    <small class="text-danger"> {{$message}}</small>
                                    @enderror
                                </div>
                            </div> 
                        </div>
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="col-12 col-sm-4 mb-2">
                                    <label>Precio de venta</label> 
                                    <input class="form-control form-control-sm" id="precio_venta" name="precio_venta" type="text" disabled/>
                                </div>
                                <div class="col-12 col-sm-4">
                                  <label>Stock</label>
                                  <input class="form-control form-control-sm" id="stock" name="stock" type="number" min="1" disabled/>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="float-right">
                                        <label><br></label>
                                        <div class="mb-0">
                                        <button class="btn btn-primary btn-sm" id="agregar_producto" name="agregar_producto" type="button" onclick="agregarProducto(id_producto.value,id_almacen.value,stock.value,'{{$id_inventario}}')">Agregar producto</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!--/body card-->
                </div><!--/card-->

                <div class="card card-default">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaProductos" class="table table-sm table-bordered table-hover">
                                    <thead class="bg-dark">
                                        <th>#</th>
                                        <th>Almacén</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th width= "1%"><i class="fas fa-trash"></i></th>
                                    </thead>
                                    <tbody></tbody>
                            </table>
                        </div>


                        <div class="d-flex justify-content-center">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-info btn-flat"  type="button" id="completa_compra">Registrar en Almacen</button>
                                </div>
                            </div>
                        </div>

                    </div><!--/body card-->
                </div><!--/card-->

            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->

  </div><!-- /.content-wrapper -->


<!-- Modal lista product-->
<div class="modal fade" id="lista">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
      <div class="modal-header p-2 px-3 lg-dark" lg-dark style="background:#3c8dbc; color:white;">
          <h4 class="modal-title w-100 text-center">Lista de productos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <table  id="example2" class="table table-bordered table-sm table-hover table-striped ">
              <thead>
                  <tr>
                    <th width="11%">Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>      
                    <th>stock</th>
                    <th width= "1%"></th>    
                  </tr>
              </thead>
              <tbody>
                @foreach ($productos as $producto)
                  <tr>
                      @php
                         $imagen = "img/productos/".$producto->id.".jpg";
                        if (!file_exists($imagen)) {
                            $imagen = "img/productos/150x150.png";
                        }
                      @endphp
                      <td class="text-center"><img width="50"height="30"src="{{asset($imagen.'?'.time())}}"/></td>  
                      <td class="align-baseline">{{$producto->nombre}}</td>
                      <td  class="align-baseline">{{$producto->descripcion}}</td>
                      <td  class="align-baseline">{{$producto->stock}}</td>
                      <td  class="align-baseline"><a class="btn btn-info btn-sm" onclick="buscarproduct({{$producto->id}})" rel="tooltip" data-placement="top" title="Seleccionar"> <i class="fas fa-plus"></i></a></td> 
                </tr>
                @endforeach
              </tbody>
          </table>
      </div>
      <div class="modal-footer p-1 justify-content-end">
          <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Cerrar lista</button>
      </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>

    $(document).ready(function(){
      $.ajax({
            url:'{{url('')}}/temporalinventario/vaciar',
            method:"GET",
        });
    });

    function buscarproduct(codigo) {
        var url='{{asset('')}}administracion/buscar/'+codigo;
        $.ajax({
             url: url,
            success: function(resultado){
                var resultado= JSON.parse(resultado);
                // alert(resultado.datos.nombre);
                $("#id_producto").val(resultado.datos.id);
                $("#nombre").val(resultado.datos.nombre);
                $("#descripcion").val(resultado.datos.descripcion);
                $("#precio_venta").val(resultado.datos.precio);
                $('#lista').modal('hide');
                document.getElementById('stock').disabled=false;
            },
        });
    }

    function agregarProducto(id_producto,id_almacen,stock,id_inventario) { 
        if(nombre !='' || (id_producto != null && id_producto != 0)){
            if(stock > 0 && stock!=''){
                $.ajax({
                    url:'{{url('')}}/temporalinventario/insertar',
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id_producto":id_producto,
                        "stock":stock,
                        "id_inventario":id_inventario,
                        "id_almacen":id_almacen,
                    },
                    success: function(resultado){
                        if (resultado == 0) {
                            alert('hola');
                        }
                        else{
                    
                            if (resultado.errors) {
                                if (resultado.errors.id_producto) {mostrarerror(resultado.errors.id_producto)}
                                if (resultado.errors.stock) { mostrarerror(resultado.errors.stock)}
                                if (resultado.errors.id_inventario) {mostrarerror(resultado.errors.id_inventario)}
                                if (resultado.errors.id_almacen) {mostrarerror(resultado.errors.id_almacen)}
                            }else{
                                var resultado= JSON.parse(resultado);
                              
                                if (resultado.error == '') {
                                    $("#tablaProductos tbody").empty();
                                    $("#tablaProductos tbody").append(resultado.datos);
                                    $("#id_producto").val('');
                                    $("#nombre").val('');
                                    $("#descripcion").val('');
                                    $("#stock").val('');
                                    $("#precio_venta").val('');
                                
                                    document.getElementById('stock').disabled=true;
                                
                                }else{
                                    alert('resultado.error')
                                }
                            }
                        }
                    },
                    
                });
            } else {Toast.fire({icon: 'error',title: 'Digite la cantidad para el stock.'})}
            
        }
        else {
            Swal.fire({
            icon: 'info',
            title: 'Aviso',
            text: 'Seleccione un producto por favor.',
            })
        }
    }

    function mostrarerror(error){
     Toast.fire({icon: 'error',title: error});
    }

    //ESTA FUNICION ES PARA ELIMINAR UNA REGISTRO DE LA TABLA TEMPORAL
    function eliminaProducto(id_temporalinventaario) {
        var url='{{url('')}}/temporalinventario/eliminar/'+ id_temporalinventaario;
        $.ajax({
            url: url,
            method:"GET",
            success: function(resultado){
                if (resultado == 0) {
                }
                else{
                    var resultado= JSON.parse(resultado);
                    $("#tablaProductos tbody").empty();
                    $("#tablaProductos tbody").append(resultado.datos);
                }
            }
        });
    }


    //COMPLETAR EL ALMACENAMIENTO
    $(document).ready(function() {
        $("#completa_compra").click(function () {
            let nFila= $("#tablaProductos tr").length;
            if(nFila <2){
                Toast.fire({
                    icon: 'error',
                    title: 'Agregue los productos que desea comprar.'
                })
            }else{
            
            Toast.fire({
                icon: 'success',
                title: 'Comprar registrada y stock axtualizado.',
                timer: 7000
            })
            $("#form_inventario").submit();
            }
        });
    });

  </script>

@endsection
