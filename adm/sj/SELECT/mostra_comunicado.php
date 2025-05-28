<?php
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $iComunicado = (int) getParam('comunicado');
  if(empty($iComunicado)):
    require "partial/comunication/list_comunication.php";
  else:
  	$secao = $iComunicado;
  	$tipo = "COMUNICADO";
  	require "partial/save-view.php";
    require "partial/comunication/view_comunication.php";
    require "partial/comunication/others_comunication.php";
  endif;
?>