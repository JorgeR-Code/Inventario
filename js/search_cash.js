
$(document).ready(function(){
    var busqueda = $('#busqueda');
    var titulo = $('table tbody tr td a');

    $(titulo).each(function(){
        var li = $(this);
        
        //si presionamos la tecla
        $(busqueda).keyup(function(){
        //cambiamos a minusculas
        this.value = this.value.toLowerCase();
        //
        var clase = $('.search svg');
        if($(busqueda).val() != ''){
        $(clase).attr('class', 'fas fa-times');
        $(".content-search").show();
        }else{
        $(clase).attr('class', 'fas fa-search');
        $(".content-search").hide();

        }
        if($(clase).hasClass('fas fa-times')){
        $(clase).click(function(){
        //borramos el contenido del input
        $(busqueda).val('');
        //mostramos todas las listas
        $(li).parent().show();
        //volvemos a añadir la clase para mostrar la lupa
        $(clase).attr('class', 'fas fa-search');
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
        $(function() 
                {
                $('#table').keyup(function(e) {
                    if(e.keyCode==37)//38 para arriba
                    mover(e,-1);
                    if(e.keyCode==39)//40 para abajo
                    mover(e,1);
                });
                });


                function mover(event, to) {
                let list = $('a');
                let index = list.index($(event.target));
                index = (index + to) % list.length;
                list.eq(index).focus();
                }
        
       
        
        }
        });
        $(li).click(function(){
            var resultado = $(li).parent();
            var resultado2 = resultado.text();
            $('#busqueda').val(resultado2);
            $(li).parent().hide();
            $("#enterProduct").trigger("click");

        })
        

        });    
       
       
});
   
    