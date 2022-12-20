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
            <h1>Editar Empleado</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{route('repartidor')}}">Empleado</a></li>
              <li class="breadcrumb-item active">Editar Empleado</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{asset('administracion/empleado/update')}}/{{$empleado->id}}" autocomplete="off" class="needs-validation" novalidate>
              @csrf
                <div class="card card-secondary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label> 
                                    <input class="form-control" id="nombre" name="nombre" type="text" value="{{$empleado->nombre}}"placeholder="ingrese su nombre " pattern=".*\S+.*" autofocus required />
                                    <div class="invalid-feedback">Introduzca nombre de Empleado.</div>
                                    @error('nombre')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Apellidos</label> 
                                    <input class="form-control" id="apellidos" name="apellidos" type="text" value="{{$empleado->apellidos}}"placeholder="ingrese sus apellidos " pattern=".*\S+.*" autofocus required />
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
                                    <label for="nombre">Edad</label> 
                                    <input class="form-control" id="edad" name="edad" type="number" value="{{$empleado->edad}}"placeholder="ingrese su edad " pattern=".*\S+.*" autofocus required />
                                    <div class="invalid-feedback">Introduzca su edad.</div>
                                    @error('edad')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            @php($login="--")
                            @php($id=$empleado->id_usuario)
                            @foreach ($usuario as $u)
                                @if ($id==$u->id)
                                @php($login=$u->email)
                                @endif
                            @endforeach 

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label> 
                                    <input class="form-control" id="email" name="email" type="email" pattern=".*\S+.*" placeholder="ingrese su nombre "value="{{$login}}" disabled required />
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
                                    <label>Telefono</label> 
                                    <input class="form-control" id="telefono" name="telefono" type="number" pattern=".*\S+.*" placeholder="ingrese su telefono "value="{{$empleado->telefono}}" required />
                                    <div class="invalid-feedback">Por favor, coloque su nro de telefono.</div>
                                    @error('telefono')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>sueldo</label> 
                                    <input class="form-control" id="sueldo" name="sueldo" type="number" pattern=".*\S+.*" placeholder="ingrese su sueldo"value="{{$empleado->sueldo}}" required />
                                    <div class="invalid-feedback">Por favor, coloque su sueldo</div>
                                    @error('sueldo')
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
                                    <label>Direccion</label> 
                                    <input class="form-control" id="direccion" name="direccion" type="text" pattern=".*\S+.*" placeholder="ingrese su direccion"value="{{$empleado->direccion}}" required />
                                    <div class="invalid-feedback">Por favor, coloque su direccion</div>
                                    @error('direccion')
                                        <div class="alert alert-warning">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                

                          <div class="d-flex justify-content-end">
                              <div>
                                <button type="submit" class= "btn btn-success btn-sm">Guardar</button> 
                                <a href="{{route('repartidor')}}" class= "btn btn-secondary btn-sm">Regresar</a>  
                              </div>
                          </div>

                    </div><!--/body card-->

                </div><!--/CARD FIN-->
            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection
