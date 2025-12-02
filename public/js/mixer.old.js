
const renderInsumoMixer = (producto,numero)=>{

    let divContenedor = document.createElement('DIV')
    let divNombreInsumo = divContenedor.cloneNode(true)
    let divCantPorc = divContenedor.cloneNode(true)
    let divPorceTC = divContenedor.cloneNode(true)
    let divCantKilos = divContenedor.cloneNode(true)
    let divMargen = divContenedor.cloneNode(true)
    let inputMargen = document.createElement('INPUT')
    
    let divDietaFinal = divContenedor.cloneNode(true)
    let divKgRedondeo = divContenedor.cloneNode(true)
    let spanKgRedondeo = document.createElement('SPAN')
    let divDifPorce = divContenedor.cloneNode(true)
    let spanDifPorce = spanKgRedondeo.cloneNode(true)
    let divMS = divContenedor.cloneNode(true)
    let spanMS = spanKgRedondeo.cloneNode(true)
    let divKilosMS = divContenedor.cloneNode(true)
    let divTotalPorcMS = divContenedor.cloneNode(true)
    
    
    divContenedor.setAttribute('class','row-fluid registroInsumos')
    divContenedor.setAttribute('style','border-bottom: 1px solid #7D7D7D')
    
    divNombreInsumo.setAttribute('class','span2')
    divNombreInsumo.setAttribute('id',`nombreInsumo_${producto}`)
    divCantPorc.setAttribute('class','span1 cantPorc')
    divCantPorc.setAttribute('id',`porceTC_${producto}`)
    divPorceTC.setAttribute('class','span1 porceTC')
    divPorceTC.setAttribute('id',`cantPorc_${producto}`)
    divCantKilos.setAttribute('class','span1 cantKilos')
    divCantKilos.setAttribute('id',`cantKilos_${producto}`)
    divMargen.setAttribute('class','span1')

    inputMargen.setAttribute('type','number')
    inputMargen.setAttribute('step','0.01')
    inputMargen.setAttribute('class','input-mini')
    inputMargen.setAttribute('style','margin-bottom:0')
    inputMargen.setAttribute('name',`redondeo${numero}`)
    inputMargen.setAttribute('id',`redondeo_${producto}`)


    divDietaFinal.setAttribute('class','span1 dietaFinal')
    divDietaFinal.setAttribute('id',`dietaFinal_${producto}`)
    
    divKgRedondeo.setAttribute('class','span1')
    spanKgRedondeo.setAttribute('id',`kgRedondeo_${producto}`)

    divDifPorce.setAttribute('class','span1')
    spanDifPorce.setAttribute('class','difPorce')
    spanDifPorce.setAttribute('id',`difPorce_${producto}`)

    divMS.setAttribute('class','span1')
    spanMS.setAttribute('class','MS')
    spanMS.setAttribute('id',`MS_${producto}`)
    
    divKilosMS.setAttribute('class','span1 kilosMS')
    divKilosMS.setAttribute('id',`kilosMS_${producto}`)
    
    divTotalPorcMS.setAttribute('class','span1')
    divTotalPorcMS.setAttribute('id',`totalPorcMS_${producto}`)

    divContenedor.appendChild(divNombreInsumo)
    divContenedor.appendChild(divCantPorc)
    divContenedor.appendChild(divPorceTC)
    divContenedor.appendChild(divCantKilos)
    
    divMargen.appendChild(inputMargen)
    divContenedor.appendChild(divMargen)
    
    divContenedor.appendChild(divDietaFinal)
    
    divKgRedondeo.appendChild(spanKgRedondeo)
    divContenedor.appendChild(divKgRedondeo)

    divDifPorce.appendChild(spanDifPorce)
    divContenedor.appendChild(divDifPorce)

    divMS.appendChild(spanMS)
    divContenedor.appendChild(divMS)
    
    divContenedor.appendChild(divKilosMS)
    divContenedor.appendChild(divTotalPorcMS)

    
    return divContenedor
    
}



function verModalMixer(id){

    let url = 'ajax/mixer.ajax.php'

    let data = `id=${id}`

    $.ajax({
        method:'POST',
        url,
        data,
        success:(response)=>{

            let data = JSON.parse(response)

            let nodoPadre = document.getElementById('formModalMixer')

            let nodoTotales = document.getElementById('totalesMixer')

            $('.registroInsumos').remove()

            document.getElementById('btnImprimirMixer').setAttribute('onclick',`imprimirMixer('${data.id}')`)

            document.getElementById('nombreFormula').innerHTML = data.nombreFormula
            
            document.getElementById('formModalMixer').setAttribute('action',`raciones.php?accion=cargarRedondeo&id=${data.id}`)
            
            document.getElementById('kilosDieta').innerHTML = data.kilos
            
            document.getElementById('margenError').value = data.margen

            for (let index = 0; index < 11; index++) {
                
                let producto = `p${index + 1}`

                let numero = index + 1

                if(data[producto] == undefined)
                    break

                nodoPadre.insertBefore(renderInsumoMixer(producto,numero),nodoTotales);

                document.getElementById('nombreInsumo_' + producto).innerHTML = data[producto].nombre
                
                document.getElementById('porceTC_' + producto).innerHTML = data[producto].porcentaje
                
                document.getElementById('cantPorc_' + producto).innerHTML = data[producto].porcentajeMS
                
                document.getElementById('cantKilos_' + producto).innerHTML = data[producto].cantKilos
                
                document.getElementById('redondeo_' + producto).value = data[producto].redondeoMixer
                
                document.getElementById('dietaFinal_' + producto).innerHTML = data[producto].redondeoMixer || 0

                document.getElementById('kgRedondeo_' + producto).innerHTML = data[producto].kgRedondeo || '0 Kg'
                
                document.getElementById('difPorce_' + producto).innerHTML = data[producto].difPorcentaje || 0

                document.getElementById('difPorce_' + producto).innerHTML = document.getElementById('difPorce_' + producto).innerHTML + ' %'
                
                document.getElementById('MS_' + producto).innerHTML = data[producto].porcentajeMSInsumo || 0

                document.getElementById('MS_' + producto).innerHTML = document.getElementById('MS_' + producto).innerHTML + ' %'
                
                document.getElementById('kilosMS_' + producto).innerHTML = data[producto].kilosMS || '0 Kg'
                
            }

            
            let margenErrorNegativo = '-' + data.margen;
            
      
            $('.difPorce').each(function(){
                
                let difPorce = parseFloat($(this).text());
                
                if(difPorce < margenError && difPorce > margenErrorNegativo){
        
                    $(this).css('color','green');
                    
                }else{
        
                    $(this).css('color','red');
        
                }
        
            });


            let porceMS = [];

            $('.MS').each(function(){
        
                porceMS.push(parseFloat($(this).html()));
        
            }); 

// console.log(porceMS); TOMAR DE PORCENTAJE MS ES IGUAL AL TOTAL MS
        // PORCENTAJE DIETA
            
            let totalPorce = 0;

            $('.cantPorc').each(function(){

                let porce = parseFloat($(this).html().replace(' ',''));
                
                totalPorce += porce;

            });

            $('#totalCantPorc').html(totalPorce + ' %');


            // PORCENTAJE MS INSUMO

            let porceMSInsumo = [];

            let totalPorceMSInsumo = 0;

            $('.porceTC').each(function(){

                let porceMSInsumoVal = parseFloat($(this).html().replace(' ',''));
                
                porceMSInsumo.push(porceMSInsumoVal);

                totalPorceMSInsumo += porceMSInsumoVal;
                
            }); 

            $('#porceTCtotal').html(totalPorceMSInsumo.toFixed(2) + ' %');

            console.log(porceMSInsumo);

        // KILOS ASIGNADOS 

            let totalKilos = 0;

            $('.cantKilos').each(function(){

                let kilos = parseFloat($(this).html().replace(' ',''));
                
                totalKilos += kilos;

            });

            $('#totalCantKilos').html(totalKilos + ' Kg');


            // DIETA FINAL

            let totalDietaFinal = 0;

            $('.dietaFinal').each(function(){

                let kilos = parseFloat($(this).html().replace(' ',''));
                
                totalDietaFinal += kilos;

            });

            $('#dietaFinal').html(totalDietaFinal + ' Kg'); 


            // KG MS

            let totalKgMs = 0;

            $('.kilosMS').each(function(){

                var kilos = parseFloat($(this).html().replace(' ',''));
                
                totalKgMs += kilos;

            });

            $('#kilosMS').html(totalKgMs + ' Kg'); 


        // % MS DIETA

            let totalPorceMSDieta = 0;

            for (let index = 0; index < porceMS.length; index++) {
                
                let porceMSDieta = ((porceMS[index] * porceMSInsumo[index]) / 100);

                $(`#totalPorcMS_p${index + 1}`).html(porceMSDieta.toFixed(2) + ' %');

                totalPorceMSDieta += porceMSDieta;
                
            }

            $('#totalMSporc').html(totalPorceMSDieta.toFixed(2) + ' %');
        }
    })

}

function imprimirMixer(idRacion){
    
    id = idRacion;
    
    totalMS = parseFloat($('#kilosMS').text().replace('Kg',''));

    window.open('imprimir/mixer.php?id=' + id + '&totalMS=' + totalMS);
  
}


function cargarSelect(tabla){

    var data = 'tabla=' + tabla;

    var url = 'ajax/cargarSelectMixer.ajax.php';

    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        success: function(respuesta){
            
            if(tabla == 'formulas'){
                
                $('#formula').append(respuesta);
                
            }else{
                
                $('#operario').append(respuesta);
            
            }

        }  

    });

}


function cargarRacionesMixer(){

    $('#paginadoMixer').append('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
    
    datosPag = 'desde=0'; 
    
    var urlPaginador = 'paginadorMixer.php';
    
    $.ajax({
    
      type:'POST',
      
      url:urlPaginador,
      
      data:datosPag,
      
      success: function(datosPag){

        $('#paginadoMixer br').remove()
        $('#paginadoMixer .loading').remove()

        $('#paginadoMixer').append(datosPag);
      
      }
    
    });
}

function paginarMixer(pagina,seccion){
    
    let datosPag;

    let desde;

    let urlPaginador = 'paginadorMixer.php';

    desde = (pagina * 8) + 1;

    if (pagina == 0) {

      desde = (pagina * 8);

    }
    var contenedor = '#paginadoMixer';

    $(contenedor).html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');

    datosPag = 'desde=' + desde; 

    $.ajax({

    type:'POST',

    url:urlPaginador,

    data:datosPag,

    success: function(datosPag){

        let form = $('#paginadoMixer:first');

        $(contenedor).html(form);
        $(contenedor).append(datosPag);

    }

    });



  };