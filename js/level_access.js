const acceso = document.getElementById('nivelAcc');

console.log(acceso.value);

window.addEventListener("DOMContentLoaded",function(){

$(function() {
   switch(acceso.value){

       case '0':

       break;
       case '1':
        $('#headerUsuarios').hide();
        $('#registrarUsuario').hide();
        $('#listarUsuarios').hide();
        $('#headerVentas').hide();
        $('#cajaRegistradora').hide();
        $('#registarVentas').hide();
       break;
       case '2':
        $('#headerUsuarios').hide();
        $('#registrarUsuario').hide();
        $('#listarUsuarios').hide();
       break;
       case '3':
        $('#headerUsuarios').hide();
        $('#registrarUsuario').hide();
        $('#listarUsuarios').hide();
        $('#listarProductos').hide();
        $('#registarVentas').hide();


       break; 
   }
});
});


function mostrarElementos(){
    // $('#startDate').show();
};

function ocultarElementos(){
    // $('#endDateL').hide();
};