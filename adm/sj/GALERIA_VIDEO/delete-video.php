<?php
session_start();
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

require '../GALERIA_IMAGEM/classe_conexao/class.conexao.php';

$id        = (int)$_POST["fotoId"];
$diretorio = realpath($_SERVER['DOCUMENT_ROOT'].'/..'.base64_decode($_POST["directory"])).'/';

$banco = new conexao();
$banco->setTabela("videos");
$banco->setCampos("video, foto");
$banco->setWhere("id = $id");
$res = $banco->selecionar();

if($res["row"])
{
	$res = mysql_fetch_assoc($res["sel"]);
	if(file_exists($diretorio . $res["video"]))
	{
	    @unlink($diretorio . $res["video"]);
	}
	if(file_exists($diretorio . $res["foto"]))
	{
	    @unlink($diretorio . $res["foto"]);
	}
	$banco->setTabela("videos");
	$banco->setWhere("id = $id");
	if($banco->delete())
    	$res = array('error'=>0, 'message'=>array('Vídeo excluído com sucesso','success'));
  	else
		$res = array('error'=>1, 'message'=>array('Não foi possível fazer a exclusão do vídeo','danger'));
	echo json_encode($res);
}
?>