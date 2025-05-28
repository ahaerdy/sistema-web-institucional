<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(discipulado) as discipulado from usuarios where discipulado like '$q%' and discipulado!='' order by discipulado");
while($linha = mysql_fetch_array($sql)){
	$discipulado	= utf8_encode($linha['discipulado']);

	echo $items = $discipulado."\n";
}


?>
