@extends('layouts.base')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark text-center">  Nota Venta </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      
        <div class="row">
            <div class="col-12">
              <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"> Lista</h3>
                </div>

                    <div class="card-body">
                        
                        @if (count(Cart::getContent()))
                        <div class="d-flex justify-content-end">
                            <div class="form-group">
                                <form action="{{route('cart.clear')}}"method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type ="submit" title="Eliminar"><i class="far fa-trash-alt"></i>&nbsp;Limpiar</button>
                                </form>
                                </div>
                        </div>
                        @endif
                        
                      <div class="table-responsive">
                        <table id="tabla-lista" class="table table-bordered table-sm table-hover mb-0">
                            <thead class="text-center">
                                <tr>
                                  <th width="5%" > Nro </th>
                                  <th> nombre </th>
                                  <th >Precio</th>
                                  <th width="15%" >Cantidad</th>
                                  <th width="12%">Subtotal</th>
                                  <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                              @php
                                  $c=1;
                              @endphp
                               @forelse  (Cart::getContent() as $key => $item)
                                <tr>
                                    <td>{{$c++;}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{number_format($item->price,2)}}</td>
                                    
                                    <td>
                                        <form id="form-update" action="{{ route('cart.update') }}" method="POST">
                                          @csrf
                                            <div class="input-group input-group-sm mb-0">
                                         
                                              <input type="hidden" value="{{ $item->id}}" id="id" name="id">
                                              <input type="number"class="form-control"style="width:25px;" id="quantity" name="quantity" title="cantidad"value="{{ $item->quantity }}" min="1" pattern="^[1-9]+">
                                              <span class="input-group-append">
                                                  <button type="submit"class="btn btn-success btn-flat" title="Lista de producto" data-toggle="modal" data-target="#lista"><i class="fa fa-edit"></i></button>
                                              </span>
                                          </div> 
                                      </form>
                                    </td>
                                 
                                    <td>{{$item->getPriceSum()}}</td>
                                    <td class="py-1 align-middle text-center">
                                      <form id="form-del" action="{{route('cart.removeitem')}}"method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <button class="btn btn-danger btn-sm" type ="submit" title="Eliminar"><i class="fas fa-trash"></i></button>
                                      </form>
                                    </td>
                                </tr>
                               
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Lista Vacia</td>
                                </tr>
                              @endforelse
                             
                            </tbody>
                            {{-- @if (count(Cart::getContent()))
                            <tfoot>
                                <th colspan="4"class=" text-right">TOTAL :</th>
                                <th colspan="1" class=" text-center">
                                    <div id="total">  {{number_format(Cart::getSubTotal(),2)}} Bs.</div>
                                </th>
                            </tfoot>
                            @endif --}}
                        </table>
                      </div>
                      @if (count(Cart::getContent()))
                      <br>
                      <div class="row mb-0">
                        <div class="col">
                          <div class="d-flex justify-content-left">
                            <div class="form-group mb-0">
                              <div class="card mb-0">
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item"><b>Cantidad Total: </b>{{Cart::getTotalQuantity()}}</li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="d-flex justify-content-end">
                            <div class="form-group  mb-0">
                              <div class="card shadow-ms mb-0">
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item"><b>Monto Total: </b>{{number_format(Cart::getTotal(),2)}} Bs.</li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                      </div><!-- /.row -->
                      <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <button class="btn btn-warning btn-flat" type="button" id="completa_pedido" onclick="guardarpedido()">Completar Venta</button>

                            </div>
                        </div>
                        </div>
                      @endif

                    </div>
                    <!-- /.card-body -->
              </div>
            </div>
        </div>
            <div class="container">
            <div class="row row-cols-1 row-cols-sm-2  row-cols-md-3 row-cols-lg-4  g-3">
                @foreach ($productos as $row)
                    @php
                       $imagen = "img/productos/".$row->id.".jpg";
                      if (!file_exists($imagen)) {$imagen = "img/productos/150x150.png";}
                    @endphp
                    <div class="col">
                        <div class="card card-success">
                          <div class="card-header">
                            <h3 class="card-title">{{$row->nombre}}</h3>
                          </div>
                            <img src="{{asset($imagen.'?'.time())}}" alt="imagen producto">
                            <div class="card-body">
                                <p class="card-text  mb-0">{{$row->precio}} Bs </p>
                                <p class="card-text mb-2 text-right">Stock:{{$row->totalstock}}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <form action="{{route('cart.add')}}" method="POST">
                                      @csrf
                                      <input type="hidden" id="producto_id"name="producto_id" value="{{$row->id}}">
                                      {{-- <button class="btn btn-sm btn-outline-warning" type="submit" name="btn" onclick="#" >Agregar al carrito</button> --}}
                                      <button class="btn btn-sm btn-danger" type="button" onclick="addproducto({{$row->id}})" name="btn" onclick="#" >Agregar Producto</button>
                                      
                                      {{-- <button class="btn btn-sm btn-outline-warning btn-submit" type="submit" >Agregar al carrito</button> --}}
                                    </form>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
              @endforeach

            </div>
        <!-- /.row -->
            </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script  type="text/javascript">

    //ESTA FUNICION ES PARA ELIMINAR UNA REGISTRO DE LA TABLA TEMPORAL
    function addproducto(id_producto) {
        var url='{{url('')}}/carrito-agregar/'+ id_producto;
        $.ajax({
            url: url,
            method:"GET",
            success: function(resultado){
                if (resultado == 0) {
                }
                else{
                    var resultado= JSON.parse(resultado);
                    // alert(resultado.datos);
                   // $("#ContadorCart").html(resultado.datos);
                    if (resultado.datos) {
                      location.reload();
                      toastr.success('Producto añadido correctamente','Añadido');
                    }
                }
            }
        });
    }



    function guardarpedido() { 


        let url = '{{url('')}}/venta/store';

        Swal.fire({
            title: '¿Desea Concluir la Venta?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '!Si!',

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                url: url,
                method: "POST",
                data: {
                    "_token"          :"{{ csrf_token() }}",
                },
                success: function(resultado){
                    if (!resultado) {
                        alert('error');
                    }
                    else{
                        var resultado= JSON.parse(resultado);
                        if(resultado.error){
                            mostrarerror('error','Error de stock vuelva a intentar más tarde') 
                        }else{
                       // $('#completa_pedido').prop('disabled', true);
                        mostrarerror('success','Datos registrados correctamente');
                        setTimeout(redirigir, '3000');
                        }
                    }
                },
                
            });
            }else{

            }
        });


    }

    function redirigir(){
      window.location.href ='{{url('')}}/venta';
    }
    function mostrarerror(icono,error){
     Toast.fire({icon: icono,title: error});
    }

  </script>
  @endsection