<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $galeriaId   = getParam('id');
    $titulo      = getParam('titulo');
    $descricao   = getParam('descricao');
    $data        = getParam('data');
    $hora        = getParam('hora');
    $notificacao = getParam('notificacao');
    $data        = explode('/', $data);
    $data        = $data[2].'-'.$data[1].'-'.$data[0] . ' ' . $hora;

    $res = mysql_query("UPDATE galerias_video SET titulo = '$titulo', descricao = '$descricao', cadastro = '$data' WHERE id = '$galeriaId'") or die(mysql_error());
    if($res):
      if($notificacao == 'S'):
        $msg = obterMensagem();
        $res = enviarNotificacao('Comunidade Jessênia - Atualização galeria de vídeo publicada', $msg['galeria_video']['criado'], $titulo, $galeriaId, 'galeria_video');
      endif;
      setFlashMessage('Galeria alterada com sucesso!', 'success');
    else:
      setFlashMessage('Galeria não foi alterada, tente novamente!', 'danger');
    endif;
    echo redirect2('index.php?op=lista_galeria_video');
    exit;
  else:
    function messageGalleryInvalid()
    {
      setFlashMessage('Galeria inválida!', 'danger');
      echo redirect2('index.php?op=lista_galeria_video');
      exit;
    }
    $galeriaId  = (int)getParam("op1");
    if($galeriaId):
      $res = mysql_query("SELECT *, DATE_FORMAT(cadastro, '%d/%m/%Y') as data, DATE_FORMAT(cadastro, '%H:%i') as hora FROM galerias_video WHERE id = '$galeriaId'");
      if (mysql_num_rows($res)):
        $ln = mysql_fetch_assoc($res);
      else:
        messageGalleryInvalid();
      endif;
    else:
      messageGalleryInvalid();
    endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Editar Galeria de Vídeo</h2>
    </div>
    <?php require 'GALERIA_VIDEO/form.php';?>
<?php
  endif;