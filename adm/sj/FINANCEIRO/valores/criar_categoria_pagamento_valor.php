<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $category_id = (int)getParam('category_id');
    $valor  = getParam('valor');
    $valor = str_replace(',', '.', $valor);
    if(!empty($valor)):
      $ins = mysql_query("INSERT INTO categorias_pagamentos_valores (categoria_pagamento_id, valor) values ($category_id, '$valor')") or die(mysql_error());
      if($ins)
        setFlashMessage('Valor cadastrado com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir o valor!', 'danger');
    else:
      setFlashMessage('Digite o valor da categoria!', 'warning');
    endif;
    echo redirect2('index.php?op=listar_cat_pagamento_valor');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Valor Categoria de Pagamento</h2>
    </div>
    <?php require 'FINANCEIRO/valores/form.php';?>
<?php
  endif;
?>