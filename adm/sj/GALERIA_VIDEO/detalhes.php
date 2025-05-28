<?php
session_start();

if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

if(!empty($_POST["id"]))
{
    $id    = (int) $_POST["id"];
    $texto = ($_POST["texto"]);

    require(getcwd() . "/classe_conexao/class.conexao.php");

    $banco = new conexao();
    $banco->setTabela("videos");
    $banco->setCampos("comentario = '$texto'");
    $banco->setWhere("id = '$id'");
    $sel = $banco->alterar();
    
    if($banco->alterar())
    {
		$res['erro'] 	= 0;
		$res['msg'] 	= 'Comentário salvo com sucesso!'; 
    }
	else
	{
		$res['erro'] 	= 1;
		$res['msg'] 	= 'Não foi possível salvar o comentário';
	}
	
	echo json_encode($res);
}
else
{
	$res['erro'] 	= 1;
	$res['msg'] 	= 'Não foi possível salvar o comentário';
	
	echo json_encode($res);
}
?>