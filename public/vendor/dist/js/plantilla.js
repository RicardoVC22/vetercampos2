/*======================== INICIO MODO OSCURO 1 ==========================*/
let modo=document.getElementById('#modo');
let body=document.body;
/*
modo.addEventListener("click", function(){
    let val=body.classList.toggle('dark-mode')
    localStorage.setItem('modo',val)
})

let valor=localStorage.getItem("modo")
if (valor=="true") {
    body.classList.add("dark-mode")
} else {
    body.classList.remove("dark-mode")
}*/

/*======================== INICIO MODO OSCURO 2 ==========================*/
 // modo oscuro
 var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
 var currentTheme = localStorage.getItem('theme');
 var mainHeader = document.querySelector('.main-header');

 if (currentTheme) {
   if (currentTheme === 'dark') {
     if (!document.body.classList.contains('dark-mode')) {
       document.body.classList.add("dark-mode");
     }
     if (mainHeader.classList.contains('navbar-light')) {
       mainHeader.classList.add('navbar-dark');
       mainHeader.classList.remove('navbar-light');
     }
     toggleSwitch.checked = true;
   }
 }

 function switchTheme(e) {
   if (e.target.checked) {
     if (!document.body.classList.contains('dark-mode')) {
       document.body.classList.add("dark-mode");
     }
     if (mainHeader.classList.contains('navbar-light')) {
       mainHeader.classList.add('navbar-dark');
       mainHeader.classList.remove('navbar-light');
     }
     localStorage.setItem('theme', 'dark');
   } else {
     if (document.body.classList.contains('dark-mode')) {
       document.body.classList.remove("dark-mode");
     }
     if (mainHeader.classList.contains('navbar-dark')) {
       mainHeader.classList.add('navbar-light');
       mainHeader.classList.remove('navbar-dark');
     }
     localStorage.setItem('theme', 'light');
   }
 }

 toggleSwitch.addEventListener('change', switchTheme, false);

/*========================= COMPLEMENTO MODAL-CONFIRMA ===========================*/
  $('#modal-confirma').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  }); 
/*========================= COMPLEMENTO VALIDACION ===========================*/
(function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
 
/*========================= alerta22 ===========================*/

  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
  // var Toast = Swal.mixin({
  //   toast: true,
  //   position: 'top-end',
  //   showConfirmButton: false,
  //   timer: 3000,
  //   timerProgressBar: true,
  //   didOpen: (toast) => {
  //     toast.addEventListener('mouseenter', Swal.stopTimer)
  //     toast.addEventListener('mouseleave', Swal.resumeTimer)
  //   }
  // })
  

  $('.swalDefaultSuccess').click(function() {
    Toast.fire({
      icon: 'success',
      title: 'Loasassascing elitr.'
    })
  });
  $('.swalDefaultInfo').click(function() {
    Toast.fire({
      icon: 'info',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.swalDefaultError').click(function() {
    Toast.fire({
      icon: 'error',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.swalDefaultWarning').click(function() {
    Toast.fire({
      icon: 'warning',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.swalDefaultQuestion').click(function() {
    Toast.fire({
      icon: 'question',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });


 
/*========================= alerta22 ===========================*/
  

$(document).ready(function() {
    $("#completa_compra").click(function () {
        let nFila= $("#tablaProductos tr").length;
        if(nFila <2){
            Toast.fire({
                icon: 'error',
                title: 'Agregue los productos que desea comprar.'
            })
        }else{
          
          Toast.fire({
            icon: 'success',
            title: 'Comprar registrada y stock axtualizado.',
            timer: 7000
          })
          $("#form_compra").submit();
        }
    });
});

function buscarProducto(e,tagCodigo,codigo){
    var enterKey = 13;
    if (codigo != ''|| (e.keyCode==8)) {
        if (e.which == enterKey) {
            $.ajax({
                url: base_url+'/productos/buscarPorCodigo/'+ codigo, dataType:'json',
                success: function(resultado){
                    if (resultado == 0) {
                        $(tagCodigo).val('');
                    }
                    else{
                        if (resultado.existe) {
                            $("#resultado_error").html('');
                            $("#id_producto").val(resultado.datos.id);
                            $("#nombre").val(resultado.datos.nombre);
                            $("#cantidad").val(1);
                            $("#precio_compra").val(resultado.datos.precio_compra);
                            $("#subtotal").val(resultado.datos.precio_compra);
                            $("#cantidad").focus();
                            document.getElementById('cantidad').disabled=false;
                        }else{
                          $("#resultado_error").html(resultado.error);
                        }
                    }
                }
            });
        }else{
            document.getElementById('cantidad').disabled=true;
            $("#id_producto").val('');
            $("#nombre").val('');
            $("#cantidad").val('');
            $("#precio_compra").val('');
            $("#subtotal").val('');
        }
    }
}

function buscarproducto2(codigo) {
  $.ajax({
      url: base_url+'/productos/buscarPorCodigo/'+codigo, dataType:'json',
      success: function(resultado){
          if (resultado == 0) {
              $(tagCodigo).val('');
          }
          else{
              if (resultado.existe) {
                  $("#resultado_error").html('');
                  $("#id_producto").val(resultado.datos.id);
                  $("#codigo").val(resultado.datos.codigo);
                  $("#nombre").val(resultado.datos.nombre);
                  $("#cantidad").val(1);
                  $("#precio_compra").val(resultado.datos.precio_compra);
                  $("#subtotal").val(resultado.datos.precio_compra);
                  $("#cantidad").focus();
                  document.getElementById('cantidad').disabled=false;
              }else{
                $("#resultado_error").html(resultado.error);
              }
              $('#lista').modal('hide');
          }
      }
  });
}

function Calcula_cantidad_subtotal(e,tagCodigo,codigo, cantidad) {
    if (codigo != '' && cantidad>0 ) {
        if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode==8)) {
            $.ajax({
                url: base_url+'/productos/calcular_c_subtotal/' + codigo, dataType: 'json',
                success: function(resultado) {
                    if (resultado == 0) {
                        $(tagCodigo).val('');
                    } else {
                        $("#resultado_error").html(resultado.error);
                        if (resultado.existe) {
                           $("#subtotal").val((resultado.datos.precio_compra * cantidad).toFixed(2));
                        }
                    }
                }
            });
        }
    }
}

function Calcula_cantidad_subtotal2(codigo,cantidad){
    if (codigo != '') {     
        if (cantidad > 0 && cantidad!='') {
            $.ajax({
                url: base_url +'/productos/calcular_c_subtotal/' + codigo, dataType: 'json',
                success: function(resultado){
                    if (resultado == 0){
                        $(tagCodigo).val('');
                    } else {
                        $("#resultado_error").html(resultado.error);
                        if (resultado.existe) {
                        $("#subtotal").val((resultado.datos.precio_compra * cantidad).toFixed(2));
                        }
                    }
                }
            });
        }
    }
}



function agregarProductoxxx(id_producto,codigo,cantidad,id_compra) { 
  if(codigo !=''){
    if (id_producto != null && id_producto != 0) {
      if(cantidad > 0 && cantidad!=''){
        $.ajax({
            url: base_url + "/TemporalCompra/insertar/"+ id_producto + "/"+ cantidad + "/"+id_compra + "/"+1,
            type: "POST",
            success: function(resultado){
                if (resultado == 0) {
                }
                else{
                    var resultado= JSON.parse(resultado);
                    if (resultado.error == '') {
                        $("#tablaProductos tbody").empty();
                        $("#tablaProductos tbody").append(resultado.datos);
                        $("#total").val(resultado.total);
                        $("#codigo").val('');
                        $("#id_producto").val('');
                        $("#capacidad").val('');
                        $("#nombre").val('');
                        $("#cantidad").val('');
                        $("#precio_compra").val('');
                        $("#subtotal").val(''); 
                        document.getElementById('cantidad').disabled=true;
                    }
                }
            }
        });
      } else {Toast.fire({icon: 'error',title: 'Digite una cantidad.'})}
    }else { $('#avisoModal').modal('show');}
  }
  else {
    Swal.fire({
    icon: 'info',
    title: 'Aviso',
    text: 'Introduzca el código de un producto y presione enter.',
    })
  }
}
//ESTA FUNICION FUNCIONA PARA AMBAS PARTES (CAJA Y NUEVA COMPRA)
function eliminaProductoxx(id_producto, id_de_compraYventa) { 
    $.ajax({
        url: base_url+'/TemporalCompra/eliminar/'+ id_producto +"/"+ id_de_compraYventa,
        success: function(resultado){
            if (resultado == 0) {
                $(tagCodigo).val('');
            }
            else{
                var resultado= JSON.parse(resultado);
                $("#tablaProductos tbody").empty();
                $("#tablaProductos tbody").append(resultado.datos);
                $("#total").val(resultado.total);
            }
        }
    });
}


/*========================= Java ecript para las venta ===========================*/

  $("#cliente").autocomplete({
      source: base_url + '/clientes/autocompleteData', minLength:3,
      select: function(event, ui){
          event.preventDefault();
          $("#id_cliente").val(ui.item.id);
          $("#cliente").val(ui.item.value);
      }
  });


$(function(){
  $("#nombrepv").autocomplete({
      source: base_url + '/productos/autocompleteData',
      minLength:3,
      select: function(event, ui){
          event.preventDefault();
          $("#nombrepv").val(ui.item.value);
          setTimeout(
              function (){
                if(ui.item.existencias>0) {
                  e = jQuery.Event("keypress");
                  e.which=13;
                  agregarProductocaja(e,ui.item.id,1,idVentaTmp);
                }else{
                  Toast.fire({
                    icon: 'error',
                    title: 'Producto agotado.'
                    })
                    $("#nombrepv").val('');
                }
              }
          );
      }
  });
});


function agregarProductocaja(e,id_producto,cantidad,id_venta) {
  let enterKey = 13;
      if (nombrepv != '') {
          if (e.which == enterKey) {
              if (id_producto != null && id_producto != 0 && cantidad>0) {
                  $.ajax({
                      url: base_url + "/TemporalCompra/insertar/"+ id_producto + "/"+ cantidad + "/"+id_venta,
                      success: function(resultado){
                          if (resultado == 0) {
                          }
                          else{
                              var resultado= JSON.parse(resultado);
                              if (resultado.error == '') {
                                  $("#tablaProductos tbody").empty();
                                  $("#tablaProductos tbody").append(resultado.datos);
                                  $("#total").val(resultado.total);
                                  $("#id_producto").val('');                                    
                                  $("#nombrepv").val('');
                                  $("#cantidad").val('');
                                  $("#precio_venta").val('');
                                  $("#subtotal").val('');
                              }else{
                                Toast.fire({
                                  icon: 'warning',
                                  title: resultado.error
                                  })
                                  $("#nombrepv").val('');
                              }
                          }
                      }
                  });
              }
          }
      }
  }

  function agregarPV(id_producto,existencias) {
    if(existencias> 0){
    e = jQuery.Event("keypress");
    e.which=13;
    agregarProductocaja(e,id_producto,1,idVentaTmp);
    }
    else{
      Toast.fire({
      icon: 'error',
      title: 'Producto agotado.'
      })
    }
  }

  $(function(){
    $("#completa_venta").click(function (){
        let nFilas = $("#tablaProductos tr").length;
        if(nFilas < 2) {
            Toast.fire({
              icon: 'error',
              title: 'Agregue los productos que desea vender.'
            })
        }else{
            $("#form_venta").submit();
            Toast.fire({
                title: "Venta Realizada satisfactoriamente",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
});