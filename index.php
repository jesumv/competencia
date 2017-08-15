<?php
    /*** Autoload class files ***/
    function __autoload($class){
      require('include/' . strtolower($class) . '.class.php');
    }
    //directiva a la conexion con base de datos
    $funcbase = new dbutils;
    $mysqli = $funcbase->conecta();
	
 /*** si se establecio la conexion***/
    if (is_object($mysqli)) {
        session_start(); 
		       
    } else {
        die ("<h1>'No se establecio la conexion a bd'</h1>");
    }
   
   function consultareg($mysqli){	
//esta funcion crea la tabla con los registros de competencia
$consulta= "SELECT t1.fecha,t1.producto, CONCAT(t2.nombre,' ',t2.marca,' ',t2.cant,' ',t3.nombre),t1.precio, t1.punit, t4.nombre FROM tblregistro AS t1 
INNER JOIN tblproducto AS t2 ON t1.producto = t2.idproducto INNER JOIN tblunids AS t3 ON t2.unid = t3.idunids 
INNER JOIN tbllugar AS t4 ON t1.lugar = t4.idlugar ORDER BY t1.producto";
$query= mysqli_query($mysqli, $consulta) or die ("ERROR EN CONSULTA REGISTROS. ".mysqli_error($mysqli));
		echo"<DIV style='width:80%'><h3>REGISTRO DE COMPETENCIA</h3><table border='1' cellspacing='5' cellpadding='5'";
		echo"<tr><th>fecha</th><th>idproducto</th><th>producto</th><th>precio</th><th>precio unit</th><th>lugar</th>
			</tr>";
		while ($fila = mysqli_fetch_array($query)) {
				echo"<tr>";
					for ($i=0; $i < 6; $i++) {
							echo "<td>".$fila[$i]."</td>";		 	
					}
				echo"</tr>";
		}
		echo "</table></DIV>";
}
    
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Competencia</title>
  <!-- Insert link to styles here -->
  <link rel="stylesheet" type="text/css" href="css/inline.css">
  <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css"">
    <style>
  .ui-autocomplete {
    max-height: 100px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
  </style>
  <!-- Insert links to icons here -->
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script>
	'use strict';
   	(function() {
   		$(document).ready(function() {
	   		var app = {
				    isLoading: true,
				    spinner: document.querySelector('.loader'),
				    container: document.querySelector('.main'),
				    addDialog: document.querySelector('#dialogoc'),
				  };
  /*****************************************************************************
   *
   * Metodos para actualizar/refrescar la IU
   *
   ****************************************************************************/  
			   // Toggles the visibility of dialog  	 
				  app.toggleAddDialog = function(visible) {
				    if (visible) {
				      app.addDialog.classList.add('dialog-container--visible');
				    } else {
				      app.addDialog.classList.remove('dialog-container--visible');
				    }
				  }; 
			//metodos de los elementos de la pagina
			function muestrad(){
   				app.toggleAddDialog(true)
   				document.getElementById('fgas').focus();
   			}
   			
   			function cancela(){
   				app.toggleAddDialog(false)
   				document.getElementById('avisor').innerHTML="";
   				document.getElementById('regcomp').reset();
   			}	
   		//metodos de jqueryui
   				   $('#prod').autocomplete({
			autoFocus: true,
            source: "php/get_prod_list.php",
            minLength: 6,
            select: function( event, ui ) {
            	var idproducto =  ui.item.idproducto;	
            	$('#idprod').val(idproducto);								
            	$('#lug').focus();      						
            }  
        });
        
        $('#lug').autocomplete({
			autoFocus: true,
            source: "php/get_lug_list.php",
            minLength: 3,
            select: function( event, ui ) {
            	var idlug = ui.item.idlugar;	
            	$('#idlug').val(idlug);								
            	$('#precioa').focus();      						
            }  
        });    
        
        
		//escuchas
   			//boton gasto
			document.getElementById('botreg').addEventListener('click',muestrad,false)
			//boton cancela
			document.getElementById('botCancel').addEventListener('click',cancela,false)
   	   		 });	
   	})();
</script>
</head>


<body>

  <header class="header">
    <h1 class="header__title">Vannetti Cucina</h1>
  </header>
  

  <main class="main">
  	<br />
  <h2> Competencia</h2>
 	<br/>
	  <div class="botoncent">
	  	<button class="button c" type="button" id="botreg">Registrar Ocurrencia</button>
	  </div>
	  
	  <?php
			consultareg($mysqli);
		?>
	<br />
  
  </main>

  <div class="dialog-container" id="dialogoc">
      <div class="dialog">
      <div class="dialog-title">Registro de Competencia</div>
      <div class="dialog-body ui-front">
        <!-- la caja para registro evento -->
        <form id="regcomp" name="regcomp" method ="post" action="#" onsubmit="return false;">
        	<div class="rengn">
			    <label>Fecha: </label><input type="date" name="fgas"  id="fgas" class="cajam"/>
		</div> 
		
		<div class="listaf rengn">
			<label for "prod">Producto: </label>
            <input type="text" id="prod"  name="prod"/>
            <input type='hidden' id='idprod' name ='idprod' />
		</div>
		<div class="rengn">
			<fieldset>
				<legend>Ultimo Registro</legend>
				<label for "ultfec">Fecha: </label>
	            <input type="text" id="ultfec"  name="ultfec"/>
	            <label for "uprecio">Precio: </label>
	            <input type="text" id="uprecio"  name="uprecio"/>
            </fieldset>
		</div>
		<div class="rengn">
			<label for "lug">Lugar: </label>
            <input type="text" id="lug"  name="lug"/>
            <input type='hidden' id='idlug' name ='idlug' />
		</div>  
		<div class="rengn">
			<fieldset>
				<legend>Datos</legend>
				<label for "precioa">Precio: </label>
	            <input type="text" id="precioa"  name="precioa"/>
	            <label for "punit">Precio Unitario: </label>
	            <input type="text" id="punit"  name="punit"/>
			</fieldset>
			
		</div>
      </div>
      <div class="rengn">
			<h4 id="avisor"></h4>
	 </div>
		<div class="dialog-buttons">
			<button type="submit" id="regevent" class="button a">Registrar</button>
	      	<button type="submit" id="botCancel" class="button b" >Cancelar</button>
	    </div>
      </form>
    </div>
  </div>

  
</body>
</html>

