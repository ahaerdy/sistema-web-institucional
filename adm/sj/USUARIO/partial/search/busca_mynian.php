<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(mynian) as mynian from usuarios where mynian  like '$q%' and mynian!='' order by mynian");
while($linha = mysql_fetch_array($sql)){
	$nome_usuarios	= utf8_encode($linha['mynian ']);

	echo $items = $nome_usuarios."\n";
}


?>
