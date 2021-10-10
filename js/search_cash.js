jQuery(document).ready(function ($) {

    titulo = $('table tbody tr td a'); //seleccionamos de sonde se tomarán los datos
    var countryTags = [];//variable de tipo arreglo para almacenar los valores


    $(titulo).each(function(){//por cada valor se ejecuta la siguiente funcion
        var li = $(this);
        var texto = $(li).text(); //se obtiene solo el texto de la etiqueta "a"
  
       countryTags.push(texto);//se inserta el valor actual al arreglo
       
        });

        console.log(countryTags);

    $("#busqueda").autocomplete({//la siguiente funcion es tomada de la libreria para ejecutar el autocompletar
        source: countryTags//los valores para autocompletar son los almacenados el el array anterior
    });



});