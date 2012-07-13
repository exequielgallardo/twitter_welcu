<?php 
	require_once ("jpgraph/src/jpgraph.php");
	require_once ("jpgraph/src/jpgraph_pie.php");
	 
	// Conectar con la BD
	try {
	    $db = new PDO('sqlite:twitter.database');
	} catch (Exception $e) {
	    die ($e);
	}
	
	try {
	    $posts = $db->prepare('SELECT * FROM busqueda;');
	    $posts->execute();
	} catch (Exception $e) {
	    die ($e);
	}
	
	while ($post = $posts->fetchObject()){
		$leyenda[] = $post->texto;
		$id_busqueda[] = $post->id;
	}
	
	foreach ($id_busqueda as $id){
		$consulta = "SELECT * FROM resultados WHERE id_busqueda = $id";
		$result = $db->query($consulta);
		$arreglo = array();
	    foreach ($result as $valor) {
			$arreglo[] = $valor['id'];
	    }		
	 $datos[] =count($arreglo);
	}
	

	// Se define el array de valores y el array de la leyenda
//	$datos = array(40,30,21,33);
//	$leyenda = array("Morenas","palabra","cccc","Otras");
	 
	//Se define el grafico
	$grafico = new PieGraph(300,200);
	
	//Definimos el titulo 
	$grafico->title->Set("% del total resultados exitosos");
	$grafico->title->SetFont(FF_FONT1,FS_BOLD);
	 
	//Añadimos el titulo y la leyenda
	$p1 = new PiePlot($datos);
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.4);
	 
	//Se muestra el grafico
	$grafico->Add($p1);
	$grafico->Stroke();
?>
∫