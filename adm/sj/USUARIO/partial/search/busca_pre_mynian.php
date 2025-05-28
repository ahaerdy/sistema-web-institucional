<?php

require('../../config.inc.php');
Conectar();

$q = strtolower($_GET["q"]);
if (!$q) return;


$sql = mysql_query("select distinct(pre_mynian) as pre_mynian from usuarios where pre_mynian like '$q%' and pre_mynian!='' order by pre_mynian");
while($linha = mysql_fetch_array($sql)){
	$pre_mynian 	= utf8_encode($linha['pre_mynian']);

	echo $items = $pre_mynian."\n";
}


?>
