<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $galeriaId      = getParam('id');
    $titulo         = getParam('titulo');
    $descricao      = getParam('descricao');
    $id_grupo       = getParam('grupo');
    $data           = getParam('data');
    $hora           = getParam('hora');
    $notificacao    = getParam('notificacao');
    $data           = explode('/', $data);
    $data           = $data[2].'-'.$data[1].'-'.$data[0] . ' ' . $hora;
    $cadastro       = getParam('grupos_cadastrados');
    $cod_cadastro   = explode ("=", $cadastro);
    for($a = 0; $a < sizeof($cod_cadastro); $a++):
      if($ver1 ==""):
        $cad = $cod_cadastro[0];
        $ver1="0";
      endif;
    endfor;

    $res = mysql_query("UPDATE galerias SET titulo = '$titulo', descricao = '$descricao', cadastro = '$data' WHERE id = '$galeriaId'") or die (mysql_error());
    if($res):
      if($notificacao == 'S'):
        $msg = obterMensagem();
        $res = enviarNotificacao('Comunidade Jessênia - Atualização de comunicado', $msg['comunicado']['alterado'], $titulo, $galeriaId, 'comunicados');
      endif;
      setFlashMessage('Galeria alterada com sucesso!', 'success');
    else:
      setFlashMessage('Não foi possível alterar o grupo comunique o administrador!', 'danger');
    endif;
    echo redirect2('index.php?op=list_galer');
    exit;
  else:
    function messageGalleryInvalid()
    {
      setFlashMessage('Galeria inválida!', 'danger');
      echo redirect2('index.php?op=list_galer');
      exit;
    }
    $galeriaId  = (int)getParam("op1");
    if($galeriaId):
      $res = mysql_query("SELECT *, DATE_FORMAT(cadastro, '%d/%m/%Y') as data, DATE_FORMAT(cadastro, '%H:%i') as hora FROM galerias WHERE id='$galeriaId'");
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
      <h2>Editar Galeria de Imagem</h2>
    </div>
    <?php require 'GALERIA_IMAGEM/form.php';?>
<?php
  endif;
?>