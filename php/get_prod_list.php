<?php
	/*** Autoload class files ***/ 
    function __autoload($class){
      require('../include/' . strtolower($class) . '.class.php');
    }
    
    $funcbase = new dbutils;
/*** conexion a bd ***/
    $mysqli = $funcbase->conecta();
    if (is_object($mysqli)) {
/*** checa login***/
        //$funcbase->checalogin($mysqli);
    } else {
        die ("<h1>'No se establecio la conexion a bd'</h1>");
    }
	
    $req = "SELECT t1.idproducto AS idproducto,t1.nombre AS nombre, t1.marca AS  marca,
     t1.cant AS cant,  t2.nombre AS unid FROM tblproducto AS t1 LEFT JOIN tblunids AS t2 on t1.unid = t2.idunids 
     WHERE t1.nombre LIKE '" . mysqli_real_escape_string($mysqli,$_GET['term']) .
     "%'"; 
    $query = mysqli_query($mysqli,$req);
    
    while($row = mysqli_fetch_array($query))
    {
    	$prod = $row['nombre'];
    	$marca = $row['marca'];
		$cant = $row['cant'] ;
		$unid = $row['unid'];
		$producto = $prod." ".$cant." ".$unid." ".$marca;
        $results[] = array('label' => $producto,'idproducto' => $row['idproducto']);
    }
	
	 /* liberar la serie de resultados */
	    mysqli_free_result($query);
	    /* cerrar la conexion */
	    mysqli_close($mysqli);
    
    	echo json_encode($results);


?>