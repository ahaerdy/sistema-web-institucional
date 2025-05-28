<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;

#select distinct(pais) from usuarios where pais !='' group by pais
$sql = mysql_query("select distinct(pais) as pais from usuarios where pais like '$q%' and pais !='' order by pais");
while($linha = mysql_fetch_array($sql)){
	$pais	= utf8_encode($linha['pais']);

	echo $items = $pais."\n";
}


?>
