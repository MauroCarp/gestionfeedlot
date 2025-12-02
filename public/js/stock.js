
  function cambiar(id,info){
    let pdrs = document.getElementById(id).files[0].name;
    document.getElementById(info).innerHTML = pdrs;
  }

  // funciones legacy de carga/paginación eliminadas tras migración a DataTables

    
setTimeout(() => {
  
  let btnsDescargaPlanilla = document.getElementsByClassName('descargarPlanillas')

  for (const btn of btnsDescargaPlanilla) {
      
    btn.addEventListener('click',()=>{

      let seccion = btn.attributes.seccion.value  
      
      let btnDescargar = document.getElementById('descargarPlanillaManual')

      let feedlot = btn.attributes['data-feedlot'].value.replace(' ','')

      btnDescargar.href = `planillas/${seccion}${feedlot}.csv`
  
      btnDescargar.download = `Planilla ${seccion}.csv`
    
    })

  }


  const checkCargaManual = document.getElementById('cargaManualIngresos')
  checkCargaManual.addEventListener('click',()=>{
  
    if(checkCargaManual.checked){

      document.getElementById('divInputCargaManual').style.display = 'block'
      
    }else{
      
      document.getElementById('divInputCargaManual').style.display = 'none'

    }
  
  })

  let selectRazaIng = document.getElementById('razaIngreso')

  selectRazaIng.addEventListener('change',()=>{

    if(selectRazaIng.value == 'otraRaza'){
      document.getElementById('otraRaza').style.display = 'block'  
    }else{
      document.getElementById('otraRaza').style.display = 'none'  
    }

  })

  let selectOrigenIng = document.getElementById('origenIngreso')

  selectOrigenIng.addEventListener('change',()=>{

    if(selectOrigenIng.value == 'otroOrigenIngresos'){
      document.getElementById('otroOrigenIngresos').style.display = 'block'  
    }else{
      document.getElementById('otroOrigenIngresos').style.display = 'none'  
    }

  })

  let selectDestinoIng = document.getElementById('destinoIngreso')

  selectDestinoIng.addEventListener('change',()=>{
    console.log('ohla')
    if(selectDestinoIng.value == 'otroDestinoIngresos'){
      document.getElementById('otroDestinoIngresos').style.display = 'block'  
    }else{
      document.getElementById('otroDestinoIngresos').style.display = 'none'  
    }

  })

  selectOrigenIng.addEventListener('click',()=>{

    if(selectOrigenIng.value == 'otroOrigenIngresos'){
      document.getElementById('otroOrigenIngresos').style.display = 'block'  
    }else{
      document.getElementById('otroOrigenIngresos').style.display = 'none'  
    }

  })

  selectDestinoIng.addEventListener('click',()=>{

    if(selectDestinoIng.value == 'otroDestinoIngresos'){
      document.getElementById('otroDestinoIngresos').style.display = 'block'  
    }else{
      document.getElementById('otroDestinoIngresos').style.display = 'none'  
    }

  })
  
}, 500);
  