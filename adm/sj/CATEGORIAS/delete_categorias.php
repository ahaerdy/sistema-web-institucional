<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
$id_cat   = (int)getParam("op1");
if($id_cat):
  if(mysql_query("DELETE FROM categorias  WHERE id = '$id_cat' LIMIT 1"))
    setFlashMessage('Categoria excluída com sucesso!', 'success');
  else
    setFlashMessage('Não foi possível excluir a categoria, comunique o administrador!', 'warning');
endif;
echo redirect2('index.php?op=lis_categorias');
exit;
?>