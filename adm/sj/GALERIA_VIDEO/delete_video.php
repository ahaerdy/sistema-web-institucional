<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
$videoId = (int)getParam("videoId");
$directory = $_SERVER['DOCUMENT_ROOT']."/..".base64_decode(getParam("directory"));
if((!empty($videoId) && !empty($directory)) && isXmlHttpRequest()):
  require("classe_conexao/class.conexao.php");
	$banco = new conexao();
	$banco->setTabela("videos");
	$banco->setCampos("video");
	$banco->setWhere("id = '$videoId' Limit 1");
	$img = $banco->selecionar();
	if($img["row"]):
		$img = mysql_fetch_assoc($img["sel"]);
		unlink($directory.$img["video"]);
   		unlink($directory.$img["foto"]);
		$banco->setTabela("videos");
		$banco->setWhere("id = '$videoId'");
		if($banco->delete())
      	$res = array('error'=>0, 'message'=>array('Vídeo excluido com sucesso','success'));
    else
		$res = array('error'=>1, 'message'=>array('Não foi possível fazer a exclusão do vídeo','danger'));
		echo json_encode($res);
	endif;
endif;
?>