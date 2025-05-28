<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select * from usuarios where bairro like '$q%' order by bairro");
while($linha = mysql_fetch_array($sql)){
	$bairro	= utf8_encode($linha['bairro']);

	echo $items = $bairro."\n";
}


?>
