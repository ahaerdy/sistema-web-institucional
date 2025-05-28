<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select * from usuarios"); 
while($linha = mysql_fetch_array($sql)){
	$estado	= utf8_encode($linha['estado']);

	echo $items = $estado."\n";
}


?>