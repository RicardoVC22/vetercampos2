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
            <h1>Editar Tipo Servicio</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{url('tipo_servicio/update/'.$tipo_servicio['id'])}}" autocomplete="off" class="needs-validation" novalidate>
              @method('PUT')
              @csrf
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label> 
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="{{$tipo_servicio['nombre']}}"placeholder="ingrese el nombre " pattern=".*\S+.*"required/>
                                    <div class="invalid-feedback">Introduzca nombre de la categoría.</div>
                                    @error('nombre')
                                      <small class="text-danger"> {{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                  <label for="descripcion">Descripcion</label> 
                                  <input class="form-control" id="descripcion" name="descripcion" type="text" value="{{$tipo_servicio['descripcion']}}"placeholder="ingrese el nombre " pattern=".*\S+.*"required/>
                                  <div class="invalid-feedback">Introduzca descripcion.</div>
                                  @error('nombre')
                                    <small class="text-danger"> {{$message}}</small>
                                  @enderror
                              </div>
                            </div>
  
                        </div>

                          <div class="d-flex justify-content-end">
                              <div>
                                <button type="submit" class= "btn btn-success btn-sm">Guardar</button> 
                                <a href="{{url('tipo_servicio')}}" class= "btn btn-secondary btn-sm">Regresar</a>  
                              </div>
                          </div>

                    </div><!--/body card-->

                </div><!--/CARD FIN-->
            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection
