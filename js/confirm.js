function confirmation(ev) {
  ev.preventDefault();
  var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
  console.log(urlToRedirect); // verify if this is the right URL

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton:'btn btn-danger',
      cancelButton:  'btn btn-success'
    },
    buttonsStyling: true
  })
  
  swalWithBootstrapButtons.fire({
    title: '¿Estás seguro que deseas eliminar este registro?',
    text: "No podrás revertir esta acción!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, Eliminar!',
    cancelButtonText: 'No, cancelar!',
    confirmButtonColor: '#F5002D',
    cancelButtonColor: '#5D23EB',
    reverseButtons: false
  }).then((result) => {
    if (result.isConfirmed) {

      
        swalWithBootstrapButtons.fire(
          'Eliminado!',
          'Tu registro ha sido eliminado.'
          
        ).then((result) =>{
          if (result.isConfirmed){
            window.location.href= urlToRedirect
          }
        })
     
      
    } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
    ) {
      ev.preventDefault();
     
    }
  })
  
  }
 




