<?php
require_once "../includes/db/config.inc.php";
require_once "../includes/functions/functions.php";
if(isPost()):
  Conectar();
  switch(getParam('status')):
    case 'cancelar':
      $query = mysql_query('UPDATE pagamentos SET pagamento_status_id = 3 WHERE id = '.(int)getParam('pagamento_id')) or die(mysql_error());
      break;
    case 'baixa-manual':
      $query = mysql_query('UPDATE pagamentos SET pagamento_status_id = 1 WHERE id = '.(int)getParam('pagamento_id')) or die(mysql_error());
      break;
  endswitch;
  if($query)
    echo json_encode(array('erro'=>0));
  else
    echo json_encode(array('erro'=>1));
endif;