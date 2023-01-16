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
                      <h1>Agregar servicios en consulta</h1>
                  </div>
            
              </div>
          </div><!-- /.container-fluid -->
      </section>
     
      @php
           {{$id_folio = uniqid();}}
      @endphp
      <!-- Main content -->

      <section class="content">
        <div class="container-fluid">
            <form method="POST" id="form_inventario" name="form_inventario" action="{{ route('consulta_servicio.store') }}" autocomplete="off">
                @method('POST')
                @csrf
                <div class="card card-outline card-dark">
                    <div class="card-header">
                        <input type="hidden" id="id_consulta" name="id_consulta" class="form-control-border" value="{{$id_consulta}}">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div><!--/.card-header-->

                    <div class="card-body">
                   
                        <!-- /input-group -->
                        <div class="form-group mb-0">
                            <div class="row">
                                <input type="hidden" id="id_servicio" name="id_servicio" value="" />
                                <input type="hidden" id="id_folio" name="id_folio" value="{{$id_folio}}"/>

                                <div class="col-12 col-sm-4">
                                    <label >Servicios</label> 
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
                                    <label>Cliente</label>
                                    <select class="form-control form-control-sm" name="id_cliente" id="id_cliente">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                                        @endforeach
                                    </select>
                            
                                  <div class="invalid-feedback">Seleccione un cliente.</div>
                                    @error('id_cliente')
                                    <small class="text-danger"> {{$message}}</small>
                                    @enderror
                                </div>
                            </div> 
                        </div>
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="col-12 col-sm-4 mb-2">
                                    <label>Precio de Servicio</label> 
                                    <input class="form-control form-control-sm" id="precio_venta" name="precio_venta" type="text" disabled/>
                                </div>
                                <div class="col-12 col-sm-4">
                                  
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="float-right">
                                        <label><br></label>
                                        <div class="mb-0">
                                        <button class="btn btn-primary btn-sm" id="agregar_producto" name="agregar_producto" type="button" onclick="agregarServicio(id_servicio.value,'{{$id_folio}}')">Agregar Servicio</button>
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
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th width= "1%"><i class="fas fa-trash"></i></th>
                                    </thead>
                                    <tbody></tbody>
                            </table>
                        </div>


                        <div class="d-flex justify-content-center">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-info btn-flat"  type="button" id="completa_consulta">Completar Consulta</button>
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
          <h4 class="modal-title w-100 text-center">Lista de servicios</h4>
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
                    <th>precio</th>
                    <th width= "1%"></th>    
                  </tr>
              </thead>
              <tbody>
                @foreach ($servicios as $servicio)
                  <tr>
                      @php
                         $imagen = "img/servicios/".$servicio->id.".jpg";
                        if (!file_exists($imagen)) {
                            $imagen = "img/servicios/150x150.png";
                        }
                      @endphp
                      <td class="text-center"><img width="50"height="30"src="{{asset($imagen.'?'.time())}}"/></td>  
                      <td class="align-baseline">{{$servicio->nombre}}</td>
                      <td  class="align-baseline">{{$servicio->descripcion}}</td>
                      <td  class="align-baseline">{{$servicio->precio}}</td>
                      <td  class="align-baseline"><a class="btn btn-primary btn-sm" onclick="buscarproduct({{$servicio->id}})" rel="tooltip" data-placement="top" title="Seleccionar"> <i class="fas fa-plus"></i></a></td> 
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
        var url='{{asset('')}}consulta_servicio/buscar/'+codigo;
        $.ajax({
             url: url,
            success: function(resultado){
                var resultado= JSON.parse(resultado);
                // alert(resultado.datos.nombre);
                $("#id_servicio").val(resultado.datos.id);
                $("#nombre").val(resultado.datos.nombre);
                $("#descripcion").val(resultado.datos.descripcion);
                $("#precio_venta").val(resultado.datos.precio);
                $('#lista').modal('hide');
                
            },
        });
    }

    function agregarServicio(id_servicio,folio) { 
        if((id_servicio != null && id_servicio != 0)){
            if(true){
                $.ajax({
                    url:'{{url('')}}/temporalconsulta/insertar',
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id_servicio":id_servicio,
                        "folio":folio,
                        
                        
                    },
                    success: function(resultado){
                        if (resultado == 0) {
                            alert('hola');
                        }
                        else{
                    
                            if (resultado.errors) {
                                if (resultado.errors.id_servicio) {mostrarerror(resultado.errors.id_producto)}
                              
                                
                            
                            }else{
                                var resultado= JSON.parse(resultado);
                              
                                if (resultado.error == '') {
                                    $("#tablaProductos tbody").empty();
                                    $("#tablaProductos tbody").append(resultado.datos);
                                    $("#id_servico").val('');
                                    $("#nombre").val('');
                                    $("#descripcion").val('');
                                    $("#precio_venta").val('');
                                
                                
                                
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
    function eliminaServicio(id_temporalconsulta) {
        var url='{{url('')}}/temporalconsulta/eliminar/'+ id_temporalconsulta;
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
        $("#completa_consulta").click(function () {
            let nFila= $("#tablaProductos tr").length;
            if(nFila <2){
                Toast.fire({
                    icon: 'error',
                    title: 'Agregue los servicios que desea comprar.'
                })
            }else{
            
            Toast.fire({
                icon: 'success',
                title: 'Consulta registrada',
                timer: 7000
            })
            $("#form_inventario").submit();
            }
        });
    });

  </script>

@endsection
