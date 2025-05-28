<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $id = (int) getParam('op1');
  if(isPost()):
    $category_id = (int)getParam('category_id');
    $usuario_id = (int)getParam('usuario_id');
    if($id && $category_id && $usuario_id):
      mysql_query("DELETE FROM chats_categorias_x_usuarios WHERE usuario_id = ${id}");
      $ins = mysql_query("INSERT INTO chats_categorias_x_usuarios (usuario_id, chat_categoria_id) values ($usuario_id, $category_id)") or die(mysql_error());
      if($ins)
        setFlashMessage('Destinatário alterado com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir o destinatário!', 'danger');
    else:
      setFlashMessage('Selecione o campos obrigatórios!', 'warning');
    endif;
    echo redirect2('index.php?op=lista_chat_destinatario');
    exit;
  else:
    function messageCategoryInvalid()
    {
      setFlashMessage('Destinatário inválido!', 'danger');
      echo redirect2('index.php?op=lista_chat_destinatario');
      exit;
    }
    if($id):
      $res = mysql_query("SELECT * FROM chats_categorias_x_usuarios WHERE usuario_id = ${id}");
      if(mysql_num_rows($res))
        $ln  = mysql_fetch_assoc($res);
      else
        messageCategoryInvalid();
    else:
      messageCategoryInvalid();
    endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Alterar Destinatário</h2>
    </div>
    <?php require 'CHAT/destinatario/form.php';?>
<?php
  endif;
?>