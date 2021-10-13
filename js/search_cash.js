const formulario = document.getElementById('form1');
const inputs = document.querySelectorAll('#form1 input')

const formulario2 = document.getElementById('form2');
const inputs2 = document.querySelectorAll('#form2 input')
const stock = document.getElementById('inputStock')

const expresiones = {
    //	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
        nombre: /^[a-zA-ZÀ-ÿ\s]{1,20}$/, // Letras y espacios, pueden llevar acentos.
        cantidad: /^([1-9]|[1-9]\d{1,2})/, // 7 a 14 numeros.
        barras: /^\d{10}$/ // 7 a 14 numeros.
    
    }
    const campos = {
        nombre:false,
        cantidad:false,
        barras:false
    };




    
const validarFormulario = (e) => {
    var countryTags1 = [];//variable de tipo arreglo para almacenar los valores
    var countryTags = [];//variable de tipo arreglo para almacenar los valores


    jQuery(document).ready(function ($) {

        titulo = $('#table2 tbody tr td .nombre'); //seleccionamos de donde se tomarán los datos para la entrada nombre

        $(titulo).each(function(){//por cada valor se ejecuta la siguiente funcion
            var li = $(this);
            var texto = $(li).text(); //se obtiene solo el texto de la etiqueta "a"
      
           countryTags.push(texto);//se inserta el valor actual al arreglo
           
            });

            
    
        
        $("#busqueda").autocomplete({//la siguiente funcion es tomada de la libreria para ejecutar el autocompletar
            source: countryTags//los valores para autocompletar son los almacenados el el array anterior
        });
    

        $("#ui-id-1").click(function(){
            $("#busqueda").blur();
         });
       
    });
    jQuery(document).ready(function ($) {

        barrasz = $('#table2 tbody tr td .barras'); //seleccionamos de donde se tomarán los datos para la entrada codigo de barras


        $(barrasz).each(function(){//por cada valor se ejecuta la siguiente funcion
            var li1 = $(this);
            var texto1 = $(li1).text(); //se obtiene solo el texto de la etiqueta "a"

           countryTags1.push(texto1);//se inserta el valor actual al arreglo
           
            });    

        $("#inputBarCode").autocomplete({//la siguiente funcion es tomada de la libreria para ejecutar el autocompletar
            source: countryTags1//los valores para autocompletar son los almacenados el el array anterior
        });
       
    
        $("#ui-id-2").click(function(){
            $("#inputBarCode").blur();
        });
    });


    
    switch (e.target.name) {

        case 'nombre':
                for (var i = 0; i < countryTags.length; i++) {
                   
                  if (e.target.value == countryTags[i]) {

                    showElements("nombre")
                    $('#enterProduct').show();
                    break;

                  }else{


                    hideElements("nombre")
                    $('#enterProduct').hide();

                  }

        }

        break;
        
        case 'codigo_barras':
            for (var i = 0; i < countryTags1.length; i++) {

            if(e.target.value == countryTags1[i]){

                showElements("barras")
                $('#enterProduct').show();
                break;

                    
            } else {
                hideElements("barras")
                $('#enterProduct').hide();
        
            }
        }
        break;
        case 'cantidad':
            stocknum =Number(stock.value);
            cantidadNum = Number(e.target.value);

            if(cantidadNum >= 1 && cantidadNum <= stocknum){
                showElements("cantidad")
                $('#registerSale').show();
                        
            } else {
                hideElements("cantidad")
                $('#registerSale').hide();
                        
            }

        break;
    }

}

///----Funcion para validar campos de "Registrar" y "Editar"----------//////////

function showElements (campo){
    document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
    document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
    document.querySelector(`#grupo__${campo} svg`).classList.remove('fa-times-circle');
    document.querySelector(`#grupo__${campo} svg`).classList.add('fa-check-circle');
    document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
    campos[campo] = true;
    
};

function hideElements (campo){
    document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
    document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
    document.querySelector(`#grupo__${campo} svg`).classList.remove('fa-check-circle');
    document.querySelector(`#grupo__${campo} svg`).classList.add('fa-times-circle');
    document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
    campos[campo] = false;
};

///----------Se inhabilita uno de los dos inputs dependiendo el que este activo-------/////


$("#grupo__barras").click(function(){
    $("#inputBarCode").prop('disabled', false);
    $("#inputBarCode").focus();

    document.getElementById(`grupo__nombre`).classList.remove('formulario__grupo-incorrecto');
    document.getElementById(`grupo__nombre`).classList.remove('formulario__grupo-correcto');
    document.querySelector(`#grupo__nombre svg`).classList.remove('fa-times-circle');
    document.querySelector(`#grupo__nombre svg`).classList.remove('fa-check-circle');
    document.querySelector(`#grupo__nombre .formulario__input-error`).classList.remove('formulario__input-error-activo');
    $('#busqueda').val('');

    $("#busqueda").prop('disabled', true);
   
 });

 $("#grupo__nombre").click(function(){
    $("#busqueda").prop('disabled', false);
    $("#busqueda").focus();
     document.getElementById(`grupo__barras`).classList.remove('formulario__grupo-incorrecto');
    document.getElementById(`grupo__barras`).classList.remove('formulario__grupo-correcto');
    document.querySelector(`#grupo__barras svg`).classList.remove('fa-times-circle');
    document.querySelector(`#grupo__barras svg`).classList.remove('fa-check-circle');
    document.querySelector(`#grupo__barras .formulario__input-error`).classList.remove('formulario__input-error-activo');
    $('#inputBarCode').val('');
    $("#inputBarCode").prop('disabled', true);
    
    
 });
 
 $(".disable").click(function(){
    $(".disable").prop('disabled', true);
    $('#registerSale').hide();
    $('#enterProduct').hide();


 });
 ///----------Eventos para los campos del formulario-------/////
inputs.forEach((input) => {

    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});
inputs2.forEach((input) => {

    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});
/////------Boton submit para "Agregar"------////////////
window.addEventListener("load",function(){
    $('#enterProduct').hide();
    
    $("#enterProduct").click(function(e){ 
    
        e.preventDefault();
     
        if(campos.nombre || campos.barras){
            $("#enterProduct").unbind('click').click();
            $('#enterProduct').hide();

        }else{
            
            document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
            setTimeout(() => {
    
                document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo');
            
            }, 3000);
            }
     
     });

     });

///----------------------------Boton submit para "Registrar venta"-----------------------------------------

window.addEventListener("load",function(){
    $('#registerSale').hide();
    
    $("#registerSale").click(function(e){ 
    
        e.preventDefault();
     
        if(campos.cantidad){
            $("#registerSale").unbind('click').click();
            $('#registerSale').hide();

        }else{
            
            document.getElementById('formulario__mensaje2').classList.add('formulario__mensaje-activo');
            setTimeout(() => {
    
                document.getElementById('formulario__mensaje2').classList.remove('formulario__mensaje-activo');
            
            }, 3000);
            }
     
     });

     });