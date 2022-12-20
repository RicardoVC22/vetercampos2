@extends('layouts.basehome')

@section('content')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> --}}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> Pedidos realizados</h1>
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
            <div class="row row-cols-1 row-cols-md-2  row-cols-lg-3 g-2">
                @php $c=1; @endphp
                @foreach ($pedidos as $row)   
                    <div class="col">
                      <div class="card card-success">
                        <div class="card-header">
                          <div class="row">
                            <div class="col-6">
                              <h4 class="text-dark">
                                {{$c++;}}. <i class="fas fa-hard-hat"></i>
                              </h4>
                            </div>
                            <div class="col-6">
                                <h5>
                                  <small class="float-right">Fecha: {{$row->fecha}}</small>
                                </h5>
                              </div>
                          </div>
                        </div>
                        
                            <div class="card-body">
                                
                                <div class="invoice-col">
                                    <b>Orden ID:</b> {{$row->id}}<br>
                                    <b>Nombre :</b> {{$row->nombre}}<br>
                                    <b>Apellidos :</b> {{$row->apellidos}}<br>
                                    <b>Correo electrónico:</b> {{auth()->user()->email;}}<br>
                                    <b>Telefono:</b>  {{$row->telefono}}<br>
                                    <b>Dirección:</b>  {{$row->referencia}}<br>
                                    <b>Monto total:</b> {{$row->montototal}} Bs<br>
                                    @php
                                      $separar = (explode(" ",$row->created_at));
                                      $fecha = $separar[0];
                                      $hora = $separar[1];
                                    @endphp
                                    <b>Hora:</b>  {{$hora}}<br>

                                    <b>Estado del pedido:</b>
                                  @if (($row->id_empleado == NULL && $row->id_repartidor == NULL)&&$row->estadodelpedido == 'solicitado')
                                   <span class="badge badge-warning text">{{$row->estadodelpedido}}</span>
                                    @elseif ($row->estadodelpedido == 'pendiente')
                                    <span class="text-info">{{$row->estadodelpedido}}</span>
                                    @elseif ($row->estadodelpedido == 'entregado')
                                    <span class="text-success">{{$row->estadodelpedido}}</span>
                                    @elseif ($row->estadodelpedido == 'cancelado')
                                    <span class="text-danger">{{$row->estadodelpedido}}</span>
                                  @endif
                                    <br>
                                  </div>
                                  <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                      @if (($row->id_empleado == NULL && $row->id_repartidor == NULL)&&$row->estadodelpedido == 'solicitado' )
                                        <button class="btn btn-sm btn-danger" rel="tooltip" data-placement="top" title="¿Pedido entregado?" onclick="obtenerIdpedido({{$row->id}})" data-toggle="modal" data-target="#cancelarpedido">Cancelar Pedido</button>
                                      @endif
                                    </div>
                                    <form action="#" method="POST">
                                      @csrf
                                      <input type="hidden" id="producto_id"name="producto_id" value="{{$row->id}}">
                                      <button class="btn btn-sm btn-dark" type="button" onclick="addproducto({{$row->id}})" name="btn" onclick="#" >Ver detalle</button>
                                    </form>
                                </div>
                            </div>
                      </div>
                    </div>
              @endforeach

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="cancelarpedido"  tabindex="-1"aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
  
          <div class="modal-body py-3">
              <form method="POST" action="{{route('pedido.cancelar')}}" autocomplete="off" >
                @method('PUT')  
                @csrf
                  <input type="hidden" id="id_pedido" name="id_pedido" class="mb-0">
                  <div class="form-group  mb-4">
                      <label for="recipient-name" class="col-form-label">Cancelar solicitud</label>
                      <p for="recipient-name" class="col-form-label">¿Desea Cancelar la solicitud?</p>
                  </div>
                  <div class="d-flex justify-content-end ">
                      <div class="form-group mb-1">
                          <button type="button" class="btn btn-default btn-sm mr-2 " data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-danger btn-sm" >Confirmar</button>
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