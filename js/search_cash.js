const formulario = document.getElementById('form1');
const inputs = document.querySelectorAll('#form1 input')

const formulario2 = document.getElementById('form2');
const inputs2 = document.querySelectorAll('#form2 input')

const expresiones = {
    //	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
        nombre: /^[a-zA-ZÀ-ÿ\s]{1,20}$/, // Letras y espacios, pueden llevar acentos.
        cantidad: /^\d{1,2}$/, // 7 a 14 numeros.
        barras: /^\d{10}$/ // 7 a 14 numeros.
    
    }
    const campos = {
        nombre:false,
        cantidad:false,
        barras:false
    };




    
const validarFormulario = (e) => {
    var countryTags = [];//variable de tipo arreglo para almacenar los valores


    jQuery(document).ready(function ($) {

        titulo = $('table tbody tr td a'); //seleccionamos de sonde se tomarán los datos
        
    
    
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
            if(expresiones.barras.test(e.target.value)){

                showElements("barras")
                $('#enterProduct').show();
                    
            } else {
                hideElements("barras")
                $('#enterProduct').hide();
        
            }

        break;
        case 'cantidad':

            if(expresiones.cantidad.test(e.target.value)){
                showElements("cantidad")
                $('#RegisterSale').show();
                        
            } else {
                hideElements("cantidad")
                $('#RegisterSale').hide();
                        
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

///----------Eventos para los campos del formulario-------/////


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
    $('#RegisterSale').hide();
    
    $("#RegisterSale").click(function(e){ 
    
        e.preventDefault();
     
        if(campos.cantidad){
            $("#RegisterSale").unbind('click').click();
            $('#RegisterSale').hide();

        }else{
            
            document.getElementById('formulario__mensaje2').classList.add('formulario__mensaje-activo');
            setTimeout(() => {
    
                document.getElementById('formulario__mensaje2').classList.remove('formulario__mensaje-activo');
            
            }, 3000);
            }
     
     });

     });