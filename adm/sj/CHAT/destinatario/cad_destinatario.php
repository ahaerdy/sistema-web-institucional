<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $category_id = (int)getParam('category_id');
    $usuario_id = (int)getParam('usuario_id');
    if($category_id && $usuario_id):
      $ins = mysql_query("INSERT INTO chats_categorias_x_usuarios (usuario_id, chat_categoria_id) values ($usuario_id, $category_id)") or die(mysql_error());
      if($ins)
        setFlashMessage('Destinatário cadastrado com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir o destinatário!', 'danger');
    else:
      setFlashMessage('Selecione o campos obrigatórios!', 'warning');
    endif;
    echo redirect2('index.php?op=lista_chat_destinatario');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Destinatário</h2>
    </div>
    <?php require 'CHAT/destinatario/form.php';?>
<?php
  endif;
?>