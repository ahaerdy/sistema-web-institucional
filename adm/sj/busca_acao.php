<?php
    $res = mysql_query("SELECT id, nome FROM grupos WHERE id > '2' AND id IN (" . $_SESSION['login']['usuario']['todos_id_us'] . ") AND ativo = 'S' ORDER BY nome");

	while ($row = mysql_fetch_assoc($res))
	{
	    echo '<option value="'.$row["id"].'">'.($row["nome"]).'</option>';    
	}
    
    $res = mysql_query("SELECT * FROM topicos WHERE id_grupo = ".(int)$_SESSION['login']['iGrupo']." ORDER BY nome");
    						
	while ($row = mysql_fetch_assoc($res))
	{
	    echo '<option value="'.$row["id"].'">'.($row["nome"]).'</option>';    
	}
?>
