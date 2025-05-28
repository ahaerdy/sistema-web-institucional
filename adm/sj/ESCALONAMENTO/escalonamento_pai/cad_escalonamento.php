<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $titulo     = getParam('titulo');
    $descricao  = getParam('descricao');
    if(!empty($titulo)):
      $res = mysql_query("INSERT INTO escalonamentos (escalonamento_id, grupo_id, titulo, descricao) values (NULL, NULL, '$titulo', '$descricao')") or die (mysql_error());
      if($res):
        setFlashMessage('Escalonamento cadastrado com sucesso!', 'success');
      else:
        setFlashMessage('Não foi possivel criar o escalonamento, comunique o administrador', 'danger');
      endif;
    else:
      setFlashMessage('Informe o título ou grupo para criar o escalonamento', 'warning');
    endif;
    echo redirect2('index.php?op=lista_escalonamento_pai');
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Escalonamento Pai</h2>
    </div>
    <?php require 'ESCALONAMENTO/escalonamento_pai/form.php';?>
<?php 
  endif;
?>