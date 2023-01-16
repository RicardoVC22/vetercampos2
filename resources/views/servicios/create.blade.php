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
            <h1>Crear servicio</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" enctype="multipart/form-data" action="{{asset('servicio/store')}}" autocomplete="off" class="needs-validation" novalidate>
              @method('POST')
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
                              <label for="id_tipo_servicio">Tipo servicio</label>
                                  <select class="form-control"  id="id_tipo_servicio" name="id_tipo_servicio"  required>
                                  <option selected disabled value="">Seleccionar servicio</option>
                                      @foreach ($tipo_servicios as $tipo_servicio)
                                      <option value="{{$tipo_servicio->id}}">{{$tipo_servicio->nombre}}</option>
                                      @endforeach
                                  </select>
                                  <div class="invalid-feedback">Seleccione una servicio.</div>
                                  @error('id_categoria')
                                  <small class="text-danger"> {{$message}}</small>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="precio">Precio</label>
                              <input class="form-control" id="precio" name="precio" type="text"placeholder="ingrese el precio " pattern=".*\S+.*" value="{{old('precio')}}" required/>
                              <div class="invalid-feedback">Introduzca un precio.</div>
                              @error('precio')
                              <small class="text-danger"> {{$message}}</small>
                              @enderror
                            </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="customFile">Previsualizar imagen</label>
                                <div class="row col-sm-6">
                                    <img id="blah" class="img-fluid" src="{{asset('vendor/dist/img/150x150.png')}}" alt="Photo" style="max-height: 160px;">
                                </div>
                            </div>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                            <div class="custom-file">
                                <input style="cursor: pointer;" type="file" id="img_producto" name="img_producto" class="custom-file-input" accept="image/jpeg,jpg" >
                                <div class="invalid-feedback">Seleccione una imagen porfavor.</div>
                                @error('img_producto')
                                <small class="text-danger"> {{$message}}</small>
                                @enderror
                                <label class="custom-file-label align-middle" for="img_producto" data-browse="Buscar">Seleccione una foto</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <div class="mt-4">
                                    <button type="submit" class= "btn btn-success btn-sm">Guardar</button>
                                    <a href="{{ url('servicio') }}" class= "btn btn-secondary btn-sm">Regresar</a>
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
$("#img_producto").change(function () {
    readImage(this);
});
</script>

@endsection