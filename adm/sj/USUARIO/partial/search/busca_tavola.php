<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(tavola) as tavola from usuarios where tavola  like '$q%' and tavola!='' order by tavola");
while($linha = mysql_fetch_array($sql)){
	$tavola	= utf8_encode($linha['tavola']);

	echo $items = $tavola."\n";
}


?>
