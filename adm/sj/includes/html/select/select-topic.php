<?php
  $form = new formHelper();
  $res = mysql_query("SELECT tp.id, tp.nome FROM grupos gp INNER JOIN topicos tp ON gp.id = tp.id_grupo INNER JOIN artigos at ON tp.id = at.id_topico GROUP By tp.id ORDER BY tp.nome ASC") or die(mysql_error());
  $rows = getDataFormSelect($res);
  echo $form->select('topico', getParam('topico'), $rows, array('class'=>"form-control"),  '- Selecione o tópico -' );
?>