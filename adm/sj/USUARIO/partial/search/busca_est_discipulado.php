<?php

require('../../config.inc.php');
Conectar();


$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(estado_discipular) as estado_discipular from usuarios where estado_discipular  like '$q%' and estado_discipular!='' order by estado_discipular");
while($linha = mysql_fetch_array($sql)){
	$nome_usuarios	= utf8_encode($linha['estado_discipular']);

	echo $items = $nome_usuarios."\n";
}


?>
