<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  require ("../../config.inc.php");
  Conectar ();

  $paginaId   = (int) getParam('id_pagina');
  $capituloId = (int) getParam('id_capitulo');
  $numero     = (int) getParam('numero');
  $texto      = getParam('texto');
  $texto2     = strip_tags(getParam('texto'));

  if ($capituloId && $numero):
    if (empty($paginaId)):
      $ins = mysql_query("INSERT INTO paginas (id_capitulo,numero,texto,texto_pesquisa) VALUES (${capituloId},${numero},'${texto}','${texto2}')");
      if ($ins):
        $res['erro'] = 0;
        $res['id_pagina'] = mysql_insert_id();
        $res['message'] = array('Página adicionada com sucesso!', 'success');
      else:
        $res['erro'] = 1;
        $res['message'] = array('Não foi possível adicionar o página, tente novamente!', 'danger');
      endif;
    else:
      $ins = mysql_query("UPDATE paginas SET id_capitulo=${capituloId},numero=${numero},texto='$texto',texto_pesquisa='$texto2' WHERE id=${paginaId} LIMIT 1");
      if ($ins):
        $res['erro'] = 0;
        $res['id_pagina'] = $paginaId;
        $res['message']  = array('Página alterada com sucesso!', 'success');
      else:
        $res['erro'] = 1;
        $res['message']  = array('Não foi possível adicionar o página,tente novamente!', 'danger');
      endif;
    endif;
  else:
    $res['erro'] = 1;
    $res['message']  = array('Informe o dados obrigatórios para adicionar a página.', 'warning');
  endif;
  echo json_encode($res);
endif;
?>