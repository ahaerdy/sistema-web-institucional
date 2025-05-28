<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $id_usuario = $_SESSION['login']['admin']['id_usuarios'];
    $categoria  = getParam('categoria');
    if(!empty($categoria)):
      $ins = mysql_query("INSERT INTO chats_categorias (categoria) values ('$categoria')");
      if($ins)
        setFlashMessage('Evento cadastrado com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir a categoria!', 'danger');
    else:
      setFlashMessage('Digite a descrição!', 'warning');
    endif;
    echo redirect2('index.php?op=lista_chat_categoria');
    eixt;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar categoria</h2>
    </div>
    <?php require 'CHAT/categoria/form.php';?>
<?php
  endif;
?>