<?php
	if($tipo && $secao):
		if(!mysql_num_rows(mysql_query("SELECT id FROM visualizado WHERE usuario_id = ".getIdUsuario()." AND secao_id = ${secao} AND tipo = '${tipo}' LIMIT 1"))):
			mysql_query("INSERT INTO visualizado (usuario_id, secao_id, tipo) VALUES (".getIdUsuario().", ${secao}, '${tipo}')");
		endif;
	endif;
?>