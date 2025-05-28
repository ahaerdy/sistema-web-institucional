<?php
  $form = new formHelper();
  $res = mysql_query("SELECT id, nome FROM usuarios ORDER BY nome ASC") or die(mysql_error());
  $rows = getDataFormSelect($res);
  echo $form->select('usuario_id', getParam('usuario_id'), $rows, array('class'=>"form-control"),  '- Selecione o usuário -' );
?>