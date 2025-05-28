<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
	$id_cat = (int)getParam("op1");
	if($id_cat):
	  $res = mysql_query("DELETE FROM categorias_pagamentos_valores WHERE categoria_pagamento_id = '$id_cat'");
	  if($res && mysql_query("DELETE FROM categorias_pagamentos WHERE id = '$id_cat' LIMIT 1"))
	    setFlashMessage('Categoria excluída com sucesso!', 'success');
	  else
	    setFlashMessage('Não foi possível excluir a categoria, comunique o administrador!', 'warning');
	endif;
echo redirect2('index.php?op=listar_categoria_pagamento');
exit;
?>