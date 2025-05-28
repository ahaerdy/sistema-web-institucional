<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(voluntario) as voluntario from usuarios where voluntario  like '$q%' and voluntario!='' order by voluntario");
while($linha = mysql_fetch_array($sql)){
	$nome_usuarios	= utf8_encode($linha['voluntario']);

	echo $items = $nome_usuarios."\n";
}


?>
