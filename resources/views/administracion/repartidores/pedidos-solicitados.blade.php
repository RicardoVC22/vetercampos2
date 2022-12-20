@extends('layouts.basehome')

@section('content')
<style>
  .intermitente{
    border: 1px solid green;
    padding: 0% 0%;
    box-shadow: 0px 0px 10px;
    color: green;
    animation: infinite resplandorAnimation 2s;
  }
  @keyframes resplandorAnimation {
    0%,100%{
      box-shadow: 0px 0px 20px;
    }
    50%{
    box-shadow: 0px 0px 0px;
    }
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Delivery</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Solicitudes de pedidos</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        {{-- <div class="row"> --}}
        {{-- <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-sm table-hover table-striped ">
                                <thead>
                                    <tr>
                                      <th width="5%"> id </th>
                                      <th>fecha</th>
                                      <th>montototal</th>
                                      <th>Estado</th>
                                      <th>Cliente</th>
                                      <th>Telefono</th>
                                      <th width="7%">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>{{$pedido->id}}</td>
                                        <td>{{$pedido->fecha}}</td>
                                        <td>{{$pedido->montototal}}</td>
                                  
                                        @if ($pedido->estadodelpedido == 'solicitado')
                                          <td class="text-center"><span class="badge bg-warning">{{$pedido->estadodelpedido}}</span></td>
                                        @elseif($pedido->estadodelpedido == 'pendiente')
                                          <td class="text-center"><span class="badge bg-info">{{$pedido->estadodelpedido}}</span></td>
                                          @elseif ($pedido->estadodelpedido == 'entregado')
                                          <td class="text-center"><span class="badge bg-success">{{$pedido->estadodelpedido}}</span></td>
                                          @elseif ($pedido->estadodelpedido == 'cancelado')
                                          <td class="text-center"><span class="badge bg-danger">{{$pedido->estadodelpedido}}</span></td>
                                        @endif
                                        <td>{{$pedido->nombre.' '.$pedido->apellidos}}</td>
                                        <td>{{$pedido->telefono}}</td>
                                        <td class="py-1 align-middle text-center">
                                          <div class="btn-group btn-group-sm">
                                         
                                            <a target="_blank" class="btn btn-info" rel="tooltip" data-placement="top" title="Ver ubicación" href="{{$pedido->url}}"><i class="fas fa-map-marked-alt"></i></a>
                                            {{-- <a class="btn btn-warning" rel="tooltip" data-placement="top" title="Ver detalle" href=""><i class="fas fa-list-alt"></i></a> --}}
                                            @if ($pedido->estadodelpedido == 'pendiente')
                                             <button class="btn btn-default intermitente" rel="tooltip" data-placement="top" title="¿Pedido entregado?" onclick="obtenerIdpedido({{$pedido->id}})" data-toggle="modal" data-target="#modal-repartidor"><i class="fas fa-question"></i></button>
                                            @elseif ($pedido->estadodelpedido == 'cancelado')
                                              <button class="btn btn-danger" rel="tooltip" data-placement="top" title="No Entregado"><i class="far fa-calendar-times"></i></button>
                                            @elseif ($pedido->estadodelpedido == 'entregado')
                                              <button class="btn btn-success" rel="tooltip" data-placement="top" title="Entregado"><i class="fas fa-clipboard-check"></i></button>
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

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>

    </div>
  </aside>
  <!-- /.control-sidebar -->


    <!-- Modal -->
    <div class="modal fade" id="modal-repartidor"  tabindex="-1"aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
  
          <div class="modal-body py-3">
              <form method="POST" action="{{route('pedido.estado')}}" autocomplete="off" >
                @method('PUT')  
                @csrf
                  <input type="hidden" id="id_pedido" name="id_pedido" class="mb-0">
                  <div class="form-group  mb-4">
                      <label for="recipient-name" class="col-form-label">Estado:</label>
                      <select class="form-control form-control-sm"  id="estado" name="estado"  required>
                      <option selected disabled value="">Seleccionar estado</option>
                          <option value="entregado">Entregado</option>
                          <option value="cancelado">Cancelado</option>
                      </select>
                      <div class="invalid-feedback">Seleccione un repartidor.</div>
                  </div>
  
                  <div class="d-flex justify-content-end ">
                      <div class="form-group mb-1">
                          <button type="button" class="btn btn-default btn-sm " data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-success btn-sm" >Confirmar</button>
                      </div>
                  </div>
              </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->

  <script  type="text/javascript">
    function obtenerIdpedido(id_pedido) {
        $("#id_pedido").val(id_pedido);
    }
  </script>
  @endsection