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
            <h1>Crear provedor</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{asset('provedor')}}">Provedores</a></li>
              <li class="breadcrumb-item active">Crear provedor</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form action="{{ url('provedor/update/'.$provedor->id)}}" method="POST" class="needs-validation" novalidate >
          @csrf
          <input id="tipo" name="tipo" type="hidden" value="{{$tipo}}">
          <div class="card card-secondary card-outline">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" class="form-control" id="direccion" value="{{$provedor->direccion}}" name="direccion" placeholder="ingrese su direccion" pattern=".*\S+.*" autofocus required>
                    <div class="invalid-feedback">Introduzca su correo.</div>
                    @error('correo')
                    <small class="text-danger"> {{$message}}</small>
                    @enderror
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" class="form-control" id="telefono" value="{{$provedor->telefono}}" name="telefono" placeholder="ingrese su telefono" pattern=".*\S+.*" autofocus required>
                    <div class="invalid-feedback">Introduzca su nro de telefono.</div>
                    @error('telefono')
                    <small class="text-danger"> {{$message}}</small>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" class="form-control" id="correo" value="{{$provedor->correo}}" name="correo" placeholder="ingrese su correo" pattern=".*\S+.*" autofocus required >
                    <div class="invalid-feedback">Introduzca su correo.</div>
                    @error('correo')
                    <small class="text-danger"> {{$message}}</small>
                    @enderror
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group" id="opciones" >
                    <label for="">Tipo Provedor</label>
                    <div class="icheck-primary d-inline">
                      <br>
                      <input type="radio" id="opcion" name="opcion" @if ($tipo==1) {{'checked '}} @endif disabled value="1" onchange="mostrar(this.value);" pattern=".*\S+.*" autofocus required>Persona
                      <br>
                      <input type="radio"  id="opcion" name="opcion" @if ($tipo==0) {{'checked '}} @endif disabled value="2"  onchange="mostrar(this.value);" pattern=".*\S+.*" autofocus required>Empresa
                      <div class="invalid-feedback">seleccione una opcion.</div>
                      @error('opcion')
                      <small class="text-danger"> {{$message}}</small>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
             
              <div class="row" id="emp" @if($tipo==0) {{'style=display:block'}} @else  {{'style=display:none'}}  @endif >
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="razon"> Razon social </label>
                    <input type="text" class="form-control" id="razon_social" value="@if (isset($empresa->razonsocial))  {{$empresa->razonsocial}} @else {{'ninguno'}} @endif" name="razon_social" placeholder="ingrese su razon social de la empresa" pattern=".*\S+.*" autofocus required>
                    <div class="invalid-feedback">Introduzca una razson social de la empresa.</div>
                    @error('razon_social')
                    <small class="text-danger"> {{$message}}</small>
                    @enderror
                  </div>
                </div>
              </div>
              

              <div class="row" id="per" @if($tipo==1) {{'style=display:block'}} @else  {{'style=display:none'}}  @endif  >
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="nombre"> Nombre </label>
                    <input type="text" class="form-control" id="nombre" value="@if (isset($persona->nombre))  {{$persona->nombre}} @else {{'ninguno'}} @endif"  name="nombre" placeholder="ingrese su nombre" pattern=".*\S+.*" autofocus required >
                    <div class="invalid-feedback">Introduzca su nombre.</div>
                    @error('nombre')
                    <small class="text-danger"> {{$message}}</small>
                    @enderror
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="apellido"> Apellido </label>
                    <input type="text" class="form-control" id="apellido" value="@if (isset($persona->apellidos))  {{$persona->apellidos}} @else {{'ninguno'}} @endif" name="apellido" placeholder="ingrese su apellido" pattern=".*\S+.*" autofocus required >
                    <div class="invalid-feedback">Introduzca su apellido paterno y materno.</div>
                    @error('apellido')
                    <small class="text-danger"> {{$message}}</small>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end">
                <div>
                  <button type="submit" class= "btn btn-success btn-sm">Guardar</button> 
                  <a href="{{asset('provedor')}}" class= "btn btn-secondary btn-sm">Regresar</a>  
                </div>
              </div>
            </div>
            
          </div>

          
        </form>
      </div>
      
      {{-- ocultar y mostrar los imput--}}
      <script>
        function mostrar(dato){
            if(dato=="1"){
              document.getElementById("per").style.display = "block";
              document.getElementById("emp").style.display = "none";
                
            }
            if(dato=="2"){
              document.getElementById("per").style.display = "none";
              document.getElementById("emp").style.display = "block";
              
            }
        }
        </script>


      
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection