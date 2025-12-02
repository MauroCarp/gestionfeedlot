setTimeout(() => {
    
    document.getElementById('modal-estadisticas').style.zIndex = '-10'
    
    let btnsEstadisticas = document.querySelectorAll('.menuEst')
    
    btnsEstadisticas.forEach(btn => {
       
        let seccion = btn.attributes.seccion.value
        
        let titleModalEstadistica = document.getElementById('titleModalEstadistica')
        
        let inputRaza = document.getElementById('inputRaza')
        let inputGMD = document.getElementById('inputGMD')
        let inputGPV = document.getElementById('inputGPV')
        let inputDestino = document.getElementById('inputDestino')
        let inputCausaMuerte = document.getElementById('inputCausaMuerte')

        let inputRazaComparar = document.getElementById('inputRazaComparar')
        let inputGMDComparar = document.getElementById('inputGMDComparar')
        let inputGPVComparar = document.getElementById('inputGPVComparar')
        let inputDestinoComparar = document.getElementById('inputDestinoComparar')
        let inputCausaMuerteComparar = document.getElementById('inputCausaMuerteComparar')

        
        btn.addEventListener('click',()=>{
   
            inputRaza.classList.add('hidden')
            inputGMD.classList.add('hidden')
            inputGPV.classList.add('hidden')
            inputDestino.classList.add('hidden')
            inputCausaMuerte.classList.add('hidden')

            inputRazaComparar.classList.add('hidden')
            inputGMDComparar.classList.add('hidden')
            inputGPVComparar.classList.add('hidden')
            inputDestinoComparar.classList.add('hidden')
            inputCausaMuerteComparar.classList.add('hidden')
    
            if(seccion == 'ingresos'){

                titleModalEstadistica.innerHTML = 'Ingresos'
                inputRaza.classList.remove('hidden')
                inputRazaComparar.classList.remove('hidden')
            
            }
            
            if(seccion == 'egresos'){

                titleModalEstadistica.innerHTML = 'Egresos'

                inputDestino.classList.remove('hidden')
                inputRaza.classList.remove('hidden')
                inputGMD.classList.remove('hidden')
                inputGPV.classList.remove('hidden')
                inputDestinoComparar.classList.remove('hidden')
                inputRazaComparar.classList.remove('hidden')
                inputGMDComparar.classList.remove('hidden')
                inputGPVComparar.classList.remove('hidden')
        
            }
    
            if(seccion == 'muertes'){
        
                titleModalEstadistica.innerHTML = 'Muertes'

                inputCausaMuerte.classList.remove('hidden')
                inputCausaMuerteComparar.classList.remove('hidden')
        
            }

        })
    });
    
    let btnCompararEst = document.getElementById('compararEstadistica')
    
    btnCompararEst.addEventListener('click',()=>{
    
        document.getElementById('inputsEstComparar').classList.toggle('hidden')
    
        if(document.getElementById('inputsEstComparar').classList.contains('hidden')){

            document.getElementById('inputsEstComparar').style.display = 'none'
            document.getElementById('inputsEst').classList.remove('span6')
            document.getElementById('inputsEst').classList.add('span12')
            document.getElementById('inputsEst').style.borderRight = 'none'
    
            document.getElementById('modal-estadisticas').style.width = '500px'
            document.getElementById('modal-estadisticas').style.marginLeft = '-175px'
            document.getElementById('compararValido').value =  false
            
        }else{
            
            document.getElementById('inputsEstComparar').style.display = 'block'
            document.getElementById('compararValido').value =  true
            document.getElementById('modal-estadisticas').style.width = '1000px'
            document.getElementById('modal-estadisticas').style.marginLeft = '-500px'
    
            document.getElementById('inputsEst').classList.add('span6')
            document.getElementById('inputsEst').classList.remove('span12')
            document.getElementById('inputsEst').style.borderRight = 'solid 1px black'
    
        }
    
    })

}, 500);