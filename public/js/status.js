let selectProcedimiento = document.getElementById('statusProcedimiento')

selectProcedimiento.addEventListener('change',(e)=>{

    let value = e.target.value

    if(value != 'otroTratamiento'){

        document.getElementById('otroTratamiento').setAttribute('readOnly','readOnly')
        
    }else{
        
        document.getElementById('otroTratamiento').removeAttribute('readOnly')
  
    }
})