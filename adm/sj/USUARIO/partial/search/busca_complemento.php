<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;

#select distinct(pais) from usuarios where pais !='' group by pais
$sql = mysql_query("select distinct(complemento) as complemento from usuarios where complemento like '$q%' and complemento !='' order by complemento");
while($linha = mysql_fetch_array($sql)){
	$pais	= utf8_encode($linha['complemento']);

	echo $items = $pais."\n";
}


?>
