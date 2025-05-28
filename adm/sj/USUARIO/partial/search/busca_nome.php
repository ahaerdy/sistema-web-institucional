<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;

//echo "select * from usuarios where nome like  = '$q%'";


$sql = mysql_query("select * from usuarios where nome like '$q%' order by nome");
while($linha = mysql_fetch_array($sql)){
	$nome_usuarios	= utf8_encode($linha['nome']);

	echo $items = $nome_usuarios."\n";
}


?>
