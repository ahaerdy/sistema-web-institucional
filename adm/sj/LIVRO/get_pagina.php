<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  require ("../../config.inc.php");
  Conectar ();

  $id         = (int)getParam('id');
  $ac         = (int)getParam('ac');
  $capituloId = (int)getParam('id_capitulo');

  switch($ac):
    case 1 :
      if(empty($id) && empty($capituloId)):
        $res['erro'] = 1;
        $res['message'] = 'Informe a seção para adicionar a página, tente novamente.';
      else:
        $query = mysql_query("SELECT * FROM paginas WHERE id = ${id} AND id_capitulo = ${capituloId} ORDER BY numero ASC");
        if (mysql_num_rows($query)):
          $res['erro'] = 0;
          $res['data'] = mysql_fetch_assoc($query);
        endif;
      endif;
      break;
    case 2 :
      if(empty($capituloId)):
        $res['erro'] = 1;
        $res['message'] = 'Informe a seção para visualizar a página, tente novamente.';
      else:
        $query = mysql_query("SELECT * FROM paginas WHERE id_capitulo = ${capituloId} ORDER BY numero ASC");
        if(mysql_num_rows($query)):
          $res['erro'] = 0;
          $lns = '<option value="">-- Nova Página --</option>';
          while($ln = mysql_fetch_assoc($query)):
            $lns .= '<option value="'.$ln ['id'].'">Página: '.$ln['numero'].'</option>';
          endwhile;
          $res['data'] = $lns;
        else:
          $res['erro'] = 0;
          $res['data'] = '<option value="">-- Nova Página --</option>';
        endif;
      endif;
      break;
  endswitch;
  echo json_encode($res);
endif;
?>