<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  require ("../../config.inc.php");
  Conectar ();

  $id = (int) getParam('id');

	if($id):
		$ins = mysql_query("DELETE FROM paginas WHERE id = ${id} LIMIT 1");
		if ($ins):
			$res['erro'] = 0;
			$res['message'] = array('Página excluída com sucesso!', 'success');
		else:
			$res['erro'] = 1;
			$res['message'] = array('Não foi possível excluír a página, tente novamente!', 'danger');
		endif;
	else:
		$res['erro'] = 1;
		$res['message'] = array('Não foi possível excluír a página, tente novamente!', 'danger');
	endif;
	echo json_encode ( $res);
endif;
?>