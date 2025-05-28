<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $categoriaId = (int)getParam('id');
    $categoria = getParam('categoria');
    if(!empty($categoria)):
      $update = mysql_query("UPDATE chats_categorias SET categoria = '${categoria}' WHERE id = '${categoriaId}'");
      if($update)
        setFlashMessage('Categoria alterada com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir a categoria!', 'danger');
    else:
      setFlashMessage('Digite a descrição!', 'warning');
    endif;
    echo redirect2('index.php?op=lista_chat_categoria');
    exit;
  else:
    function messageCategoryInvalid()
    {
      setFlashMessage('Categoria inválida!', 'danger');
      echo redirect2('index.php?op=lista_chat_categoria');
      exit;
    }
    $id = (int) getParam('op1');
    if($id):
      $res = mysql_query("SELECT * FROM chats_categorias WHERE id = ${id}");
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
      <h2>Alterar categoria</h2>
    </div>
    <?php require 'CHAT/categoria/form.php';?>
<?php
  endif;
?>