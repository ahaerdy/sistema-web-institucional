<?php

require('../../config.inc.php');
Conectar();


$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(servico_abraxico) as servico_abraxico from usuarios where servico_abraxico  like '$q%' and servico_abraxico!='' order by servico_abraxico");
while($linha = mysql_fetch_array($sql)){
	$nome_usuarios	= utf8_encode($linha['servico_abraxico']);

	echo $items = $nome_usuarios."\n";
}


?>
