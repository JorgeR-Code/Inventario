//---El formulario se llama "Form1" para "Registrar" y para "Editar"-----///
const formulario = document.getElementById('form1');
const inputs = document.querySelectorAll('#form1 input')
const selects = document.querySelectorAll('#form1 select')
const idu = document.getElementById('inputIdu');

const expresiones = {
//	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,20}$/, // Letras y espacios, pueden llevar acentos.
    apellido: /^[a-zA-ZÀ-ÿ\s]{1,20}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,15}$/, // 4 a 12 digitos.
//	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    acceso: /^\d{1}$/, // 7 a 14 numeros.
	telefono: /^\d{10}$/, // 7 a 14 numeros.
    categoria: /^[a-zA-ZÀ-ÿ\s]{1,20}$/,// Letras y espacios, pueden llevar acentos.
    cantidad: /^\d{1,3}$/, // 7 a 14 numeros.
    barras: /^\d{10}$/ // 7 a 14 numeros.

}
//----Campos para formulario "Registrar"----///
const campos = {
    nombre:false,
    apellido:false,
    telefono:false,
    acceso:false,
    inputPassword:false,
    confirmContraseña: false,

    categoria:false,
    cantidad: false,
    barras:false,
};
///-----Campos para fomulario "Editar"-------////
const camposE = {
    nombre:true,
    apellido:true,
    telefono:true,
    acceso:true,
    inputPassword:true,
    confirmContraseña: true,

    categoria:true,
    cantidad: true,
    barras:true,

};
///---------Funcion para validar cada campo-----////

const validarFormulario = (e) => {

    switch (e.target.name) {

        case 'nombre':

            validarCampo(expresiones.nombre, e.target, 'nombre');

        break;
        case 'apellido':

            validarCampo(expresiones.apellido, e.target, 'apellido');

        break;
        case 'telefono':

            validarCampo(expresiones.telefono, e.target, 'telefono');
        break;
        case 'acceso':

            validarCampo(expresiones.acceso, e.target, 'acceso');

        break;
            
        
        case 'password':

            validarCampo(expresiones.password, e.target, 'contraseña');
            passwordConfirmFunction();
        break;
        case 'passwordConfirm':

            validarCampo(expresiones.password, e.target, 'confirmContraseña');
            passwordConfirmFunction();

        break;
        case 'categoria':

            validarCampo(expresiones.categoria, e.target, 'categoria');

        break;
        case 'cantidad':

            validarCampo(expresiones.cantidad, e.target, 'cantidad');

        break;
        case 'codigo_barras':

            validarCampo(expresiones.barras, e.target, 'barras');

        break;
    }

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
        camposE[campo] = true;

    } else {
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
        document.querySelector(`#grupo__${campo} svg`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo__${campo} svg`).classList.add('fa-times-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo')
        campos[campo] = false;
        camposE[campo] = false;


    }
}

////------Funcion para validar contraseñas en "Registrar"--------/////////
const passwordConfirmFunction = () =>
{
    const inputPassword1 = document.getElementById('inputPassword');
    const inputPassword2 = document.getElementById('inputPasswordConfirm');

    if(inputPassword1.value == inputPassword2.value && campos.confirmContraseña){
        document.getElementById(`grupo__confirmContraseña`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo__confirmContraseña`).classList.add('formulario__grupo-correcto');
        document.querySelector(`#grupo__confirmContraseña svg`).classList.remove('fa-times-circle');
        document.querySelector(`#grupo__confirmContraseña svg`).classList.add('fa-check-circle');
        document.querySelector(`#grupo__confirmContraseña .formulario__input-error`).classList.remove('formulario__input-error-activo')
        campos['inputPassword'] = true;
        

    }else{
        document.getElementById(`grupo__confirmContraseña`).classList.remove('formulario__grupo-correcto');
        document.getElementById(`grupo__confirmContraseña`).classList.add('formulario__grupo-incorrecto');
        document.querySelector(`#grupo__confirmContraseña svg`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo__confirmContraseña svg`).classList.add('fa-times-circle');
        document.querySelector(`#grupo__confirmContraseña .formulario__input-error`).classList.add('formulario__input-error-activo')
        campos['inputPassword'] = false;

    };
}


///----------Eventos para los campos del formulario-------/////
inputs.forEach((input) => {

    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});
selects.forEach((select) => {

    select.addEventListener('blur', validarFormulario);

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

 $("#agregarPro").click(function(e){ 

    e.preventDefault();
 
    if(campos.categoria && campos.nombre && campos.cantidad && campos.barras){
        $("#agregarPro").unbind('click').click();

    }else{
        
        document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
        setTimeout(() => {

            document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo');
        
        }, 3000);
        }
 
 });
 ///------------------boton submit para "Editar"-----------------////////////
 console.log(idu.value);

 $("#actualizar").click(function(e){ 

    e.preventDefault();
    if(camposE.nombre && camposE.apellido && camposE.telefono && camposE.acceso && idu.value != ''){

        $("#actualizar").unbind('click').click();

    }else{
        
        document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
        setTimeout(() => {
        document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo');
        
        }, 3000);
    }
 
 });

 $("#actualizarPro").click(function(e){ 

    e.preventDefault();
 
    if(camposE.categoria && camposE.nombre && camposE.cantidad && camposE.barras && idu.value != ''){

        $("#actualizarPro").unbind('click').click();

    }else{
        
        document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
        setTimeout(() => {
        document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo');
        
        }, 3000);
    }
 
 });
});