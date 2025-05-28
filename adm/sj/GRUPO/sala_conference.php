<?php
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  
  if (getIdUsuario() > '3'):
      // $idLeituraTotal = $_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_le'];
	  // $query = mysql_query("SELECT s.*, DATE_FORMAT(data_inicio, '%H:%i') as data_ini FROM grupos gp INNER JOIN sala_conference s ON s.grupo_id = gp.id WHERE s.grupo_id IN (${idLeituraTotal})");
  	$gid_param=$_GET["iGrupo"];   
  	
	$query = mysql_query("SELECT s.*, DATE_FORMAT(data_inicio, '%H:%i') as data_ini FROM grupos gp INNER JOIN sala_conference s ON s.grupo_id = gp.id WHERE s.grupo_id=".$gid_param);
      $ln = mysql_fetch_assoc($query);

      $passPhrase = strtr(base64_encode($_SESSION['login']['nome'].' - '.$_SESSION['login']['cidade'].'-'.$_SESSION['login']['estado'].' - '.$_SERVER['REMOTE_ADDR'].':'.md5('').':'.md5( $ln['room_password'] ) ), '+/=', '-,');
      
      
      $redirectTo = 'http://www.hotconference.com/conference,' . $ln['room_id'] . '?AUTO' . $passPhrase;
      //$redirectTo = 'https://' . $ln['room_id'] . '.myownmeeting.net./conference?AUTO' . $passPhrase;
 
      // Redirecionamento novo (HTML5)
      // http://51334975.myownmeeting.net/
      // $redirectTo = 'http://'.$ln['romm_id'].'.myownmeeting.net/go.?'.$passPhrase;



      echo '<script>location.href="'.$redirectTo.'";</script>';

     
  endif; 
?>