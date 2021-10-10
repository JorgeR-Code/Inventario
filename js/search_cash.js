const formulario = document.getElementById('form1');
const inputs = document.querySelectorAll('#form1 input')

const expresiones = {
    //	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
        nombre: /^[a-zA-ZÀ-ÿ\s]{1,20}$/, // Letras y espacios, pueden llevar acentos.
        
        barras: /^\d{10}$/ // 7 a 14 numeros.
    
    }
    const campos = {
        nombre:false,
       
        barras:false,
    };




    
const validarFormulario = (e) => {

    switch (e.target.name) {

        case 'nombre':
            function valores (countryTags){

                for (var i = 0; i < countryTags.length; i++) {
                
                  if (e.target.value == countryTags[i] && expresiones.nombre.test(e.target.value)) {
                    document.getElementById(`grupo__nombre`).classList.remove('formulario__grupo-incorrecto');
                    document.getElementById(`grupo__nombre`).classList.add('formulario__grupo-correcto');
                    document.querySelector(`#grupo__nombre svg`).classList.remove('fa-times-circle');
                    document.querySelector(`#grupo__nombre svg`).classList.add('fa-check-circle');
                    document.querySelector(`#grupo__nombre .formulario__input-error`).classList.remove('formulario__input-error-activo')
                    campos['nombre'] = true;
                  }else{
                    document.getElementById(`grupo__nombre`).classList.remove('formulario__grupo-correcto');
                    document.getElementById(`grupo__nombre`).classList.add('formulario__grupo-incorrecto');
                    document.querySelector(`#grupo__nombre svg`).classList.remove('fa-check-circle');
                    document.querySelector(`#grupo__nombre svg`).classList.add('fa-times-circle');
                    document.querySelector(`#grupo__nombre .formulario__input-error`).classList.add('formulario__input-error-activo')
                    campos['nombre'] = false;
                  }

               
            }
        }
            
            
        break;
        
        case 'codigo_barras':

            validarCampo(expresiones.barras, e.target, 'barras');

        break;
    }
    jQuery(document).ready(function ($) {

        titulo = $('table tbody tr td a'); //seleccionamos de sonde se tomarán los datos
        var countryTags = [];//variable de tipo arreglo para almacenar los valores
    
    
        $(titulo).each(function(){//por cada valor se ejecuta la siguiente funcion
            var li = $(this);
            var texto = $(li).text(); //se obtiene solo el texto de la etiqueta "a"
      
           countryTags.push(texto);//se inserta el valor actual al arreglo
           
            });
    
        $("#busqueda").autocomplete({//la siguiente funcion es tomada de la libreria para ejecutar el autocompletar
            source: countryTags//los valores para autocompletar son los almacenados el el array anterior
        });
    
        valores (countryTags);
    });
}

///----Funcion para validar campos de "Registrar" y "Editar"----------//////////
const validarCampo = (expresion, input, campo) => {
    if(expresion.test(input.value)){
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} svg`).classList.remove('fa-times-circle');
        document.querySelector(`#grupo__${campo} svg`).classList.add('fa-check-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo')
        campos[campo] = true;

    } else {
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
        document.querySelector(`#grupo__${campo} svg`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo__${campo} svg`).classList.add('fa-times-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo')
        campos[campo] = false;


    }
}
///----------Eventos para los campos del formulario-------/////
inputs.forEach((input) => {

    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});

/////------Boton submit para "Registrar"------////////////
window.addEventListener("load",function(){
    $("#agregarId").click(function(e){ 
    
        e.preventDefault();
     
        if(campos.nombre && campos.apellido && campos.telefono && campos.acceso && campos.inputPassword){
            $("#agregarId").unbind('click').click();
    
        }else{
            
            document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
            setTimeout(() => {
    
                document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo');
            
            }, 3000);
            }
     
     });

     });

///---------------------------------------------------------------------

