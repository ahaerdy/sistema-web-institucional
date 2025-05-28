<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(motivo) as motivo from usuarios where motivo  like '$q%' and motivo!='' order by motivo");
while($linha = mysql_fetch_array($sql)){
	$motivo	= utf8_encode($linha['motivo']);

	echo $items = $motivo."\n";
}


?>
