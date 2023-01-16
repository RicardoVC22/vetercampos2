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
            <h1>Crear Consulta</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form method="POST" enctype="multipart/form-data" action="{{asset('consulta/store')}}" autocomplete="off" class="needs-validation" novalidate>
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
                                <label for="monto_consulta">Monto Consulta</label> 
                                <input class="form-control" id="monto_consulta" name="monto_consulta" type="text" value="100.0"  pattern=".*\S+.*" autofocus disabled />
                                <div class="invalid-feedback">Introduzca el monto.</div>
                                  @error('monto_consulta')
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
                              <label for="id_cliente">Seleccione el cliente</label> 
                              <select class="form-control" name="id_cliente" id="id_cliente">
                                @foreach ($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
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