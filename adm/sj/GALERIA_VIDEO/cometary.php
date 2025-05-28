<?php

session_start();

if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

require '../includes/functions/functions.php';

$fotoId = (int)getParam("fotoId");

$text = getParam("text");

if(!empty($fotoId) && isXmlHttpRequest()):

  require '../GALERIA_IMAGEM/classe_conexao/class.conexao.php';

  $banco = new conexao();

  $banco->setTabela("videos");

  $banco->setCampos("comentario = '${text}'");

  $banco->setWhere("id = ${fotoId}");

  if($banco->alterar())

    $res = array('error'=>0, 'message'=>array('Comentário alterado com sucesso','success'));

  else

    $res = array('error'=>1, 'message'=>array('Não foi possível alterar o comentário','danger'));

  echo json_encode($res);

endif;

?>