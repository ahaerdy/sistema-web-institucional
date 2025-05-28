<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $id	          = (int) getParam('id');
    $id_grupo     = (int) getParam('id_grupo');
    $titulo       = getParam('titulo');
    $descricao    = getParam('descricao');
    $local        = getParam('local');
    $data         = getParam('data');
    $hora         = getParam('hora');
    $conteudo     = getParam('texto');
    $notificacao  = getParam('notificacao');

    if(!empty($titulo) && !empty($descricao) && !empty($local)):
      $data = explode('/', $data);
      $data = $data[2] . '-' . $data[1] . '-' . $data[0];
      $data = $data . ' ' . $hora;
      if(mysql_query("UPDATE eventos SET id_grupo = '$id_grupo', titulo = '$titulo', descricao = '$descricao', local = '$local', dia = '$data', texto = '$conteudo' WHERE id = '${id}'")):
        if($notificacao == 'S'):
          $msg = obterMensagem();
          $res = enviarNotificacao('Comunidade Jessênia - Atualização de evento', $msg['evento']['alterado'], $titulo, $id, 'eventos');
        endif;
        setFlashMessage('Evento alterado com sucesso!', 'success');
      else:
        setFlashMessage('Não foi possivel alterar o evento!', 'danger');
      endif;
    else:
      setFlashMessage('Deve ser informado o nome, descrição e data!', 'warning');
    endif;

    echo redirect2('index.php?op=list_event');
    exit;
  else:
    function messageEventInvalid()
    {
      setFlashMessage('Evento inválido!', 'danger');
      echo redirect2('index.php?op=list_event');
      exit;
    }
    $id_evento = (int)getParam('op1');
    if ($id_evento):
      $res   = mysql_query("SELECT *, DATE_FORMAT(dia, '%d/%m/%Y') AS data, DATE_FORMAT(dia, '%H:%i') AS hora FROM eventos WHERE id = $id_evento");
      if (mysql_num_rows($res))
        $ln = mysql_fetch_assoc($res);
      else
        messageEventInvalid();
    else:
      messageEventInvalid();
    endif;
    $form = new formHelper();
?>
    <?php require 'EVENTOS/form.php';?>
<?php
  endif;
?>