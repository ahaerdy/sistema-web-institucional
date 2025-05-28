<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $titulo       = getParam('titulo');
    $descricao    = getParam('descricao');
    $local        = getParam('local');
    $data         = getParam('data');
    $hora         = getParam('hora');
    $conteudo     = getParam('texto');
    $id_grupo     = getParam('id_grupo');
    $notificacao  = getParam('notificacao');
    $situacao   = 'A'; // em EDICAO
    if($titulo != "" && $descricao != "" && $local != ""):
      $data = str_replace('/', '-', $data);
      $ins = mysql_query("INSERT INTO eventos (id_grupo, id_usuario, titulo, local, descricao, texto, dia, cadastro, situacao) 
                          VALUES ('$id_grupo','$id_usuario','$titulo','$local','$descricao','$conteudo',STR_TO_DATE('$data $hora', '%d-%m-%Y %H:%i'),NOW(),'E')") or die(mysql_error());
      if($ins):
        $id = mysql_insert_id();
        if($notificacao == 'S'):
          $msg = obterMensagem();
          $res = enviarNotificacao('Comunidade Jessênia - Novo evento publicado', $msg['evento']['criado'], $titulo, $id, 'eventos');
        endif;
        setFlashMessage('Evento cadastrado com sucesso!', 'success');
      else:
        setFlashMessage('Não foi possivel inserir o evento!', 'danger');
      endif;
    else:
      setFlashMessage('Digite o titulo, descricao e data!', 'warning');
    endif;
    echo redirect2('index.php?op=list_event');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Evento</h2>
    </div>
    <?php require 'EVENTOS/form.php';?>
<?php
  endif;
?>