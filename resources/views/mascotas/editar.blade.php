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
            <h1>Editar Mascota</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST"enctype="multipart/form-data" action="{{url('mascota/update/'.$mascota['id'])}}" autocomplete="off" class="needs-validation" novalidate>
              @method('PUT')
              @csrf
                <div class="card card-secondary card-outline">
                  <div class="card-body">
                    <!-- alert -->
                     @if ($errors->any())
                     <div class="row ">
                       <div class="col-md-6 offset-md-3">
                           <div class="alert alert-danger alert-dismissible">
                               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                               <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                 @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                                 @endforeach
                           </div>
                       </div>
                     </div>
                     @endif

                     <div class="row">
                         <div class="col-sm-6">
                             <div class="form-group">
                               <label for="nombre">Nombre</label> 
                               <input class="form-control" id="nombre" name="nombre" type="text" value="{{$mascota->nombre}}"placeholder="ingrese su nombre " pattern=".*\S+.*" autofocus required />
                               <div class="invalid-feedback">Introduzca el nombre.</div>
                               @error('nombre')
                               <small class="text-danger"> {{$message}}</small>
                               @enderror
                             </div>
                         </div>
                         <div class="col-sm-6">
                             <div class="form-group">
                               <label for="fecha">fecha nacimiento</label> 
                               <input class="form-control" id="fecha" name="fecha" type="date" pattern=".*\S+.*" placeholder="ingrese su fecha nacimiento"value="{{$mascota->fecha_nac}}" required />
                               <div class="invalid-feedback">Por favor, coloque su fech de nac.</div>
                               @error('fecha')
                               <small class="text-danger"> {{$message}}</small>
                               @enderror
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-sm-6">
                           <div class="form-group">
                             <label for="sexo">sexo</label>
                                 <select class="form-control"  id="sexo" name="sexo"  required>
                                     <option selected disabled value="">seleccione uno</option>
                                     
                                     <option @if ($mascota->sexo==0) selected @endif value="0">hembra</option>
                                     <option @if ($mascota->sexo==1) selected @endif value="1">macho</option>
                                     
                                 </select>
                                 <div class="invalid-feedback">Seleccione una categoría.</div>
                                 @error('sexo')
                                 <small class="text-danger"> {{$message}}</small>
                                 @enderror
                             </div>
                         </div>
                         <div class="col-sm-6">
                           <div class="form-group">
                             <label for="id_cliente">Cliente</label>
                                 <select class="form-control"  id="id_cliente" name="id_cliente"  required>
                                 <option selected disabled value="">Seleccionar su duenio</option>
                                     @foreach ($clientes as $cliente)
                                       <option @if ($mascota->id_cliente==$cliente->id) selected @endif value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                                     @endforeach
                                 </select>
                                 <div class="invalid-feedback">Seleccione una categoría.</div>
                                 @error('id_cliente')
                                 <small class="text-danger"> {{$message}}</small>
                                 @enderror
                             </div>
                           </div>
                     </div>
                   
                     <div class="row">
                       <div class="col-sm-6">
                         <div class="form-group">
                           <label for="color">color</label>
                         
                           <input class="form-control" id="color" name="color" type="text" value="{{$mascota->color}}"placeholder="ingrese su color " pattern=".*\S+.*" autofocus required />
                           <div class="invalid-feedback">Introduzca el color.</div>
                           @error('color')
                           <small class="text-danger"> {{$message}}</small>
                           @enderror
                         </div>
                       </div>
                       <div class="col-sm-6">
                         <div class="form-group">
                           <label for="raza">Raza</label>
                         
                           <input class="form-control" id="raza" name="raza" type="text" value="{{$mascota->raza}}"placeholder="ingrese su raza " pattern=".*\S+.*" autofocus required />
                           <div class="invalid-feedback">Introduzca la raza.</div>
                           @error('raza')
                           <small class="text-danger"> {{$message}}</small>
                           @enderror
                         </div>
                       </div>
                     </div>
                   

                     @php
                     $imagen = "img/mascotas/".$mascota['id'].".jpg";
                     if (!file_exists($imagen)) {
                       $imagen = "img/mascotas/150x150.png";
                     }
                   @endphp
                     <div class="row">
                       <div class="col-sm-6">
                           <div class="form-group">
                           <label for="customFile">Previsualizar imagen</label>
                               <div class="row col-sm-6">
                                   <img id="blah" class="img-fluid" src="{{asset($imagen.'?'.time())}}" alt="Photo" style="max-height: 160px;">
                               </div>
                           </div>
                         </div>
                     </div>

                     

                     <div class="row">
                       <div class="col-sm-6">
                           <div class="custom-file">
                               <input style="cursor: pointer;" type="file" id="img_mascota"  name="img_mascota" class="custom-file-input" accept="image/jpeg,jpg" >
                               <div class="invalid-feedback">Seleccione una imagen porfavor.</div>
                               @error('img_mascota')
                               <small class="text-danger"> {{$message}}</small>
                               @enderror
                               <label class="custom-file-label align-middle" for="img_mascota" data-browse="Buscar">Seleccione una foto</label>
                           </div>
                       </div>
                       <div class="col-sm-6">
                           <div class="d-flex justify-content-end">
                               <div class="mt-4">
                                   <button type="submit" class= "btn btn-success btn-sm">Guardar</button>
                                   <a href="{{ url('mascota') }}" class= "btn btn-secondary btn-sm">Regresar</a>
                               </div>
                           </div>
                       </div>
                     </div>
   
                   </div><!--/body card-->

                </div><!--/CARD FIN-->
            </form>

        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
  function readImage (input) {
      if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
      }
  }
  $("#img_mascota").change(function () {
      readImage(this);
  });
  </script>
@endsection
