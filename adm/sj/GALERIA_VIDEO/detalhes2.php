<?php
session_start();

if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

if(!empty($_POST["id"]) && !empty($_POST["acao"]))
{
    $id   = (int) $_POST["id"];
    $acao = $_POST["acao"];
    
    require(getcwd() . "/classe_conexao/class.conexao.php");

    $banco = new conexao();
    $banco->setTabela("videos");
    $banco->setCampos("compartilhado = '$acao'");
    $banco->setWhere("id = '$id'");

    if($banco->alterar() == true)
    {
        echo 'ok';
    }
}
?>