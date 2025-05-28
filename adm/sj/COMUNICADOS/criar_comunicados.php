<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $grupoId        = getParam('grupo_id');
    $titulo         = getParam('titulo');
    $descricao      = getParam('descricao');
    $conteudo       = getParam('texto');
    $data           = getParam('data');
    $hora           = getParam('hora');
    $notificacao    = getParam('notificacao');
    $id_usuario     = $_SESSION['login']['admin']['id_usuarios'];
    $situacao       = 'E';
    if ($titulo != "" && $descricao != "" && $grupoId != ""):
      $data = str_replace('/', '-', $data);
      $ins = mysql_query("INSERT INTO comunicados (grupos_id, titulo, descricao, data_2, cadastro, texto, id_usuario, situacao, diretorio) VALUES ('$grupoId','$titulo','$descricao',STR_TO_DATE('$data $hora', '%d-%m-%Y %H:%i'),NOW(),'$conteudo','$id_usuario','E','')") or die (mysql_error());
      if($ins):
        $id_comunicado = mysql_insert_id();
        if($notificacao == 'S'):
          $msg = obterMensagem();
          $res = enviarNotificacao('Comunidade Jessênia - Novo comunicado publicado', $msg['comunicado']['criado'], $titulo, $id_comunicado, 'comunicados');
        endif;
        setFlashMessage('Comunicado cadastrado com sucesso!', 'success');
      else:
        setFlashMessage('Não foi possivel cadastrar o comunicado!', 'danger');
      endif;
    else:
      setFlashMessage('Digite o titulo e a descrição!', 'warning');
    endif;
    echo redirect2('index.php?op=list_comu');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Comunicado</h2>
    </div>
<?php require 'COMUNICADOS/form.php';?>
<?php
  endif;
?>