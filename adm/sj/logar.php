<?php
session_start();
require_once 'includes/db/config.inc.php';
require_once 'includes/functions/functions.php';

unset($_SESSION['login']);
$login = !empty($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;
$senha = !empty($_POST["senha"]) ? addslashes(trim($_POST["senha"])) : FALSE;
$login = preg_replace('/[^[a-z][A-Z][0-9]_]/', '', $login);
$senha = preg_replace('/[^[a-z][A-Z][0-9]_]/', '', $senha);
$login = anti_injection($login);
$senha = anti_injection($senha);
$ip_maquina = $_SERVER['REMOTE_ADDR'];

if (empty($login) || empty($senha)):
	setFlashMessage("Digite sua senha e login para acessar!", 'warning');
	echo redirect2('/adm/index.php');
	exit;
endif;
Conectar();
$tentativas = isBlocked();
$res = mysql_query("SELECT * FROM usuarios WHERE LOGIN = '$login' AND SENHA = '$senha' AND bloqueado != 'Sim'");

if (mysql_num_rows($res)):
	$ln = mysql_fetch_assoc($res);
	$id_usuario = $ln['id'];
	$grupo_home = $ln['grupo_home'];
	$email = $ln['email'];
	$menu = $ln['menu'];
	$categoria_pagamento_id = $ln['categoria_pagamento_id'];
	$_SESSION['login'] = $ln;
	$_SESSION['login']['categoria_pagamento_id'] = $categoria_pagamento_id;
	mysql_query("INSERT INTO `online` (`usuarios_id`, `timestamp`, `ip`) VALUES (${id_usuario}, NOW(), '" . $_SERVER['REMOTE_ADDR'] . "');") or die(mysql_error());
	if ($ln['id'] <= 3) $tipo = 'admin';
	else $tipo = 'usuario';
	include ('includes/functions/verifica_grupos.php');

	$url = $_SESSION['url_redirecionamento'];
	if(isset($url) && !empty($url)):
		unset($_SESSION['url_redirecionamento']);
		echo redirect2($url);
	else:
		echo redirect2('/adm/sj/index.php');
	endif;
	exit;
else:
	if ($tentativas > 5):
		$res = mysql_query("INSERT INTO bloqueio_ip (ip,username,password,bloqueado) VALUES ('$ip_maquina','$login','$senha','s')") or die(mysql_error());
		$Name = "Administrador";
		$email = "arthur.haerdy@gmail.com";
		$recipient = "arthur.haerdy@gmail.com";
		$mail_body = "O IP $ip_maquina foi bloqueado.";
		$subject = "Subject for reviever";
		$header = "From: " . $Name . " <" . $email . ">\r\n";
		mail($recipient, 'IP bloqueado (' . $_SERVER['HTTP_HOST'] . ')', $mail_body, $header);
		echo redirect2('/adm/index.php');
		exit;
	else:
		$res = mysql_query("INSERT INTO bloqueio_ip (ip,username,password,bloqueado) VALUES ('$ip_maquina','$login','$senha','n')") or die(mysql_error());
			setFlashMessage("O dados fornecidos estão incorretos!", 'danger'); 

		echo redirect2('/adm/index.php');
		exit;
	endif;
endif;
?>