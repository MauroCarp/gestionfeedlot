function cargarSelectTipoInsumo(){

    var url = '/gestionfeedlot/ajax/tipoInsumos.ajax.php';

    $.ajax({

        url:url,

        success:function(respuesta){

            $('.selectTipoInsumo').append(respuesta);

        }

    });
}


function zIndexModalNuevoInsumo(){

    $('#modal-agregarInsumo').css('z-index','999');
}


$('.selectTipoInsumo').change(function(){

    var value = $(this).val();

    if(value == 'otroTipo'){

        $('.campoOtro').css('display','block');
        console.log('gas');
    }else{
        
        $('.campoOtro').css('display','none');

    }

});

// SELECT TIPO INSUMOS

$(document).ready(function() {

    cargarSelectTipoInsumo();

});

setTimeout(() => {
    
    let btnsEditarInsumo = document.querySelectorAll('.btnModificarInsumo')

    btnsEditarInsumo.forEach(btn => {

        btn.addEventListener('click',()=>{

            let id = btn.getAttribute('data-id')

            let url = '/gestionfeedlot/ajax/insumos.ajax.php'

            let form = document.querySelector('#formModificarInsumo')

            form.reset()

            form.setAttribute('action',`raciones.php?accion=modificarInsumo&id=${id}`)

            let data = `id=${id}&accion=editarInsumo`

            $.ajax({
                method:'post',
                url,
                data,
                success:(resp)=>{
                    
                    let data = JSON.parse(resp)

                    document.getElementById('modal-modificarInsumo').style.zIndex = 99

                    document.querySelector('#formModificarInsumo input[name="nombre"]').value = data.insumo
                    document.querySelector('#formModificarInsumo input[name="precio"]').value = data.precio
                    document.querySelector('#formModificarInsumo input[name="proteina"]').value = data.Pr
                    document.querySelector('#formModificarInsumo input[name="porMS"]').value = data.porceMS
                    document.getElementById('selectTipoInsumo').value = data.tipo

                }
            })
        })

    });

}, 1000);