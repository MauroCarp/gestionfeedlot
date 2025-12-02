<div class="row-fluid">
    
    <div class="span12">
    
        <h3>Ingresos por Balanza</h3>
   
     </div>
    
     <div class="span12">

        <ul class="totales" style="background-color:transparent!important;">

            <li><b>- Total Ingresos: </b><?php echo number_format($cantIng,0,",",".")." Animales";?></li>

            <li><b>- Kg Neto Ingreso: </b><?php echo number_format($pesoTotalIng,0,",",".")." Kg";?></li>

            <li><b>- Kg Ingreso Promedio: </b><?php echo number_format($kgIngProm,0,",",".")." Kg";?></li>

            <li><b>- Peso Min: </b><?php  echo ($kgMinIng == 1_000_000) ? "0 Kg" : number_format($kgMinIng,0,",",".")." Kg";?></li>

            <li><b>- Peso Max: </b><?php echo number_format($kgMaxIng,0,",",".")." Kg";?></li>

        </ul>

        <div style="text-align:right; margin-top:10px;">
            <a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-primary" target="_blank"><span class="icon-printer iconos"></span></a>
        </div>
                
    </div>

</div>