<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(endereco) as endereco from usuarios where endereco like '$q%' and endereco!='' order by endereco");
while($linha = mysql_fetch_array($sql)){
	$endereco	= utf8_encode($linha['endereco']);

	echo $items = $endereco."\n";
}


?>
