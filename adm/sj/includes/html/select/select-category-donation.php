<?php
  $value = (empty($value))? '' : $value;
  $form = new formHelper();
  $res = mysql_query("SELECT id, nome FROM categorias_pagamentos ORDER BY nome ASC");
  $rows = getDataFormSelect($res);
  echo $form->select($categoria_pagamento, getParam($categoria_pagamento, $value), $rows, $params,  '- Isento de pagamento -' );
?>