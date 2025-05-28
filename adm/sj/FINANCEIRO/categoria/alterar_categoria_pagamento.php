<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $categoriId = (int)getParam('id');
    $nome = getParam('nome');
    if(!empty($nome)):
      $update = mysql_query("UPDATE categorias_pagamentos SET nome = '${nome}' WHERE id = '${categoriId}'");
      if($update)
        setFlashMessage('Categoria alterada com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir a categoria!', 'danger');
    else:
      setFlashMessage('Digite o nome da categoria!', 'warning');
    endif;
    echo redirect2('index.php?op=listar_categoria_pagamento');
    exit;
  else:
    function messageCategoryInvalid()
    {
      setFlashMessage('Categoria inválida!', 'danger');
      echo redirect2('index.php?op=listar_categoria_pagamento');
      exit;
    }
    $id = (int) getParam('op1');
    if($id):
      $res = mysql_query("SELECT * FROM categorias_pagamentos WHERE id = ${id}");
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
      <h2>Alterar Categoria de Pagamento</h2>
    </div>
    <?php require 'FINANCEIRO/categoria/form.php';?>
<?php
  endif;
?>