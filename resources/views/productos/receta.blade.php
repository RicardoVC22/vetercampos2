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
            <h1>Crear Receta</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item"><a href="">Producto</a></li>
              <li class="breadcrumb-item active">Crear Receta</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-sm-6">
                <form class="form-horizontal"  method="POST" action="{{asset('producto/receta/generar')}}" autocomplete="off">
                    @csrf
                    <div class="card card-outline card-primary">
    
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active btn-sm" href="#settings2" data-toggle="tab">Lista de ingredientes</a></li>
                            <li class="nav-item">
                            <select class="form-control"  id="id_producto" name="id_producto"  required>
                                <option selected disabled value="">Seleccionar Producto</option>
                                   @foreach ($productos as $producto)
                                   <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                   @endforeach
                            </select>
                            </li>
                            </ul>
                        </div><!--/.card-header-->
    
                       
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane  mb-0" id="settings2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="example2" class="table table-bordered table-sm table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Descripcion</th>
                                                        <th width="1%"></th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ingredientes as $ingrediente)
                                                      
                                                    <tr>
                                                        <td class="align-middle">{{$ingrediente->nombre}} </td>
                                                        <td class="align-middle">{{$ingrediente->descripcion}}</td>
                                                        <td>
                                                            <div  class="nav-item dropdown">
                                                                <a class="btn btn-primary btn-sm" id="btn{{$ingrediente->id}}" style="display:block" data-toggle="dropdown" href="#">
                                                                  <i class="fas fa-angle-double-right"></i>
                                                                </a> 
                                                            
                                                                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-sm-left">
                                                                    <div class="card-footer">
                                                                    <div class="row">
                                                                        <div class="col-sm-5">
                                                                            <div class="description-block">
                                                                                <input id="sw{{$ingrediente->id}}"  type="hidden" name="receta[]" value="0">
                                                                                <input  type="hidden" name="receta[]" value="{{$ingrediente->id}}">  
                                                                                <input  class="form-control-sm form-control" type="text" id="cantidad{{$ingrediente->id}}" name="receta[]" value="1" placeholder="cantidad" requerid>    
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-sm-6">
                                                                            <div class="description-block">
                                                                                <select role="button" data-toggle="dropdown" class="form-control-sm form-control" id="unidad{{$ingrediente->id}}"  name="receta[]" required>
        
                                                                                        <option value="mililitro(ml)">mililitro ml</option>
                                                                                        <option value="gramos(g)">gramos g</option>
                                                                                        <option value="tazas(1/3)">tazas 1/3</option>
                                                                                        <option value="tazas(1/2)">tazas 1/4</option>
                                                                                        <option selected value="cucharada 1/2">cucharada 1/2</option>
                                                                                        <option value="cucharada 1/3">cucharada 1/3</option>
                                                                                        <option value="cucharada 1/4">cucharada 1/4</option>
                                                                                        <option value="cucharaditas 1/2">cucharaditas 1/2</option>
                                                                                        <option value="cucharaditas 1/4">cucharaditas 1/4</option>
                                                                                        <option value="cucharaditas 1/5">cucharaditas 1/5</option>  
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <div class="description-block">  
                                                                            <a onclick="agregaringrediente('{{$ingrediente->id}}','{{$ingrediente->nombre}}','{{$ingrediente->descripcion}}')"  class="btn btn-success btn-sm">+</a> 
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>                                                        
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>  
                                                    @endforeach
                                                        
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> 
                                </div><!--/.tab-pane-->
    
                            </div><!--/.tab-content-->
                        </div><!--/.card-body -->

                    </div>  <!-- /.card -->
                    
                     
                    </div><!--/.col-md-6-->
    
                    <div class="col-12 col-sm-6">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <div class="table-responsive">
                                        <table id="tablaProductos"  class=" display table table-sm table-bordered table-hover">
                                            <thead class="bg-primary">
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th>Unidad</th>
                                                <th width= "1%"><i class="fas fa-trash"></i></th>
                                            
                                            </thead>
                                            <tbody>
                                                

                                            </tbody>
                                        </table>
                                </div>
                            </div><!--/body card-->
                            <div class="mb-3 text-center" >
                              <button class="btn btn-warning" type="submit">guardar</button>
                            </div>

                        </div><!--/card-->
 
                    </div><!--/.col-md-6-->

                </form><!--/form_venta-->
            </div>
        </div><!--/row-->
    </div><!-- /.container-fluid -->
             
        
    </section>
 </div>

 <script>
    function agregaringrediente(id,nombre,descripcion){
    var table = document.getElementById("tablaProductos");
    var rowCount = table.rows.length;
    var cant = document.getElementById("cantidad"+id).value;
    var unidad = document.getElementById("unidad"+id).value;
    var resul="<tr><td>"+rowCount+"</td><td>"+nombre;
        resul+="</td><td>"+descripcion+"</td><td>";
        resul+=cant+"</td><td>";
        //resul+=unidad+"</td><td><a onclick='eliminarFila("+id+")' <span  class='fas fa-fw fa-trash'></span></a></td></tr>";
        //resul+=unidad+"</td><td> <input class='btn btn-danger btn-sm' type='button' value='Delete' /> </td></tr>";
        resul+=unidad+"</td><td> <input class='btn btn-danger btn-sm' onclick='tableclick(event,"+id+")' type='button' value='Delete' /> </td></tr>";
        $("#tablaProductos>tbody").append(resul);
    document.getElementById("btn"+id).style.display = "none";
    document.getElementById("sw"+id).value=1;
   // document.getElementById().disabled=false;
    }
  </script>

  <script>


  //codigo para eliminiar por fila http://jsfiddle.net/hX4f4/2/
    function deleteRow(row) {
        document.getElementById('tablaProductos').deleteRow(row);

   //  var table = $('#tablaProductos').DataTable();

        //var rowArray = aTable.row(this).data();
      //  var colAchange = $('<span/>').html(rowArray[2]).text();
        //var aTable = $('#tablaProductos').DataTable(); 
   //   var colAchange = atable.cell(row, 1).data(); 
    //  var colBchange = atable.cell(row, 2).data();

     //var aTable = $('#tablaProductos').DataTable();
     //var colAchange=console.log(aTable.cell(row,2).nodes().to$().find('input').val());
     //var colBchange= console.log(aTable.cell(row,3).nodes().to$().find('input').val()) ;  

  //   $('#tablaProductos tbody').on('click', 'tr', function () {
  //  var data = table.row( row ).data();
  //  alert( 'You clicked on '+data[2]+'\'s row' );
  //  } );
    //  var data= table.row( $(1).parents("tr")).data();
     // console.log(data);
   //   alert("Name: " + colAchange +"ape: " + colBchange);

   // document.write(table[1]);
  
   } 
    function tableclick(e,id) {
        if(!e)
        e = window.event;
        console.log(e);
        if(e.target.value == "Delete")
        deleteRow( e.target.parentNode.parentNode.rowIndex );
        document.getElementById("btn"+id).style.display = "block";
        document.getElementById("sw"+id).value=0;
    }
   // document.getElementById('tablaProductos').addEventListener('click',tableclick,false);  eliminar tood
   // end codigo eliminar fila
  </script>


@endsection