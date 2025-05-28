<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $grupo      = (int) getParam('grupo');
    $titulo     = getParam('titulo');
    $descricao  = getParam('descricao');
    $ordem      = (int) getParam('ordem');
    $bloqueia_select  = getParam('bloqueia_select');
    $escalonamento_id = (int) getParam('escalonamento_id');
    $escalonamento_id = (empty($escalonamento_id))?'NULL':$escalonamento_id;
    if(!empty($titulo) && !empty($grupo)):
      $res = mysql_query("INSERT INTO escalonamentos (escalonamento_id, grupo_id, titulo, descricao, ordem,bloqueia_select_grupos) values ($escalonamento_id, $grupo, '$titulo', '$descricao', $ordem,'$bloqueia_select')") or die (mysql_error());
      if($res):
        setFlashMessage('Escalonamento cadastrado com sucesso!', 'success');
      else:
        setFlashMessage('Não foi possivel criar o escalonamento, comunique o administrador', 'danger');
      endif;
    else:
      setFlashMessage('Informe o título ou grupo para criar o escalonamento', 'warning');
    endif;
    echo redirect2('index.php?op=lista_escalonamento_filho');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Escalonamento Filho</h2>
    </div>
    <?php require 'ESCALONAMENTO/escalonamento_filho/form.php';?>
<?php
  endif;
?>