@extends('layouts.base')

@section('content')


<style>
  .disabled {
    cursor: not-allowed;
    pointer-events: none;
  }
</style>

    {{-- INICIO DEL CUERPO --}}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-0">
                  <div class="col-sm-6 mb-0">
                      <h1>Producciones</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="">Inicio</a></li>
                          <li class="breadcrumb-item active">Producciones</li>
                      </ol>
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
                                      <a class="btn btn-info btn-sm" href="{{asset('administracion/produccion/create')}}"><i class="fas fa-plus"></i>Agregar</a>
                                  </div>
                              </div>
                              <table id="example2" class="table table-bordered table-sm table-hover table-striped ">
                                  <thead>
                                      <tr>
                                        <th width="5%"> id </th>
                                        <th>fecha</th>
                                        <th>hora inicio</th>
                                        <th>hora final</th>
                                        <th>estado de produccion</th>
                                        <th width="7%">Acción</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($producciones as $produccion)
                                      <tr>
                                          <td>{{$produccion->id}}</td>
                                          <td>{{$produccion->fecha}}</td>
                                          <td>{{$produccion->hora}}</td>
                                          <td>{{$produccion->horafini}}</td>
                                          <td>{{$produccion->estadoproduccion}}</td>
                                          <td class="py-1 align-middle text-center">
                                            <div class="btn-group btn-group-sm">
                                              @if ($produccion->estadoproduccion=="inactivo")
                                              <a  class="btn btn-success" rel="tooltip" data-placement="top" title="Crear Detalle Produccion" href="{{asset('administracion/produccion')}}/{{$produccion->id}}/{{$produccion->fecha}}"><i class="far fa-calendar-check"></i></a>  
                                              @else
                                              <a class="btn btn-success" rel="tooltip" data-placement="top" title="ver detalle" href="{{route('produccion.verdetalle',$produccion->id)}}"><i class="fas fa-eye"></i></a>   
                                              @endif
                                               {{--<a class="btn btn-primary" rel="tooltip" data-placement="top" title="ver detalle" href="{{route('produccion.terminarproduccion',$produccion->id)}}"><i class="fas fa-pencil-alt"></i></a>--}}                                         
                                              @if ($produccion->estadoproduccion=="terminado")  
                                              <a href="#" class="btn btn-primary disabled" rel="tooltip" data-placement="top" title="Terminar Produccion" data-href="{{route('produccion.terminarproduccion',$produccion->id)}}" data-toggle="modal" data-target="#modal-confirma"><i class="far fa-calendar-check"></i></a> 
                                              @else
                                                @if ($produccion->estadoproduccion=="inactivo")
                                                <a href="#" class="btn btn-danger" rel="tooltip" data-placement="top" title="Eliminar Produccion" data-href="{{route('produccion.anularproduccion',$produccion->id)}}" data-toggle="modal" data-target="#modal-confirma"><i class="fas fa-trash-alt"></i></a>  
                                                @else
                                                <a href="#" class="btn btn-primary" rel="tooltip" data-placement="top" title="Terminar Produccion" data-href="{{route('produccion.terminarproduccion',$produccion->id)}}" data-toggle="modal" data-target="#modal-confirma"><i class="far fa-calendar-check"></i></a>   
                                                @endif
                                              @endif 
                                            </div>
                                          </td>
                                      </tr>
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
          <h4 class="modal-title">Terminar Produccion</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea Terminar este produccion?</p>
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
