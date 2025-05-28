<?php
  $form = new formHelper();
  $res = mysql_query("SELECT id, titulo as nome FROM escalonamentos WHERE escalonamento_id IS NULL ORDER BY ordem ASC") or die(mysql_error());
  $rows = getDataFormSelect($res);
  echo $form->select('escalonamento_pai_id', $escalonamento_pai_id, $rows, $params,  '- Selecione o escalonamento pai -' );
?>