@extends('adminlte::page')
<!--//implementa la vista de adminlte -->
@section('title' )
<!--//agregamos un titulo  -->

@section('content_header')
@stop
<!--//Agregamos un header a nuestra pagina -->

@section('content')

<div class="container-fluid">
    <h1 class="text-center" >Editar Usuarios</h1>   
    <br>
        <div class="mb-4 text-center">
            <a class="btn btn-dark" href="{{asset('administracion')}}"> <i class="bi bi-coin"></i> Usuarios</a>
            <a class="btn btn-dark" href="{{asset('administracion/roles')}}"><i class="bi bi-file-earmark-bar-graph"></i> Roles</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{asset('administracion/usuarios/update')}}/{{$usuario->id}}" method="POST" > 
                    @csrf
                    <div class="row" >
                      <div class="col" >
                            <div class="mb-3">
                                    <label>Nombre</label>
                                    <input class="form-control" disabled type="text" id="nombre" name="nombre" value=""   placeholder="ingrese su nombre " />
                                    <span class="icon"><i class="lni lni-user"></i></span>
                                    @error('nombre')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                            </div>
                            
                            <div class="mb-3">
                                    <label>Correo</label>
                                    <input class="form-control" disabled type="email" id="email" name="email" value="" placeholder="ingrese su correo" />
                                    @error('email')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                    @enderror
                            </div> 

                            <div class="mb-3">
                                <label >Confirmar Contraseña</label> 
                                <input class="form-control" disabled type="password" id="contraseña" name="contraseña" value="" placeholder="confirme su contraseña anterior" />
                                    @error('email')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                    @enderror
                            </div>
                       </div>
                       <div class="col" >
                            <div class="mb-3">
                                <label >Nueva Contraseña</label> 
                                <input class="form-control" disabled type="password" id="nueva_contraseña" name="nueva_contraseña" value="" placeholder="escriba su contraseña nueva" />
                                    @error('email')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label >Confirmar Nueva Contraseña</label> 
                                <input class="form-control" disabled type="password" id="confirmar_nueva_contraseña" name="confirmar_nueva_contraseña" value="" placeholder="confirme su contraseña nueva" />
                                    @error('email')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                    @enderror
                            </div>
                       </div>
                    </div>
                      <a href="{{asset('administracion')}}" class="btn btn-primary" > Regresar </a>
                      <button type="submit" class="btn btn-success"> Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

<!--//Contenido de nuestra pagina -->

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

<!--//agregamos css -->

@section('js')
    <script> console.log('Hi!'); </script>
@stop

<!--//agregamos Java Script-->