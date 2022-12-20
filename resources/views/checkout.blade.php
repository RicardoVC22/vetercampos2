@extends('layouts.basehome')

@section('content')
<style>
  @media(max-width: 700px) {
    #div_maps {
      height: 320px;
    }
  }

  @media(min-width: 700px) {
    #div_maps {
      height: 380px;
    }
  }

  #map {
    width: 100%;
    height: 100%;
  }
  .disabled {
    cursor: not-allowed;
    pointer-events: none;
  }

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"> <small> Detalle Pedido</small></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
    
      <div class="container">
        <div class="row">
            <div class="col-12">
              <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"> Lista</h3>
                </div>

                    <div class="card-body">
                        
                        @if (count(Cart::getContent()))
                        <div class="d-flex justify-content-end">
                            <div class="form-group">
                                <form action="{{route('cart.clear')}}"method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type ="submit" title="Eliminar"><i class="far fa-trash-alt"></i>&nbsp;Limpiar Carrito</button>
                                </form>
                                </div>
                        </div>
                        @endif
                        
                      <div class="table-responsive">
                        <table id="tabla" class="table table-bordered table-sm table-hover mb-0">
                            <thead class="text-center">
                                <tr>
                                  <th width="5%" > Nro </th>
                                  <th> nombre </th>
                                  <th >Precio</th>
                                  <th width="15%" >Cantidad</th>
                                  <th width="12%">Subtotal</th>
                                  <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                              @php
                                  $c=1;
                              @endphp
                               @forelse  (Cart::getContent() as $key => $item)
                                <tr>
                                    <td>{{$c++;}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{number_format($item->price,2)}}</td>
                                    
                                    <td>
                                        <form id="form-update" action="{{ route('cart.update') }}" method="POST">
                                          @csrf
                                            <div class="input-group input-group-sm mb-0">
                                         
                                              <input type="hidden" value="{{ $item->id}}" id="id" name="id">
                                              <input type="number"class="form-control"style="width:25px;" id="quantity" name="quantity" title="cantidad"value="{{ $item->quantity }}" min="1" pattern="^[1-9]+">
                                              <span class="input-group-append">
                                                  <button type="submit"class="btn btn-success btn-flat" title="Lista de producto" data-toggle="modal" data-target="#lista"><i class="fa fa-edit"></i></button>
                                              </span>
                                          </div> 
                                      </form>
                                    </td>
                                 
                                    <td>{{$item->getPriceSum()}}</td>
                                    <td class="py-1 align-middle text-center">
                                      <form id="form-del" action="{{route('cart.removeitem')}}"method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <button class="btn btn-danger btn-sm" type ="submit" title="Eliminar"><i class="fas fa-trash"></i></button>
                                      </form>
                                    </td>
                                </tr>
                               
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Carrito vacio</td>
                                </tr>
                              @endforelse
                             
                            </tbody>
                            {{-- @if (count(Cart::getContent()))
                            <tfoot>
                                <th colspan="4"class=" text-right">TOTAL :</th>
                                <th colspan="1" class=" text-center">
                                    <div id="total">  {{number_format(Cart::getSubTotal(),2)}} Bs.</div>
                                </th>
                            </tfoot>
                            @endif --}}
                        </table>
                      </div>
                      @if (count(Cart::getContent()))
                      <br>
                      <div class="row mb-0">
                        <div class="col">
                          <div class="d-flex justify-content-left">
                            <div class="form-group mb-0">
                              <div class="card mb-0">
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item"><b>Cantidad Total: </b>{{Cart::getTotalQuantity()}}</li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="d-flex justify-content-end">
                            <div class="form-group  mb-0">
                              <div class="card shadow-ms mb-0">
                                <ul class="list-group list-group-flush">
                                  <li class="list-group-item"><b>Monto Total: </b>{{number_format(Cart::getTotal(),2)}} Bs.</li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.row -->
                      @endif

                    </div>
                    <!-- /.card-body -->
              </div>

            @if (count(Cart::getContent()))
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title  w-100 text-center font-weight-bold text-light">MI PEDIDO</h3>
              </div>
              
                  <div class="card-body">
                      @guest
                        @if (Route::has('login'))
                        @endif
                      @else
                        <!-- /input-group -->
                        <form method="POST" action="" autocomplete="off">
                          @csrf
                          <input type="hidden" id="id_usuario" name="id_usuario" value="{{ Auth::user()->id }}"/>
                          <input type="hidden" id="id_cliente" name="id_cliente" value="{{$cliente['id']}}"/>

                          <div class="row row-cols-1 row-cols-sm-2  row-cols-md-3 g-3">

                            <div class="col">
                              <div class="form-group">
                                <label>Correo</label>
                                <input class="form-control form-control-sm" id="correo" name="correo" type="email"value="{{ Auth::user()->email }}" disabled />
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label>Nombre</label> 
                                <input class="form-control form-control-sm me-md-8" id="nombre" name="nombre" type="text"  value="{{ Auth::user()->name }}" disabled />
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label>Apellidos</label>
                                <input class="form-control form-control-sm" id="apellidos" name="apellidos" type="text"  value="{{$cliente['apellidos']}}" disabled/>
                              </div>
                            </div>
                         
                              <div class="col">
                                <div class="form-group">
                                  <label class="text-center">Telefono</label>
                                  <input class="form-control form-control-sm" id="telefono" name="telefono" type="tel" value="{{$cliente['telefono']}}" disabled/>
                                </div>
                              </div>
                              
                              <div class="col">
                                <div class="form-group">
                                  <label>Fecha</label>
                                  <input class="form-control form-control-sm" id="fecha" name="fecha" type="tel" value="{{date('Y-m-d')}}" disabled/>
                                </div>
                              </div>
                              {{-- DATOS PARA LA TABLA UBICACION --}}
                              <div class="col">
                                <div class="form-group">
                                  <label>Mi URL Google Maps</label>
                                  <div class="input-group input-group-sm mb-0 eliminarbtn">
                                    <input type="text" class="form-control" id="url_ubicacion" name="url_ubicacion" title="Producto" disabled>
                                    <span class="input-group-append">
                                      <a target="_blank" href="#" id="link_ubicacion" class="btn btn-warning btn-flat disabled" title="Ir a mi ubicación" disabled><i class="fas fa-map-marker-alt"></i></a>
                                    </span>
                                  </div>
                                </div>
                              </div>
 
                              <div class="col">
                                <div class="form-group">
                                  <label>Latitud</label>
                                  <input class="form-control form-control-sm" id="latitud_y" name="latitud_y" type="text"  value="" disabled/>
                                </div>
                              </div>
                           
                              <div class="col">
                                <div class="form-group">
                                  <label class="text-center">Longitud</label>
                                  <input class="form-control form-control-sm" id="longitud_x" name="longitud_x" type="text" value="" disabled/>
                                </div>
                              </div>

                              <div class="col">
                                <div class="form-group">
                                  <label>Ubicación:</label>
                                  <div class="d-flex justify-content-start">
                                    <button class="btn btn-danger btn-sm btn-flat" title="Agregar ubicación" data-toggle="modal" data-target="#maps" type="button"  data-toggle="modal" class="twitter" ><i class="fas fa-map-marker-alt"></i> Seleccionar mi ubicación</button>
                                  </div>
                                </div>
                              </div>
                            </div> 

                            <div class="row">
                              <div class="col-sm-12">
                                <div class="form-group">
                                  <label>Referencia de la ubicación</label> 
                                  <textarea class="form-control" id="referencia" name="referencia" rows="3"  pattern=".*\S+.*" required></textarea>
                                </div>
                              </div>
                            </div>
                            {{---------------- FIN --------------_--}}

                          <div class="d-flex justify-content-center">
                            <div class="row">
                              <div class="col-12">
                                <button class="btn btn-warning btn-flat" type="button" id="completa_pedido" onclick="guardarpedido()">Solicitar Pedido</button>
                              </div>
                            </div>
                          </div>

                        </form><!--/form-->

                        @endguest
                    @endif
                  </div><!--/body card-->
                
            </div>
          </div>
            <!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



 <!-- Modal lista product-->
 <div class="modal fade" id="maps">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header p-2 px-3 lg-dark" lg-dark style="background:#3c8dbc; color:white;">
          <h4 class="modal-title w-100 text-center">Marca tu ubicación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>

      <div class="modal-body px-0 py-0">

        <div id="div_maps">
          <!--  GOOGLE MAPS-->
          <div id="map"></div>

            <div style="display:none">
              Nueva Ubiv.<input type="text" id="coords" />
              {{-- Latitud <input class="xy" type="text" id="longitud" name="longitud" />
              Longitud <input class="xy" type="text"id="latitud" name="latitud" /> --}}
            </div>

            <div id="ayuda" align="center">
              <p id="nomDir"> </p>
          </div>
          <input type="text" id="txtDir" name="txtDir" style="display:none">
          <!-- END ,MAPS -->
        </div>

      </div>

      <div class="modal-footer p-2">
 
          <div class="container">
            <div class="row">
              <div class="col-md-12">

                <div class="form-group row mb-0">
                  <div class="col-sm-2">
                    <button type="button" class="btn btn-info btn-sm btn-lg btn-block"  name="confir_ubv" id="confir_ubv" onclick="addUbicacion(longitud.value,latitud.value,txtDir.value); ">Aceptar</button>
                  </div>
                  <label for="latitud" class="col-sm-2 form-control-sm col-form-label text-center">Latitud:</label>
                  <div class="col-sm-3">
                    <input type="email" class="form-control form-control-sm" id="latitud"  name="longitud" placeholder="Latitud">
                  </div>
                  <label for="longitud" class="col-sm-2 form-control-sm col-form-label text-center">Longitud:</label>
                  <div class="col-sm-3">
                    <input type="email" class="form-control form-control-sm" id="longitud" name="longitud" placeholder="Email">
                  </div>
                
                </div>
              </div>
            </div>
          </div> {{-- container --}}
         

      </div><!-- /.modal-footer -->

   

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<script type="text/javascript">

  function click(){
      alert('Error')
  }

  function guardarpedido() { 


    let url = '{{url('')}}/pedido/store';

    id_usuario    = document.getElementById("id_usuario").value;
    id_cliente    = document.getElementById("id_cliente").value;
    correo        = document.getElementById("correo").value;
    nombre        = document.getElementById("nombre").value;
    apellidos     = document.getElementById("apellidos").value;
    telefono      = document.getElementById("telefono").value;
    fecha         = document.getElementById("fecha").value;
    url_ubicacion = document.getElementById("url_ubicacion").value;
    latitud_y     = document.getElementById("latitud_y").value;
    longitud_x    = document.getElementById("longitud_x").value;
    referencia    = document.getElementById('referencia').value;

    Swal.fire({
        title: '¿Estás seguro de solicitar el pedido?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '!Si, solicitar!',
  
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
              url: url,
              method: "POST",
              data: {
                  "_token"          :"{{ csrf_token() }}",
                  "id_usuario"      :id_usuario,
                  "id_cliente"      :id_cliente,
                  "correo"          :correo,
                  "apellidos"       :apellidos,
                  "telefono"        :telefono,
                  "fecha"           :fecha,
                  "url_ubicacion"   :url_ubicacion,
                  "latitud_y"       :latitud_y,
                  "longitud_x"      :longitud_x,
                  "referencia"      :referencia,
              },
              success: function(resultado){
                  if (!resultado) {
                      alert('error');
                  }
                  else{
                      if (resultado.error) {
                          if (resultado.errors.latitud_y) {toastr.error(resultado.errors.latitud_y)}
                          if (resultado.errors.longitud_x) { toastr.error(resultado.errors.longitud_x)}
                          if (resultado.errors.url_ubicacion) {toastr.error(resultado.errors.url_ubicacion)}
                          if (resultado.errors.referencia) { toastr.error(resultado.errors.referencia)}
                      }else{
                        var resultado= JSON.parse(resultado);
                        if(resultado.error){
                          mostrarerror('error','Error de stock vuelva a intentar más tarde') 
                        }else{
                          $('#completa_pedido').prop('disabled', true);
                          mostrarerror('success','Datos registrados correctamente');
                          setTimeout(redirigir, '3000');
                        }
                      }
                  }
              },
              
          });
        }else{
  
        }
    });

  
    }
    function redirigir(){
      window.location.href ='{{url('')}}/card-checkout';
    }
    function mostrarerror(icono,error){
     Toast.fire({icon: icono,title: error});
    }





</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoW4LyeLOiPgOmChMyAacirIgO7zqriGw&callback=initMap&libraries=geometry"
type="text/javascript" >
</script>

<script type="text/javascript">
  var marker;
  var coords = {};
  var x=document.getElementById("nomDir");
  var options = {
  enableHighAccuracy: true,
  timeout: 6000,
  maximumAge: 0
  };

/*============================= FUNCION PRINCIPAL ==================================*/
  initMap = function(){

    //navigator.geolocation.getCurrentPosition(viewMap,ViewError,{timeout:3000});
    //usamos la API para geolocalizar el usuario

    navigator.geolocation.getCurrentPosition(function (position){
      coords =  {
      lng: position.coords.longitude,
      lat: position.coords.latitude,
      };
      document.getElementById("longitud").value = position.coords.longitude;
      document.getElementById("latitud").value = position.coords.latitude;
      setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa

    },function(error){

      // El segundo parámetro es la función de error
      switch(error.code)
      {
        case error.PERMISSION_DENIED:
        // El usuario denegó el permiso para la Geolocalización.
        console.log(error);
        Swal.fire({icon:'info', title: 'Aviso', text: 'Por favor permita el acceso a su ubicación.'})
        break;
        case error.POSITION_UNAVAILABLE:
        // La ubicación no está disponible.
        console.log(error);
        Swal.fire({icon: 'info', title: 'Aviso', text: 'Active su GPS y recargue la página.'})
        break;
        case error.TIMEOUT:
        // Se ha excedido el tiempo para obtener la ubicación.
        console.log(error);
        Swal.fire({icon: 'info', title: 'Aviso', text: 'Active su GPS y recargue la página.'})
        break;
        case error.UNKNOWN_ERROR:
        // Un error desconocido.
        console.log(error);
        Swal.fire({ icon: 'info', title: 'Aviso', text: 'INTENTE MÁS TARDE.', })
        break;
      }
      coords =  {
        lng: '-17.34981426967225',
        lat: '-63.262442186041355'
      };
      document.getElementById("longitud").value = '-17.34981426967225';
      document.getElementById("latitud").value =  '-63.262442186041355';
      setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa

    },options);
  }

/*============================= FUNCION SETMAPA ==================================*/
  function setMapa (coords)
  {
    //Se crea una nueva instancia del objeto mapa
    var map = new google.maps.Map(document.getElementById('map'),{
        zoom: 17,
        center:new google.maps.LatLng(coords.lat,coords.lng),
    });

    //Creamos el marcador en el mapa con sus propiedades
    //para nuestro obetivo tenemos que poner el atributo draggable en true
    //position pondremos las mismas coordenas que obtuvimos en la geolocalización
    marker = new google.maps.Marker({
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      title:"Mi ubicación actual",
      position: new google.maps.LatLng(coords.lat,coords.lng),
    });
    //map.setCenter(pos);
    //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
    //cuando el usuario a soltado el marcador
    marker.addListener('click', toggleBounce);

    marker.addListener( 'dragend', function (event)
    {
      //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
      document.getElementById("coords").value =   this.getPosition().lat()+","+ this.getPosition().lng();
      document.getElementById("longitud").value = this.getPosition().lng();
      document.getElementById("latitud").value =  this.getPosition().lat();

      var long=this.getPosition().lat();
      var lat=this.getPosition().long();

      var locApi="https://maps.googleapis.com/maps/api/geocode/json?latlng="+long+","+lat+"&sensor=true";
      //x.innerHTML=locApi+"<br>"+loc.loc +"<br>"+loc.city +"<br>"+loc.region +"<br>";
      var cadena="";

      $.get({
        url: locApi,
        success:function(data)
        {
          console.log(typeof data);
          //console.log(data.results.length);
          if(data.results.length > 0){
            cadena=data.results[0].address_components[0].long_name+", ";
            cadena+=data.results[0].address_components[1].long_name+", ";
            //cadena+=data.results[0].address_components[4].long_name;
            x.innerHTML=cadena;
            document.getElementById("txtDir").value=cadena;
          }else{
            x.innerHTML="La ubicacion no se reconoce, por favor intente de nuevo";
          }

        },
        error:function(data){
          console.log(data);
        }
      });
    });
  }

/*============================= FUNCION toggleBounce =================================*/
  //callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
  function toggleBounce(){
    if (marker.getAnimation() !== null){
      marker.setAnimation(null);
    }else{
      marker.setAnimation(google.maps.Animation.BOUNCE);
    }
  }

/*============================= FUNCION addUbicacion =================================*/
  function addUbicacion(x,y,dir)
  {
    let latitud1=-63.256608;//latitud de la empresa
    let longitud1=-17.334064;//longitud de la empresa
  
    if( y!='' && x!=''){
      let url_ubicacion = 'https://maps.google.com/?q='+y+','+x
      $("#latitud_y").val(y);
      $("#longitud_x").val(x);
      $("#url_ubicacion").val(url_ubicacion);
      document.getElementById('link_ubicacion').setAttribute('href', url_ubicacion);
      var a = document.getElementById('link_ubicacion');
      a.classList.remove('disabled');
      let latitud2=x; //latitud del destino
      let longitud2=y;//longitud del destino

      (calculateDistance(latitud1,longitud1,latitud2,longitud2));
      $('#maps').modal('hide');
      toastr.success('Añadido','Gracias por darnos tu ubicacion!') 
      // Swal.fire('Gracias por darnos tu ubicacion!', ' ','success')
    }else{
      Swal.fire('Seleccione su ubicacion por favor', ' ','error')
    }
  }
/*============================= FUNCION calculateDistance ================================*/
  function calculateDistance(lt1,lng1,lt2,lng2) {

    var origin = new google.maps.LatLng(lng1, lt1);
    var destination = new google.maps.LatLng(lng2, lt2);
    var service = new google.maps.DistanceMatrixService();

    service.getDistanceMatrix(
    {
      origins: [origin],
      destinations: [destination],
      travelMode: google.maps.TravelMode.DRIVING,
      //unitSystem: google.maps.UnitSystem.IMPERIAL, // millas y pies.
      unitSystem: google.maps.UnitSystem.metric, // kilometros y metros
      avoidHighways: false,
      avoidTolls: false
    }, callback);

  }
/*============================= FUNCION callback ================================*/
  function callback(response, status)
  {
  if (status != google.maps.DistanceMatrixStatus.OK){
    console.log(origin);
  }else{
      var origin = response.originAddresses[0];
      var destination = response.destinationAddresses[0];
      
      if (response.rows[0].elements[0].status === "ZERO_RESULTS"){
          $('#textTiempo').val("No hay distancia para  "  + origin + " and " + destination);
          console.log(origin);
      }else{
          var distance = response.rows[0].elements[0].distance;
          var duration = response.rows[0].elements[0].duration;
          var distanciaKilometro = distance.value / 1000; // Kilometro
          //var distanciaMillas = distance.value / 1609.34; // millas
          var duracionText = duration.text; //tiempo en formato (1 hours 50 min) (1 h 6 min)
          //aumentamos 10 minutos de preparacion que son 600 segundos
          var duracionValue = duration.value + 600;// tiempo en formato solo segundos

          $('#textDistancia').val(distanciaKilometro.toFixed(2));//distancia en km

          //llamamos a la funcion para calcular el precio de acuerdo a km
          // recargoPedido(distanciaKilometro);
          // //llamamos a la funcion para calcular el tiempo
          convertirSegundosAhoraMinutos(duracionValue);
      }
    }
  }
</script>
  @endsection