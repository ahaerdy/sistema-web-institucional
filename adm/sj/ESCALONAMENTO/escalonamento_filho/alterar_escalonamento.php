<?php
	if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
	if(isPost()):
    $idEscalonamento  = (int) getParam('id');
    $grupo            = (int) getParam('grupo');
    $grupo_ant_id     = (int) getParam('grupo_ant_id');
    $escalonamento_id = (int) getParam('escalonamento_id');
    $escalonamento_id = (empty($escalonamento_id))?'NULL':$escalonamento_id;
    $titulo           = getParam('titulo');
    $descricao        = getParam('descricao');
    $ordem			      = (int) getParam('ordem');
    $bloqueia_select  = getParam('bloqueia_select');
    if(!empty($titulo) && !empty($grupo)):
			$res = mysql_query("UPDATE escalonamentos SET escalonamento_id = $escalonamento_id, grupo_id = $grupo, titulo = '$titulo', descricao = '$descricao', ordem = $ordem, bloqueia_select_grupos = '$bloqueia_select' WHERE id = $idEscalonamento") or die (mysql_error());
			if($res):
        if($grupo_ant_id != $grupo):
          setNovoGrupoEscalonamento($idEscalonamento, $grupo, $grupo_ant_id);
        endif;
     		setFlashMessage('Escalonamento alterado com sucesso!', 'success');
      else:
     	  setFlashMessage('Não foi possivel criar o escalonamento, comunique o administrador', 'danger');
      endif;
    else:
			setFlashMessage('Informe o título ou grupo para criar o escalonamento', 'warning');
    endif;
    echo redirect2('index.php?op=lista_escalonamento_filho');
	else:
    function messageSubjectInvalid()
    {
      setFlashMessage('Escalonamento inválido!', 'danger');
      echo redirect2('index.php?op=lista_escalonamento_filho');
      exit;
    }
    $idEscalonamento = (int) getParam("op1");
    if ($idEscalonamento):
      $res = mysql_query("SELECT e.*, g.id as grupo_id FROM grupos g INNER JOIN escalonamentos e ON e.grupo_id = g.id WHERE e.id = " . $idEscalonamento) or die(mysql_error());
      if (mysql_num_rows($res))
        $ln = mysql_fetch_assoc($res);
      else
        messageSubjectInvalid();
    else:
      messageSubjectInvalid();
    endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Alterar Escalonamento Filho</h2>
    </div>
    <?php require 'ESCALONAMENTO/escalonamento_filho/form.php';?>
<?php 
  endif;
?>