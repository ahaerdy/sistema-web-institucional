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
	$res = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico FROM grupos g INNER JOIN topicos t ON g.id = t.id_grupo WHERE t.id = ${id}");
	if(mysql_num_rows($res)):
		$ln  = mysql_fetch_assoc($res);
		$_SESSION['KCFINDER'] = array();
		$_SESSION['KCFINDER']['disabled']  = false;
		$_SESSION['KCFINDER']['uploadURL'] = '/arquivo_site/'.$ln["grupo"].'/topicos/'.$ln["topico"].'/livros/';
		$_SESSION['KCFINDER']['uploadDir'] = getcwd().'/arquivo_site/'.$ln["grupo"].'/topicos/'.$ln["topico"].'/livros/';
		$_SESSION['KCFINDER']['dirPerms']  = 0777;
		$_SESSION['KCFINDER']['filePerms'] = 0644;
	else:
		$_SESSION['KCFINDER'] = array();
		$_SESSION['KCFINDER']['disabled']  = true;
	endif;
  endif;
endif;
?>