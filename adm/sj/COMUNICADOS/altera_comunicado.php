<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $comunicadoId  = getParam('iCom');
    $grupoId        = getParam('grupo_id');
    $titulo         = getParam('titulo');
    $data           = getParam('data');
    $hora           = getParam('hora');
    $descricao      = getParam('descricao');
    $texto          = getParam('texto');
    $notificacao    = getParam('notificacao');
    if ($comunicadoId && $titulo && $descricao):
      $data = explode('/', $data);
      $data = $data[2] . '-' . $data[1] . '-' . $data[0];
      $data = $data . ' ' . $hora;
      $res = mysql_query("UPDATE comunicados SET grupos_id = '$grupoId', titulo = '$titulo', descricao = '$descricao', data_2 = '$data', texto = '$texto' WHERE id = $comunicadoId") or die(mysql_error());
      if ($res):
        if($notificacao == 'S'):
          $msg = obterMensagem();
          $res = enviarNotificacao('Comunidade Jessênia - Atualização de comunicado', $msg['comunicado']['alterado'], $titulo, $comunicadoId, 'comunicados');
        endif;
        setFlashMessage('Comunicado alterado com sucesso!', 'success');
      else:
        setFlashMessage('Não foi possivel alterar o comunicado!', 'danger');
      endif;
    else:
      setFlashMessage('Deve ser informado o título e descrição!', 'warning');
    endif;
    echo redirect2('index.php?op=list_comu');
    exit;
  else:
    function messageComunicationInvalid()
    {
      setFlashMessage('Comunicado inválido!', 'danger');
      echo redirect2('index.php?op=list_comu');
      exit;
    }
    $comunicadoId = (int) getParam('op1');
    if ($comunicadoId):
      $res       = mysql_query("SELECT *, DATE_FORMAT(data_2, '%d/%m/%Y') AS data, DATE_FORMAT(data_2, '%H:%i') AS hora FROM comunicados where id = $comunicadoId");
      if (mysql_num_rows($res)):
        $ln = mysql_fetch_assoc($res);
      else:
        messageComunicationInvalid();
      endif;
    else:
      messageComunicationInvalid();
    endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Editar Comunicado</h2>
    </div>
<?php require 'COMUNICADOS/form.php';?>
<?php
  endif;
?>