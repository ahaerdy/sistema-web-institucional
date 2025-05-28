<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  	require ("../../config.inc.php");
  	Conectar ();

  	$id = (int)getParam('id');
  	$livroId = (int)getParam('id_livro');
  	$action = (int)getParam('ac');

	switch ($action):
		case 1:
			if (empty($id) || empty($livroId)):
				$res['erro'] = 1;
				$res['message'] = array('Informe o livro para selcionar a seção.', 'warning');
			else:
				$ins = mysql_query("SELECT * FROM capitulos WHERE id_livro = ${livroId} AND id = ${id} ORDER BY ordem ASC");
			if (mysql_num_rows($ins)):
			  $res['erro'] = 0;
			  $res['data'] = mysql_fetch_assoc($ins);
			else:
			  $res['erro'] = 1;
			  $res['message'] = array('Nenhum seção encontrada!', 'info');
			endif;
			endif;
			break;
		case 2:
			if(empty($livroId)):
				$res['erro'] = 1;
				$res['message'] = array('Informe o livro para visualizar os capitulos.', 'warning');
			else:
				$ins = mysql_query("SELECT * FROM capitulos WHERE id_livro = ${livroId} ORDER BY ordem ASC");
				if (mysql_num_rows( $ins)):
					$res['erro'] = 0;
					$lns = '<option value="">-- Seção --</option>';
					while($ln = mysql_fetch_assoc($ins)):
						$lns .= '<option value="' . $ln ['id'] . '">' . $ln ['numero'] . '</option>';
					endwhile;
					$res['option'] = $lns;
				else:
					$res['erro'] = 0;
					$res['option'] = '<option value="">-- Seção --</option>';
				endif;
			endif;
			break;
	endswitch;
	echo json_encode($res);
endif;
?>