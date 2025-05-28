<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;

//echo "select * from usuarios where nome like  = '$q%'";


$sql = mysql_query("select * from usuarios where cidade like '$q%' order by nome");
while($linha = mysql_fetch_array($sql)){
	$nome_cidade	= utf8_encode($linha['cidade']);

	echo $items = $nome_cidade."\n";
}


?>
