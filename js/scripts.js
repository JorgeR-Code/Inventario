/*!
    * Start Bootstrap - SB Admin v7.0.3 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2021 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


////-----------------------SELECT PERIOD on sales records----------------////////////////////


$(function() {
    $('#inputcathegory').change(function(e) {
        if ($(this).val() === "p_personalizado") {
            $('#startDate').show();
            $('#endDate').show();
            $('#startDateL').show();
            $('#endDateL').show();
            
        } else {
            $('#startDate').hide();
            $('#endDate').hide();
            $('#startDateL').hide();
            $('#endDateL').hide();
            
        }
    })
    $('#startDate').hide();
    $('#endDate').hide();
    $('#startDateL').hide();
    $('#endDateL').hide();
    
    
});


////------------Generate PDF---------------/////////////
function DescargarPDF(ContenidoID,nombre) {
	
    var pdf = new jsPDF('l', 'pt', 'letter');
    var text = "Reporte de ventas";
	pdf.text(300, 50, text);
    pdf.setFont("Helvetica");
    pdf.setFontSize(80);
    
    
    html = $('#'+ContenidoID).html();
	
    specialElementHandlers = {};
	
    margins = {
        top: 80,
        left: 40,
        width: 900
    };
	
    pdf.fromHTML(
        html, 
        margins.left, 
        margins.top,
       
        {'width': 
         margins.width
        },
        function (dispose) {
        pdf.save(nombre+'.pdf');
        }, 
        margins
    );
	
}

window.addEventListener("load",function(){
    var content = document.getElementById('divPDF2');

    document.getElementById("nameCreatePdf").onclick = function(){

        DescargarPDF(content.id,'Reporte')
    };
});



