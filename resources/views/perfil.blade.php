@extends('layouts.basehome')

@section('content')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> --}}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Perfil de usuario</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Datos Personales</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{asset('perfil/update')}}/{{Auth::user()->id}}" method="POST"  role="form">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{$nombre}}" placeholder="escriba su nombre" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{$apellidos}}" placeholder="escriba su apellido" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Edad</label>
                    <input type="number" class="form-control" id="edad" name="edad" value="{{$edad}}" placeholder="escriba su edad" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Telefono</label>
                    <input type="number" class="form-control" id="telefono" name="telefono" value="{{$telefono}}" placeholder="escriba su telefono" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="{{Auth::user()->email}}" disabled placeholder="escriba su correo" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Rol</label>
                    <input type="text" class="form-control" id="correo" name="correo" value="{{Auth::user()->roles[0]->name}}" disabled placeholder="escriba su correo" required>
                  </div>

                  @if ($licencia!="")
                    <div class="form-group">
                        <label>Categoria de licencia</label>
                        <select disabled class="form-control"  id="nro_licencia" name="nro_licencia"  required>
                        <option  value="">Seleccionar categoria</option>
                            <option  @if ($licencia=="Categoria A") {{'selected'}}  @endif value="Categoria A">categoria A</option>
                            <option  @if ($licencia=="Categoria B") {{'selected'}}  @endif value="Categoria B">categoria B</option>
                            <option  @if ($licencia=="Categoria C") {{'selected'}}  @endif value="Categoria C">categoria C</option>
                        </select>
                    </div>  
                  @endif

                  @if ($direccion!="")
                    <div class="form-group">
                      <label for="exampleInputPassword1">Direccion</label>
                      <input type="text" class="form-control" id="direccion" name="direccion" value="{{$direccion}}" placeholder="escriba su direccion" required>
                    </div> 
                  @endif

                  @if ($sueldo!="")
                    <div class="form-group">
                      <label for="exampleInputPassword1">Sueldo</label>
                      <input disabled type="text" class="form-control" id="sueldo" name="sueldo" value="{{$sueldo}}" placeholder="escriba su sueldo" required>
                    </div> 
                  @endif
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Cambiar Contraseña</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{asset('perfil/update/password')}}/{{Auth::user()->id}}" method="POST" role="form">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">contraseña actual</label>
                    <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nueva Contraseña</label>
                    <input type="password" class="form-control" name="nueva_contraseña" id="nueva_contraseña" placeholder="" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" name="confirmar_nueva_contraseña" id="confirmar_nueva_contraseña" placeholder="" required>
                  </div>
                  
                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>

    </div>
  </aside>
  <!-- /.control-sidebar -->

  <script  type="text/javascript">

  $(document).ready(function() {
    $(".btn-submit").click(function(e){
      e.preventDefault();
      let link="{{asset('')}}card-add";
      var _token = $("input[name='_token']").val();
      var producto_id = $("#producto_id").val();
  
      $.ajax({
        url: link,
        type:'POST',
        data: {_token:_token, producto_id:producto_id},
        success: function(data) {
          alert('j')
          printMsg(data);
        }
      });
    }); 

    function printMsg (msg) {
      if($.isEmptyObject(msg.error)){
        console.log(msg.success);
        $('.alert-block').css('display','block').append('<strong>'+msg.success+'</strong>');
      }else{
        $.each( msg.error, function( key, value ) {
          $('.'+key+'_err').text(value);
        });
      }
    }
  });
  </script>
  @endsection