
setTimeout(() => {
    
    let selectFeedlot = document.getElementById('feedlotUsuario')
    
    selectFeedlot.addEventListener('change',()=>{
    
        let value = document.getElementById('feedlotUsuario').value
    
        if(value == 'nuevoFeedlot'){
            document.getElementById('nuevoFeedlot').classList.add('show')
            document.getElementById('nuevoFeedlot').classList.remove('hidden')
        
        }else{

            document.getElementById('nuevoFeedlot').classList.remove('show')
            document.getElementById('nuevoFeedlot').classList.add('hidden')
        
        }
    
    })


    
}, 500);

$('.tablaUsuarios').on('click','.btnEliminarUsuario',function(){

    let id = $(this).attr('idUsuario')

    window.location = `index.php?route=usuarios&accion=eliminarUsuario&id=${id}`
})