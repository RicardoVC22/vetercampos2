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
            <h1>Asignar Mascota</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" enctype="multipart/form-data" action="{{asset('consulta/mascota_store')}}" autocomplete="off" class="needs-validation" novalidate>
              @method('POST')
              @csrf
              <input type="hidden" value="{{$id_consulta}}" id="id_consulta" name="id_consulta">
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
                              <label for="id_cliente">Seleccione la mascota del cliente</label> 
                              <select class="form-control" name="id_mascota" id="id_mascota">
                                @foreach ($mascotas as $mascota)
                                    <option value="{{$mascota->id}}">{{$mascota->nombre}}</option>
                                @endforeach
                              </select>
                          
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              
                            </div>
                        </div>
                    </div>
                      

                      

                      <div class="row">
                        <div class="col-sm-6">
                            
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end">
                                <div class="mt-4">
                                    <button type="submit" class= "btn btn-success btn-sm">Guardar</button>
                                    <a href="{{ url('consulta') }}" class= "btn btn-secondary btn-sm">Regresar</a>
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



@endsection