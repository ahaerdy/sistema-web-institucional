<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $valorId = (int)getParam('id');
    $valor  = getParam('valor');
    $valor = str_replace(',', '.', $valor);
    if(!empty($valor)):
      $update = mysql_query("UPDATE categorias_pagamentos_valores SET valor = '${valor}' WHERE id = '${valorId}'");
      if($update)
        setFlashMessage('Valor alterado com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel inserir o valor!', 'danger');
    else:
      setFlashMessage('Digite o valor da categoria!', 'warning');
    endif;
    echo redirect2('index.php?op=listar_cat_pagamento_valor');
    exit;
  else:
    function messageCategoryInvalid()
    {
      setFlashMessage('Valor inválida!', 'danger');
      echo redirect2('index.php?op=listar_cat_pagamento_valor');
      exit;
    }
    $id = (int) getParam('op1');
    if($id):
      $res = mysql_query("SELECT * FROM categorias_pagamentos_valores WHERE id = ${id}");
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
      <h2>Alterar Valor Categoria de Pagamento</h2>
    </div>
    <?php require 'FINANCEIRO/valores/form.php';?>
<?php
  endif;
?>