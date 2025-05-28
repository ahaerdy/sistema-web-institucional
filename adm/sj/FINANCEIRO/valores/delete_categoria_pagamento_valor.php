<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
$id = (int)getParam("op1");
if($id):
  if($res && mysql_query("DELETE FROM categorias_pagamentos_valores WHERE id = '$id' LIMIT 1"))
    setFlashMessage('Valor excluído com sucesso!', 'success');
  else
    setFlashMessage('Não foi possível excluir o valor, comunique o administrador!', 'warning');
endif;
echo redirect2('index.php?op=listar_cat_pagamento_valor');
exit;
?>