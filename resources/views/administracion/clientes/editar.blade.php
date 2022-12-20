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
            <h1>Editar Cliente</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{asset('administracion/cliente')}}">Cliente</a></li>
              <li class="breadcrumb-item active">Editar usuario</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{asset('administracion/cliente/update')}}/{{$cliente->id}}" autocomplete="off" class="needs-validation" novalidate>
              @csrf
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <!-- alert -->
                        {{-- <php if(isset($validation)){
                        echo'<div class="row ">
                                    <div class="col-md-6 offset-md-3">
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                            '.$validation->listErrors().'
                                        </div>
                                    </div>
                                </div> ';
                        };?> --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label> 
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="{{$cliente->nombre}}"placeholder="ingrese su nombre " pattern=".*\S+.*" autofocus  />
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
                                    <label for="apellidos">Apellidos</label> 
                                    <input class="form-control" id="apellidos" name="apellidos" type="text" value="{{$cliente->apellidos}}"placeholder="Introduzca su apellido " pattern=".*\S+.*" autofocus />
                                    <div class="invalid-feedback">Introduzca su apellido.</div>
                                    @error('apellidos')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="edad">Edad</label> 
                                    <input class="form-control" id="edad" name="edad" type="text" value="{{$cliente->edad}}"placeholder="Introduzca su edad " pattern=".*\S+.*" autofocus  />
                                    <div class="invalid-feedback">Introduzca su apellido.</div>
                                    @error('edad')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefono</label> 
                                    <input class="form-control" id="telefono" name="telefono" type="text" pattern=".*\S+.*" placeholder="ingrese su telefono"value="{{$cliente->telefono}}" />
                                    <div class="invalid-feedback">Por favor, su telefono.</div>
                                    @error('telefono')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
        
                        <div class="row">
               
                            <div class="col-sm-6">

                                {{--<input type="hidden" value="{{$usuario->roles['0']->name}}" id="id_rol_aux" name="id_rol_aux" >--}}
                                

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label> 
                                        {{--sacamos el login del usuario relacionado--}}
                                        @php($login="--")
                                        @php($id=$cliente->id_usuario)
                                        @foreach ($usuario as $u)
                                          @if ($id==$u->id)
                                          @php($login=$u->email)
                                          @endif
                                        @endforeach 
                                        {{----}}
                                        <input class="form-control" id="email" name="email" type="text" pattern=".*\S+.*" placeholder="ingrese su nombre "
                                        value= "{{$login}}" disabled />

                                        <div class="invalid-feedback">Por favor, coloque su nombre.</div>
                                        @error('email')
                                            <div class="alert alert-warning">
                                            {{$message}}
                                            </div>
                                        @enderror
                                    </div>
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
