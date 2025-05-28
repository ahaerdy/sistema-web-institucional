<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $nome  = getParam('nome');
    if(!empty($nome)):
      $ins = mysql_query("INSERT INTO categorias_pagamentos (nome) values ('$nome')");
      if($ins)
        setFlashMessage('Categoria cadastrado com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir a categoria!', 'danger');
    else:
      setFlashMessage('Digite o nome da categoria!', 'warning');
    endif;
    echo redirect2('index.php?op=listar_categoria_pagamento');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Categoria de Pagamento</h2>
    </div>
    <?php require 'FINANCEIRO/categoria/form.php';?>
<?php
  endif;
?>