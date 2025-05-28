<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(familia) as familia from usuarios where familia like '$q%' and familia !='' order by familia");
while($linha = mysql_fetch_array($sql)){
	$nome_usuarios	= utf8_encode($linha['familia']);

	echo $items = $nome_usuarios."\n";
}


?>
