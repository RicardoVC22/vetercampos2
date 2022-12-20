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
            <h1>Crear ingrediente</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{asset('ingrediente')}}">Ingredientes</a></li>
              <li class="breadcrumb-item active">Crear ingrediente</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" enctype="multipart/form-data" action="{{asset('/ingrediente/store')}}" autocomplete="off" class="needs-validation" novalidate>
              @method('POST')
              @csrf
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                <label for="nombre">Nombre</label> 
                                <input class="form-control" id="nombre" name="nombre" type="text" value="{{old('nombre')}}"placeholder="ingrese su nombre " pattern=".*\S+.*" autofocus required />
                                <div class="invalid-feedback">Introduzca el nombre.</div>
                                @error('nombre')
                                <small class="text-danger"> {{$message}}</small>
                                @enderror
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group">
                                <label for="descripcion">Descripción</label> 
                                <input class="form-control" id="descripcion" name="descripcion" type="text" pattern=".*\S+.*" placeholder="ingrese una descripcion "value="{{old('descripcion')}}" required />
                                <div class="invalid-feedback">Por favor, coloque una descripción.</div>
                                @error('descripcion')
                                <small class="text-danger"> {{$message}}</small>
                                @enderror
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="id_provedor">Provedor</label>
                                  <select class="form-control" data-show-content="true" id="id_provedor" name="id_provedor"  required>
                                  <option selected disabled value="">Seleccionar Provedor</option >
                                      @foreach ($provedores as $provedor)
                                          @foreach ($empresas as $empresa)
                                              @if ($empresa->id==$provedor->id)
                                                <option value="{{$provedor->id}}">Empresa::{{$empresa->razonsocial}}</option>
                                              @endif
                                          @endforeach
                                          @foreach ($personas as $persona)
                                              @if ($persona->id==$provedor->id)
                                                <option value="{{$provedor->id}}">Persona::{{$persona->nombre.' '.$persona->apellidos}}</option>
                                              @endif
                                          @endforeach
                                      @endforeach
                                  </select>
                                  <div class="invalid-feedback">Seleccione un provedor.</div>
                                  @error('id_provedor')
                                  <small class="text-danger"> {{$message}}</small>
                                  @enderror
                              </div>
                          </div>
                      </div>
                          <div class="d-flex justify-content-end">
                              <div class="mt-4">
                                  <button type="submit" class= "btn btn-success btn-sm">Guardar</button>
                                  <a href="{{ url('ingrediente') }}" class= "btn btn-secondary btn-sm">Regresar</a>
                              </div>
                          </div>
                    </div><!--/body card-->
                </div><!--/CARD FIN-->
            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


@endsection