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
            <h1>Crear usuario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
              <li class="breadcrumb-item active">Crear usuario</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{asset('administracion/usuarios/store')}}" autocomplete="off" class="needs-validation" novalidate>
              @csrf
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label> 
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="{{old('nombre')}}"placeholder="ingrese su nombre " pattern=".*\S+.*" autofocus required />
                                    <div class="invalid-feedback">Introduzca nombre de usuario.</div>
                                    @error('nombre')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label> 
                                    <input class="form-control" id="email" name="email" type="text" pattern=".*\S+.*" placeholder="ingrese su nombre "value="{{old('email')}}" required />
                                    <div class="invalid-feedback">Por favor, coloque su nombre.</div>
                                    @error('email')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input class="form-control" id="contraseña" name="contraseña" type="password"placeholder="ingrese su nombre " pattern=".*\S+.*" value="{{old('contraseña')}}" required/>
                                    <div class="invalid-feedback">Introduzca una contraseña.</div>
                                    @error('contraseña')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Repita contraseña</label> 
                                    <input class="form-control" id="confirmar_contraseña" name="confirmar_contraseña" type="password" pattern=".*\S+.*" value="{{old('confirmar_contraseña')}}" required/>
                                    <div class="invalid-feedback">Repita la contraseña, porfavor.</div>
                                    @error('confirmar_contraseña')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
               
                            <div class="col-sm-6">
                                <div class="form-group">
                                <label>Rol</label>
                                    <select class="form-control"  id="id_rol" name="id_rol"  required>
                                    <option selected disabled value="">Seleccionar rol</option>
                                        @foreach ($roles as $rol)
                                        <option value="{{$rol->name}}">{{$rol->name}}</option>
                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback">Seleccione un rol.</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                   
                                </div>
                            </div>
                        </div>

                          <div class="d-flex justify-content-end">
                              <div>
                                <button type="submit" class= "btn btn-success btn-sm">Guardar</button> 
                                <a href="{{asset('administracion')}}" class= "btn btn-secondary btn-sm">Regresar</a>  
                              </div>
                          </div>

                    </div><!--/body card-->

                </div><!--/CARD FIN-->
            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection