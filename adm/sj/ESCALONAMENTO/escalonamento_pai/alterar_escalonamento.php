<?php
	if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
	if(isPost()):
    $idEscalonamento  = (int) getParam('id');
    $titulo           = getParam('titulo');
    $descricao        = getParam('descricao');
    if(!empty($titulo)):
			$res = mysql_query("UPDATE escalonamentos SET titulo = '$titulo', descricao = '$descricao' WHERE id = $idEscalonamento") or die (mysql_error());
			if($res):
     		setFlashMessage('Escalonamento alterado com sucesso!', 'success');
      else:
     	  setFlashMessage('Não foi possivel criar o escalonamento, comunique o administrador', 'danger');
      endif;
    else:
			setFlashMessage('Informe o título para alterar o escalonamento', 'warning');
    endif;
    echo redirect2('index.php?op=lista_escalonamento_pai');
    exit;
	else:
    function messageSubjectInvalid()
    {
      setFlashMessage('Escalonamento inválido!', 'danger');
      echo redirect2('index.php?op=lista_escalonamento_pai');
      exit;
    }
    $idEscalonamento = (int) getParam("op1");
    if ($idEscalonamento):
      $res = mysql_query("SELECT * FROM escalonamentos WHERE id = " . $idEscalonamento) or die(mysql_error());
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
      <h2>Alterar Escalonamento Pai</h2>
    </div>
    <?php require 'ESCALONAMENTO/escalonamento_pai/form.php';?>
<?php 
  endif;
?>