window.onload = function(){

    var buscador = $("#table").dateTable();

    $("#inputSearch").keyup(function(){
    
        buscador.search($(this).val()).draw();
    
        if($("#inputSearch").val() == ""){
            $(".content-search").fadeOut(300);
        }else{
            $(".content-search").fadeIn(300);
        }
    })
};
