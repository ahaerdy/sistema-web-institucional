<?php
    session_start();

    if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

	if (isset($_POST) && ! empty($_POST))
    {
    	require("../../config.inc.php");
        Conectar();
        
        //-------------------------------------------------------------------------------------------------
        
        $idGrupo = (int) $_POST['id'];

		//-------------------------------------------------------------------------------------------------

        $res = mysql_query("SELECT
        						tp.id, 
							   	tp.nome
							FROM
							    grupos gp, topicos tp
							WHERE
							    (
									gp.id = tp.id_grupo AND (
									
										tp.id IN (
												SELECT 
													tp.id
												FROM
													grupos gp,
													topicos tp
												WHERE
													gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") 
														AND gp.id = tp.id_grupo
														AND gp.ativo = 'S'
														AND tp.ativo = 'S'
														AND gp.id = $idGrupo
        												AND tp.id_topico = 0
										)
										OR 
										tp.id IN (
												SELECT 
													tp.id
												FROM
													grupos gp,
													topicos tp
												WHERE
													gp.id IN (" . $_SESSION['login']['usuario']['todos_id_us'] . ")
														AND gp.id NOT IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ")
														AND gp.id = tp.id_grupo
														AND gp.ativo = 'S'
														AND tp.ativo = 'S'
														AND tp.compartilhado = 'S'
														AND gp.id = $idGrupo
														AND tp.id_topico = 0
										)
									)
								)
							ORDER BY tp.nome ASC
							") or die(mysql_error());

		$r['qtd'] = mysql_num_rows($res);

		$op .= '<option value="" selected="selected"> - Selecione o Assunto - </option>'; 

		while ($row = mysql_fetch_assoc($res))
		{
			if($row["id"] == (int)$_POST['idTopico'])
			{
				$op .= '<option value="' . $row["id"] . '" selected="selected">' . $row["nome"] . '</option>';
			}
			else
			{
		        $op .= '<option value="' . $row["id"] . '">' . $row["nome"].'</option>';
		    }
		}

		$r['op'] = $op;

		echo json_encode($r);

		//-------------------------------------------------------------------------------------------------	
	}
?>

