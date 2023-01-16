@extends('layouts.base')

@section('content')

    {{-- INICIO DEL CUERPO --}}
<style>
  .disabled {
    cursor: not-allowed;
    pointer-events: none;
  }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-0">
                  <div class="col-sm-6 mb-0">
                      <h1>Productos</h1>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-12">
                      <div class="card">

                          <!-- /.card-header -->
                          <div class="card-body">
                              <div class="d-flex justify-content-end">
                                  <div class="form-group">
                                      <a class="btn btn-info btn-sm" href="{{ asset('producto/create')}}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Agregar</a>
                                      <a class="btn btn-danger btn-sm" href="{{asset('producto/eliminados')}}"><i class="far fa-trash-alt"></i>&nbsp;Eliminados</a>
                                  </div>
                              </div>
                              <table id="example2" class="table table-bordered table-sm table-hover table-striped ">
                                  <thead>
                                      <tr>
                                        <th width="8%">Imagen</th>
                                        <th width="5%"> id </th>
                                        <th> nombre </th>
                                        <th> descripcion </th>
                                        <th> precio </th>
                                       
                                        <th width="7%">Acción</th>
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
                                          <td>{{$producto->id}}</td>
                                          <td>{{$producto->nombre}}</td>
                                          <td>{{$producto->descripcion}}</td>
                                          <td>{{$producto->precio}}</td>
                                          
                                          <td class="py-1 align-middle text-center">
                                            <div class="btn-group btn-group-sm">
                                              @if ($producto->recetado == 1)
                                                <a class="btn btn-success" rel="tooltip" data-placement="top" title="Ver receta" href="{{ url('producto/receta/verreceta/'.$producto->id)}}"><i class="fas fa-eye" ></i></a>
                                              @else
                                                <a class="btn btn-success disabled" rel="tooltip" data-placement="top" title="No tiene receta" href="#" ><i class="fas fa-eye-slash"></i></a>
                                              @endif
                                              <a class="btn btn-warning" rel="tooltip" data-placement="top" title="Editar" href="{{ url('producto/edit/'.$producto->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                              <a href="#" class="btn btn-danger" rel="tooltip" data-placement="top" title="Eliminar" data-href="{{url('producto/destroy/'.$producto->id)}}" data-toggle="modal" data-target="#modal-confirma"><i class="fas fa-trash"></i></a>
                                            </div>
                                          </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                              </table>
                          </div>
                          <!-- /.card-body -->

                      </div>
                      <!-- /.card -->

                  </div>
                  <!-- /.col -->
              </div>
              <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal -->
  <div class="modal fade" id="modal-confirma" data-backdrop="static">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Eliminar Registro</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea Eliminar este registro?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-danger btn-ok btn-sm">Confirmar</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
    <!-- /.modal -->

@endsection
