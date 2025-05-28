<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $id_usuario = $_SESSION['login']['admin']['id_usuarios'];
    $descricao  = getParam('descricao');
    if(!empty($descricao)):
      $ins = mysql_query("INSERT INTO categorias (descricao) values ('$descricao')");
      if($ins)
        setFlashMessage('Evento cadastrado com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir a categoria!', 'danger');
    else:
      setFlashMessage('Digite a descrição!', 'warning');
    endif;
    echo redirect2('index.php?op=lis_categorias');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar categoria de livro</h2>
    </div>
    <?php require 'CATEGORIAS/form.php';?>
<?php
  endif;
?>