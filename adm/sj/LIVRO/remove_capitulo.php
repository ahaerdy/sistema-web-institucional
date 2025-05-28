<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  require ("../../config.inc.php");
  Conectar ();

  $id = (int ) getParam('id');

	if($id):
		$ins1 = mysql_query("DELETE FROM paginas WHERE id_capitulo = ${id}");
		$ins2 = mysql_query("DELETE FROM capitulos WHERE id = ${id}");
		if($ins1 && $ins2):
			$res['erro'] = 0;
			$res['message'] = array('Capítulo excluído com sucesso!', 'success');
		else:
			$res['erro'] = 1;
			$res['message'] = array('Não foi possível excluír o capítulo, tente novamente!', 'danger');
		endif;
	else:
		$res['erro'] = 1;
		$res['message'] = array('Não foi possível excluír o capítulo, tente novamente!', 'danger');
	endif;
	echo json_encode($res );
endif;
?>