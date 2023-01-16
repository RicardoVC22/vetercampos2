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
                      <h1>Consulta</h1>
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
                                      {{--<a class="btn btn-info btn-sm" href="{{ route('consulta_servicio.create') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Nueva Consulta</a>--}}
                                      <a class="btn btn-danger btn-sm" href="{{ asset('consulta/create') }}"><i class="far fa-trash-alt"></i>&nbsp;Agregar</a>
                                  </div>
                              </div>
                              <table id="example2" class="table table-bordered table-sm table-hover table-striped ">
                                  <thead>
                                      <tr>
                                          <th> id </th>
                                          <th> monto consulta </th>
                                          <th> monto servicio </th>
                                          <th> descripcion </th>
                                          <th> fecha y hora </th>
                                          <th> atendido por </th>
                                          <th> cliente </th>
                                          <th width="7px">Acción</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($consultas as $consulta)
                                          <tr>
                                              <td>{{ $consulta->id }}</td>
                                              <td>{{ $consulta->monto_consulta }}</td>
                                              <td>{{ $consulta->monto_servicio }}</td>
                                              <td>{{ $consulta->descripcion }}</td>
                                              <td>{{ $consulta->created_at }}</td>
                                              @foreach ($usuarios as $usuario)
                                                  @if ($usuario->id==$consulta->id_usuario)
                                                    <td>{{ $usuario->name }}</td>
                                                  @endif
                                              @endforeach
                                              @foreach ($clientes as $cliente)
                                                  @if ($cliente->id==$consulta->id_cliente)
                                                    <td>{{ $cliente->nombre }}</td>
                                                  @endif
                                              @endforeach
                                             
                                              <td class="py-1 align-middle text-center">
                                                <div class="btn-group btn-group-sm">

                                                  @if ($consulta->vigencia==0)
                                                  <a href="{{route('consulta.add_mascota',$consulta->id)}}" class="btn btn-success"  title="add servicios"><i class="fas fa-trash"></i></a>

                                                  @else
                                                  @if ($consulta->vigencia==1)
                                                  <a href="{{route('consulta_servicio.create',$consulta->id)}}" class="btn btn-warning"  title="add servicios"><i class="fas fa-trash"></i></a>
                                                  @endif
                                                  @if ($consulta->vigencia==2)
                                                  <a href="{{ route('consulta.detalle',$consulta->id)}}" class="btn btn-danger" rel="tooltip" data-placement="top" title="pdf detalle" ><i class="fas fa-file-pdf"></i></a>

                                                  @endif
                                                  @endif

                                                  
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
          <h4 class="modal-title">No es posible eliminar el Registro</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Desea poner en observacion?</p>
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