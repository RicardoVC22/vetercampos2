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
            <h1>Crear Tipo Servicio</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{asset('tipo_servicio/store')}}" autocomplete="off" class="needs-validation" novalidate>
              @method('POST')
              @csrf
                <div class="card card-secondary card-outline">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label> 
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="{{old('nombre')}}"placeholder="ingrese el nombre " pattern=".*\S+.*" autofocus required/>
                                    <div class="invalid-feedback">Introduzca nombre de la categoría.</div>
                                    @error('nombre')
                                        <small class="text-danger"> {{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                  <label for="descripcion">Descripcion</label> 
                                  <input class="form-control" id="descripcion" name="descripcion" type="text" value="{{old('descripcion')}}"placeholder="ingrese la descripcion " pattern=".*\S+.*" autofocus required/>
                                  <div class="invalid-feedback">Introduzca descripcion.</div>
                                  @error('descripcion')
                                      <small class="text-danger"> {{$message}}</small>
                                  @enderror
                              </div>
                            </div>
                        </div>
          
                          <div class="d-flex justify-content-end">
                              <div>
                                <button type="submit" class= "btn btn-success btn-sm">Guardar</button> 
                                <a href="{{asset('tipo_descripcion')}}" class= "btn btn-secondary btn-sm">Regresar</a>  
                              </div>
                          </div>

                    </div><!--/body card-->

                </div><!--/CARD FIN-->
            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection