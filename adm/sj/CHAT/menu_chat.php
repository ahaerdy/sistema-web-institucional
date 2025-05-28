<?php 
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
?>
<div class="list-group">
  <a class="list-group-item <?=(getParam('op') == 'compor_mensagem')?'active':'';?>" href="/adm/sj/index.php?op=compor_mensagem">Compor mensagem <span class="glyphicon pull-right glyphicon-chevron-right"></span></a>
  <a class="list-group-item <?=(getParam('op') == 'caixa_entrada')?'active':'';?>" href="/adm/sj/index.php?op=caixa_entrada">Caixa de Entrada <?=($xMen)?'<span class="badge">'.$xMen.'</span>':'<span class="glyphicon pull-right glyphicon-chevron-right"></span>';?></a>
  <a class="list-group-item <?=(getParam('op') == 'caixa_saida')?'active':'';?>" href="/adm/sj/index.php?op=caixa_saida">Caixa de Saida <span class="glyphicon pull-right glyphicon-chevron-right"></span></a>
  <a class="list-group-item <?=(getParam('op') == 'mensagem_enviada')?'active':'';?>" href="/adm/sj/index.php?op=mensagem_enviada">Mensagens enviadas <span class="glyphicon pull-right glyphicon-chevron-right"></span></a>
</div>