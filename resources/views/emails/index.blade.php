@extends('layouts.basehome')
@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> Contactanos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Contacto</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container">


      <div class="row justify-content-md-center">
        <div class="col-md-8">

  


<div class="card shadow-lg card-danger card-outline mb-3">
    <div class="card-header  text-center text-danger"><b>FORMULARIO</b></div>
    <div class="card-body"> 

        <form action="{{route('contactanos.store')}}" method="POST" class="needs-validation" novalidate>
        @csrf
            <div class="mb-3">
              <label for="asunto" class="form-label fw-bold text-danger">Asunto:</label>
              <input class="form-control" type="text" name="asunto"id="asunto" placeholder="Ingrese el Asunto" required>
              <div class="invalid-feedback">
                Porfavor ingrese el asunto.
              </div>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label fw-bold text-danger">Nombre:</label>
                <input class="form-control" type="text" name="name"id="name" placeholder="Ingrese su nombre" required>
                <div class="invalid-feedback">
                   Porfavor ingrese su nombre.
                </div>
            </div>

            @error('name')
                <p><strong>{{$message}}</strong></p>
            @enderror

            <div class="mb-3">
                <label for="correo" class="form-label fw-bold text-danger">Correo remitente:</label>
                <input class="form-control" type="email" name="correo"id="correo" placeholder="Ingrese su correo" required>
                <div class="invalid-feedback">
                    Porfavor ingrese su correo.
                 </div>
            </div>

            @error('correo')
                <p><strong>{{$message}}</strong></p>
            @enderror

          <div class="mb-3">
              <label for="correodestino" class="form-label fw-bold text-danger">Correo destinatario:</label>
              <input class="form-control" type="email" name="correodestino"id="correodestino" placeholder="Ingrese su correo" required>
              <div class="invalid-feedback">
                  Porfavor ingrese el correo destino.
               </div>
          </div>

            @error('correodestino')
                <p><strong>{{$message}}</strong></p>
            @enderror

            <div class="mb-3">
                <label for="mensaje" class="form-label fw-bold text-danger">Mensaje:</label>
                <textarea class="form-control" id="mensaje" type="text" name="mensaje" placeholder="Ingrese su Mensaje."rows="3" required></textarea>
                {{-- <div class="invalid-feedback"> --}}
                <div class="invalid-feedback">
                    Introduzca un mensaje en el área de texto.
                </div>
            </div>

            @error('mensaje')
                <p><strong>{{$message}}</strong></p>
            @enderror
            <div>
               <center><button class="btn btn-danger" onclick="" type="submit">Enviar Mensaje</button></center>
              </div>
        </form>
            @if (Session::has('info'))
                <div class="row ">
                    <div class="col-md-12">
                        <div class="alert alert-success my-3 mb-2 alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong><i class="icon fas fa-check"></i> Enviado!</strong> {{Session::get('info')}}
                        </div>
                    </div>
                </div>
            @else
              {{-- <div class="row ">
                  <div class="col-md-12">
                      <div class="alert alert-danger my-3 mb-2 alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <strong><i class="icon fas fa-ban"></i> Error!</strong> No se envio el mensaje
                      </div>
                  </div>
              </div> --}}
            @endif


        </div><!--card-body-->
    </div><!--card-->

  </div>
</div>








  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->





<script>

 // Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')
  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()

</script>
@endsection