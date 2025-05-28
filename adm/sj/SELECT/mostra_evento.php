<?php
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $iEvento = (int) getParam('evento');
  if(empty($iEvento)):
    require "partial/event/list_event.php";
  else:
  	$secao = $iEvento;
  	$tipo = "EVENTO";
  	require "partial/save-view.php";
    require "partial/event/view_event.php";
    require "partial/event/others_event.php";
  endif;
?>