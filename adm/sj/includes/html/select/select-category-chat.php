<?php
  $value = (empty($value))? '' : $value;
  $form = new formHelper();
  $res = mysql_query("SELECT id, categoria FROM chats_categorias ORDER BY categoria ASC") or die(mysql_error());
  $rows = getDataFormSelect($res, array('id', 'categoria'));
  echo $form->select($categoria, $ln['categoria_id'], $rows, $params,  '- Selecione -' );
?>