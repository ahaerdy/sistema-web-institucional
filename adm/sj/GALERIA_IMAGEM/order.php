<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
$order = getParam("order");
if(!empty($order) && isXmlHttpRequest()):
  require("classe_conexao/class.conexao.php");
  foreach($order as $key => $value):
    ++$key;
    $banco = new conexao();
    $banco->setTabela("fotos");
    $banco->setCampos("ordem = '$key'");
    $banco->setWhere("id = '$value'");
    $banco->alterar();
  endforeach;
endif;
?>