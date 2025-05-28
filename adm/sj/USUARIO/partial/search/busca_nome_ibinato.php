<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(nome_ibnato) as nome_ibnato from usuarios where nome_ibnato  like '$q%' and nome_ibnato!='' order by nome_ibnato");
while($linha = mysql_fetch_array($sql)){
	$nome_usuarios	= utf8_encode($linha['nome_ibnato']);

	echo $items = $nome_usuarios."\n";
}


?>
