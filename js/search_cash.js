
// (function(){

//     var buscador = $('#table').DateTable();

//     $("#inputSearch").keyup(function(){
    
//         buscador.search($(this).val()).draw();
    
//         if($("#inputSearch").val() == ""){
//             $(".content-search").fadeOut(300);
//         }else{
//             $(".content-search").fadeIn(300);
//         }
//     })

// });

$(document).ready(function(){
    var busqueda = $('#busqueda'),
    titulo = $('table tbody tr td a');

    $(titulo).each(function(){
        var li = $(this);
        //si presionamos la tecla
        $(busqueda).keyup(function(){
        //cambiamos a minusculas
        this.value = this.value.toLowerCase();
        //
        var clase = $('.search svg');
        if($(busqueda).val() != ''){
        $(clase).attr('class', 'fa fa-times');
        }else{
        $(clase).attr('class', 'fa fa-search');
        }
        if($(clase).hasClass('fa fa-times')){
        $(clase).click(function(){
        //borramos el contenido del input
        $(busqueda).val('');
        //mostramos todas las listas
        $(li).parent().show();
        //volvemos a añadir la clase para mostrar la lupa
        $(clase).attr('class', 'fa fa-search');
        });
        }
        //ocultamos toda la lista
        $(li).parent().hide();
        //valor del h3
        var txt = $(this).val();
        //si hay coincidencias en la búsqueda cambiando a minusculas
        if($(li).text().toLowerCase().indexOf(txt) > -1){
        //mostramos las listas que coincidan
        $(li).parent().show();
        }
        });
        });    


});
   

    