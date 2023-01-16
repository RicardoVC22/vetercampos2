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
                      <h1>Ventas</h1>
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
                                      <a class="btn btn-info btn-sm" href="{{ route('venta.generar') }}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Nueva Venta</a>
                                      {{--<a class="btn btn-danger btn-sm" href="{{ asset('administracion/cliente/eliminados') }}"><i class="far fa-trash-alt"></i>&nbsp;Eliminados</a>--}}
                                  </div>
                              </div>
                              <table id="example2" class="table table-bordered table-sm table-hover table-striped ">
                                  <thead>
                                      <tr>
                                          <th> id </th>
                                          <th> monto total </th>
                                          <th> fecha y hora </th>
                                          <th> usuario </th>
                                          <th width="7px">Acción</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($ventas as $venta)
                                          <tr>
                                              <td>{{ $venta->id }}</td>
                                              <td>{{ $venta->monto_total }}</td>
                                              <td>{{ $venta->fecha_hora }}</td>
                                              <td>{{ $venta->name }}</td>
                                              <td class="py-1 align-middle text-center">
                                                <div class="btn-group btn-group-sm">
                                                  <a href="{{ route('venta.detalle',$venta->id)}}" class="btn btn-danger" rel="tooltip" data-placement="top" title="pdf detalle" ><i class="fas fa-file-pdf"></i></a>
                                                  {{--<a href="{{route('venta.delete',$venta->id)}}" class="btn btn-warning" rel="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash"></i></a>--}}
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