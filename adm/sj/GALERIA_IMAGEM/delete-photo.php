<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
$fotoId = (int)getParam("fotoId");
$directory = $_SERVER['DOCUMENT_ROOT']."/..".base64_decode(getParam("directory"));
if((!empty($fotoId) && !empty($directory)) && isXmlHttpRequest()):
  require("classe_conexao/class.conexao.php");
	$banco = new conexao();
	$banco->setTabela("fotos");
	$banco->setCampos("foto");
	$banco->setWhere("id = '$fotoId' Limit 1");
	$img = $banco->selecionar();
	if($img["row"]):
		$img = mysql_fetch_assoc($img["sel"]);
		unlink($directory.$img["foto"]);
   		unlink($directory."thumb_".$img["foto"]);
		$banco->setTabela("fotos");
		$banco->setWhere("id = '$fotoId'");
		if($banco->delete())
      		$res = array('error'=>0, 'message'=>array('Foto excluida com sucesso','success'));
    	else
			$res = array('error'=>1, 'message'=>array('Não foi possível fazer a exclusão da foto','danger'));
		echo json_encode($res);
	endif;
endif;
?>