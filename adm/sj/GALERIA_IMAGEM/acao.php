<?php
session_start();
if (empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])) {
    echo 'Acesso negado!';
    exit;
}
require '../includes/functions/functions.php';
if (isXmlHttpRequest() && isPost()):
    require("../../config.inc.php");
    Conectar();
    $id = (int) getParam("id");
    $tp = getParam('tp');
    $ac = getParam('ac');
    switch ($tp) {
        case 'hm':
            $campo = "home 	 		= '${ac}'";
            break;
        case 'cp':
            $campo = "compartilhado = '${ac}'";
            break;
        case 'at':
            $campo = "ativo 	 	= '${ac}'";
            break;
    }
    if (mysql_query("UPDATE galerias SET $campo WHERE id = ${id}"))
        echo json_encode(array(
            'erro' => 0
        ));
    else
        echo json_encode(array(
            'erro' => 1
        ));
endif;
?>