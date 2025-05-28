<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
$id = (int)getParam("op1");
if($id):
  if($res && mysql_query("DELETE FROM chats_categorias_x_usuarios WHERE usuario_id = ${id}"))
    setFlashMessage('Destinatário excluído com sucesso!', 'success');
  else
    setFlashMessage('Não foi possível excluir o destinatário, comunique o administrador!', 'warning');
endif;
echo redirect2('index.php?op=lista_chat_destinatario');
exit;
?>