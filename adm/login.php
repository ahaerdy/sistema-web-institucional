<?php



session_start();



require('config.inc.php');







function anti_injection($campo, $adicionaBarras = false) {



		// remove palavras que contenham sintaxe sql



        $campo = preg_replace("/(from|alter table|select|insert|delete|update|



								where|drop table|show tables|innerjoin|#|\*|--|\\\\)/i","",$campo);



        $campo = trim($campo);//limpa espaços vazio



        $campo = strip_tags($campo);//tira tags html e php



        if($adicionaBarras || !get_magic_quotes_gpc())



			$campo = addslashes($campo);//Adiciona barras invertidas a uma string



        return $campo;



}







//-----------------------------------------------------------------------------------------------------------------------------------------







unset($_SESSION['login']);







//-----------------------------------------------------------------------------------------------------------------------------------------







$login = !empty($_POST["login"]) ? addslashes(trim($_POST["login"])) : FALSE;



$senha = !empty($_POST["senha"]) ? addslashes(trim($_POST["senha"])) : FALSE;



$login = preg_replace('/[^[a-z][A-Z][0-9]_]/', '',$login);



$senha = preg_replace('/[^[a-z][A-Z][0-9]_]/', '',$senha);



$login = anti_injection($login);



$senha = anti_injection($senha);







//-----------------------------------------------------------------------------------------------------------------------------------------







$ip_maquina = $_SERVER['REMOTE_ADDR'];







// Usuário não forneceu a senha ou o login



//-----------------------------------------------------------------------------------------------------------------------------------------







if(empty($login) || empty($senha)):



	echo '<script type="text/javascript">



        	alert("Digite sua senha e login para acessar!");



			var t = setTimeout("window.location.href=\'/adm/index.php\'", 1000);



		</script>';



    exit;



endif;



Conectar();



$res        = mysql_query("SELECT * FROM bloqueio_ip WHERE ip = '$ip_maquina' AND MONTH(data) = MONTH(NOW()) AND DAY(data) = DAY(NOW())");

$tentativas = mysql_num_rows($res);

echo $tentativas;

exit;

if($tentativas != 0)

{ 

	$ln = mysql_fetch_assoc($res);

	if($ln['bloqueado'] == 's')

	{

        echo '

			<script type="text/javascript">

       	      	alert("Seu IP encontra-se bloqueado! Entre em contato com o administrador.");

        	</script>

        ';

		exit;

	}

}



//-----------------------------------------------------------------------------------------------------------------------------------------



$res = mysql_query("SELECT id, grupo_home, menu, forum FROM usuarios WHERE LOGIN = '$login' AND SENHA = '$senha'");



if(mysql_num_rows($res))

{

    $ln = mysql_fetch_assoc($res);

    $id_usuario = $ln['id'];

    $grupo_home = $ln['grupo_home'];

    $menu 		= $ln['menu'];

	$forum 		= $ln['forum'];    

	$_SESSION['login']['nome'] = $login;
	$_SESSION['login']['menu'] = $menu;
	$_SESSION['login']['forum'] = $forum;

	mysql_query("INSERT INTO `online` (`usuarios_id`, `timestamp`, `ip`) VALUES (${id_usuario}, NOW(), '".$_SERVER['REMOTE_ADDR']."');")  or die (mysql_error());

    if($ln['id'] <= 2)

        $tipo = 'admin';

    else

        $tipo = 'usuario';

	include('verifica_grupos.php');

	echo("<script>window.location.href='sj/index.php';</script>");

	exit;

}

else

{

	if($tentativas >= 1)

	{

		$res = mysql_query("INSERT INTO bloqueio_ip (ip,username,password,bloqueado) VALUES ('$ip_maquina','$login','$senha','s')")  or die (mysql_error());

		$Name      = "Administrador";

		$email     = "arthur.haerdy@gmail.com";

		$recipient = "arthur.haerdy@gmail.com";

		$mail_body = "O IP $ip_maquina foi bloqueado.";

		$subject   = "Subject for reviever";

		$header    = "From: ". $Name . " <" . $email . ">\r\n";

		mail($recipient, 'IP bloqueado ('.$_SERVER['HTTP_HOST'].')', $mail_body, $header);

		echo '

			<script type="text/javascript">

        	    alert("Seu IP foi bloqueado em nosso sistema por ter efetuado várias tentativas. Entre em contato com o administrador.");

        	</script>

        ';

		exit;

	}

	else

	{

		$res = mysql_query("INSERT INTO bloqueio_ip (ip,username,password,bloqueado) VALUES ('$ip_maquina','$login','$senha','n')")  or die (mysql_error());

		echo '

			<script type="text/javascript">

       	      	alert("O dados fornecidos estão incorretos!");

       	      	var t = setTimeout("window.location.href=\"index.php\"", 1000);

        	</script>

        ';

		exit;

	}

}

?>