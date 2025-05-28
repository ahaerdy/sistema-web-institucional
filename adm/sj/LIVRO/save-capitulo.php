<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  require ("../../config.inc.php");
  Conectar ();	

  $livroId = (int)getParam('id_livro');
  $capituloId = (int)getParam('id_capitulo');
  $ordem = (int)getParam('ordem');
  $numero = getParam('numero');
  $paginado = getParam('paginado');
  $descricao = getParam('descricao');

  if(empty($livroId) || empty($ordem) || empty($numero) || empty($paginado)):
    $res['erro'] = 1;
    $res['message'] = array('Informe o dados obrigatórios para adicionar a seção.', 'warning');
  else:
		$query = mysql_query("SELECT id FROM capitulos WHERE id_livro = ${livroId} AND  paginado = '${paginado}' AND  numero = '${numero}' AND ordem = '${ordem}' LIMIT 1");
		if(mysql_num_rows($query)):
			$res['erro'] = 1;
			$res['message'] = array("Seção já cadastrada, informe um nova seção ou a faça uma edição!", 'warning');
		else:		
			if(!$capituloId):
				$ins = mysql_query("INSERT INTO capitulos (id_livro, descricao, ordem, numero, paginado) VALUES ('${livroId}','${descricao}','${ordem}','${numero}','${paginado}')");
				if ($ins):
					$res['erro'] = 0;
					$res['id_capitulo'] = mysql_insert_id ();
					$res['message'] = array('Seção adicionada com sucesso!', 'success');
				else:
					$res['erro'] = 1;
					$res['message'] = array('Não foi possível adicionar a seção, tente novamente!', 'danger');
				endif;
		  else:
				$up = mysql_query("UPDATE capitulos SET descricao='${descricao}',ordem='${ordem}',numero='${numero}',paginado='${paginado}' WHERE id = '${capituloId}' LIMIT 1");
				if ($up):
					$res['erro'] = 0;
          $res['id_capitulo'] = $capituloId;
					$res['message'] = array('Seção alterada com sucesso!', 'success');
				else:
					$res['erro'] = 1;
					$res['message'] = array('Não foi possível adicionar a seção, tente novamente!', 'danger');
				endif;
			endif;
		endif;
	endif;
	echo json_encode($res);
endif;
?>