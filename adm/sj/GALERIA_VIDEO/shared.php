<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
$fotoId = (int)getParam("fotoId");
$action = getParam("action");
if(!empty($fotoId) && isXmlHttpRequest()):
  require '../GALERIA_IMAGEM/classe_conexao/class.conexao.php';
  $banco = new conexao();
  $banco->setTabela("videos");
  $banco->setCampos("compartilhado = '${action}'");
  $banco->setWhere("id = '${fotoId}'");
  if($banco->alterar())
    $res = array('error'=>0, 'message'=>array('Compartilhamento alterado com sucesso','success', $action));
  else
    $res = array('error'=>1, 'message'=>array('Não foi possível alterar o compartilhamento','danger'));
  echo json_encode($res);
endif;
?>