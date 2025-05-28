<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(selamentos) as selamentos from usuarios where selamentos like '$q%' and selamentos!='' order by selamentos");
while($linha = mysql_fetch_array($sql)){
	$selamento	= utf8_encode($linha['selamentos']);

	echo $items = $selamento."\n";
}


?>
