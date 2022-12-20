@extends('layouts.basehome')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">  <small> Menu</small></h1>
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
                                    <div class="btn-group">
                                        <a href="#"class="btn btn-sm btn-info">Detalles</a>
                                    </div>
                             
                                    <form action="{{route('cart.add')}}" method="POST">
                                      @csrf
                                      <input type="hidden" id="producto_id"name="producto_id" value="{{$row->id}}">
                                      {{-- <button class="btn btn-sm btn-outline-warning" type="submit" name="btn" onclick="#" >Agregar al carrito</button> --}}
                                      <button class="btn btn-sm btn-danger" type="button" onclick="addproducto({{$row->id}})" name="btn" onclick="#" >Agregar al carrito</button>
                                      
                                      {{-- <button class="btn btn-sm btn-outline-warning btn-submit" type="submit" >Agregar al carrito</button> --}}
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
                    $("#ContadorCart").html(resultado.datos);
                    if (resultado.datos) {
                      toastr.success('Producto añadido correctamente','Añadido')
                    }
                }
            }
        });
    }

  </script>
  @endsection