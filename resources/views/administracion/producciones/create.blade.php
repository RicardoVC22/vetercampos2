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
            <h1>Crear Produccion</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{route('produccion')}}">Produccion</a></li>
              <li class="breadcrumb-item active">Crear Produccion</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{asset('administracion/produccion/store')}}" autocomplete="off" class="needs-validation" novalidate>
          
              @csrf
                <div class="card card-secondary card-outline">
                    <div class="card-body">

                        <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                <label for="fecha">Fecha</label> 
                                <input class="form-control" id="fecha" name="fecha" type="date" value="{{old('fecha')}}" pattern=".*\S+.*" autofocus required />
                                <div class="invalid-feedback">Introduzca la fecha</div>
                                @error('fecha')
                                <small class="text-danger"> {{$message}}</small>
                                @enderror
                              </div>
                          </div>

                          {{--<div class="col-sm-6">
                            <div class="form-group">
                              <label for="">Estado de produccion</label>
                                  <select class="form-control"  id="estadoproduccion" name="estadoproduccion"  required>
                                  <option selected disabled value="">Seleccionar estado</option>
                                  
                                      <option value="">{{$categoria->nombre}}</option>
                                      
                                  </select>
                                  <div class="invalid-feedback">Seleccione estado.</div>
                                  @error('estadoproduccion')
                                  <small class="text-danger"> {{$message}}</small>
                                  @enderror
                              </div>
                          </div>--}}
                        </div>

                          <div class="d-flex justify-content-end">
                              <div>
                                <button type="submit" class= "btn btn-success btn-sm">Guardar</button> 
                                <a href="{{route('produccion')}}" class= "btn btn-secondary btn-sm">Regresar</a>  
                              </div>
                          </div>

                    </div><!--/body card-->

                </div><!--/CARD FIN-->
            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection