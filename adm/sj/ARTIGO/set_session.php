<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  require ("../../config.inc.php");
  Conectar ();

  $id = (int)getParam("id");

  if($id):
    chdir('../../../../');
    $res = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico FROM grupos g, topicos t WHERE t.id = " . (int)$_POST["id"] . ' AND g.id = t.id_grupo');
    if(mysql_num_rows($res)):
	    $ln  = mysql_fetch_assoc($res);
	    $_SESSION['KCFINDER'] = array();
	    $_SESSION['KCFINDER']['disabled']  = false;
	    $_SESSION['KCFINDER']['uploadURL'] = '/arquivo_site/'.$ln["grupo"].'/topicos/'.$ln["topico"].'/artigos/';
	    $_SESSION['KCFINDER']['uploadDir'] = getcwd().'/arquivo_site/'.$ln["grupo"].'/topicos/'.$ln["topico"].'/artigos/';
	    $_SESSION['KCFINDER']['dirPerms']  = 0777;
	    $_SESSION['KCFINDER']['filePerms'] = 0644;
    	echo json_encode(array('erro'=>0));
    else:
    	echo json_encode(array('erro'=>1));
    endif;
  endif;
endif;
?>