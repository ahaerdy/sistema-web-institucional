<?php
  $label = (empty($label))? '- Selecione o grupo -':$label;
  $field = (empty($field))? 'grupo' : $field;
  $value = (empty($value))? '' : $value;
  $form = new formHelper();
  $res = mysql_query("SELECT id, CONCAT ('(cod. ', id, ') ', nome) as nome FROM grupos WHERE id > 2 ORDER BY nome ASC");
  $rows = getDataFormSelect($res);
  echo $form->select($field, getParam($field, $value), $rows, $params,  $label);
?>