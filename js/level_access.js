const acceso = document.getElementById('nivelAcc');

console.log(acceso.value);

window.addEventListener("DOMContentLoaded",function(){

$(function() {
   switch(acceso.value){

       case '0':

       break;
       case '1':

       break;
       case '2':

       break;
       case '3':
        $('#headerUsuarios').hide();
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