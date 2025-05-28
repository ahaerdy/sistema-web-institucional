<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $id_artigo = (int)getParam('artigo');
    $topico = (int)getParam('topico');
    $titulo = (getParam('titulo'));
    $conteudo = (getParam('texto'));
    $conteudo2 = trim(strip_tags(str_replace(array('&#160;','  ','   ') , '', (getParam('texto')))));
    $conteudo2=stripslashes($conteudo2);
    $data = getParam('data');
    $hora = getParam('hora');
    $notificacao = getParam('notificacao');
    $data = explode('/', $data);
    $data = $data[2] . '-' . $data[1] . '-' . $data[0] . ' ' . $hora;
    if($topico && !empty($titulo) && !empty($id_artigo)):
      $res = mysql_query("UPDATE artigos SET id_topico = '$topico', titulo = '$titulo', texto = '$conteudo', texto_pesquisa = '$conteudo2', cadastro = '$data' WHERE id = $id_artigo");
      if($res):
        $res = mysql_query("SELECT t.diretorio as d_topico, g.diretorio as d_grupo, a.diretorio as d_artigo FROM grupos g, topicos t, artigos a WHERE t.id_grupo = g.id AND t.id = a.id_topico AND a.id = $id_artigo");
        if(mysql_num_rows($res)):
          $ln = mysql_fetch_assoc($res);
          chdir('../../../');
          if($ln["d_grupo"] && $ln["d_topico"] && $ln["d_artigo"]):
            $dir = getcwd() . "/arquivo_site/" . $ln["d_grupo"] . "/topicos/" . $ln["d_topico"] . "/artigos/" . $ln["d_artigo"];
            if(!file_exists($dir))
              @mkdir($dir, 0777);
            $excluirFoto = getParam('excluir-foto');
            if(isset($excluirFoto) && $excluirFoto == 'S'):
              $res = mysql_query("SELECT capa FROM artigos WHERE id = $id_artigo");
              $ln = mysql_fetch_assoc($res);
              if (file_exists($dir . '/' . $ln['capa']))
                unlink($dir . '/' . $ln['capa']);
              mysql_query("UPDATE artigos SET capa = '' WHERE id = $id_artigo");
            endif;
            if (!empty($_FILES['capa']['name'])):
              $res = mysql_query("SELECT capa FROM artigos WHERE id = $id_artigo");
              $ln = mysql_fetch_assoc($res);
              if (!empty($ln['capa']) && file_exists($dir . '/' . $ln['capa']))
                unlink($dir . '/' . $ln['capa']);
              $nome = substr($_FILES['capa']['name'], 0, -4);
              $ext = substr($_FILES['capa']['name'], -4);
              $foto = $nome . '@' . $id_artigo . $ext;
              $path = $dir . '/' . $foto;
              if (move_uploaded_file($_FILES['capa']['tmp_name'], $path))
                mysql_query("UPDATE artigos SET capa = '$foto' WHERE id = $id_artigo");
            endif;
          endif;
          if($notificacao == 'S'):
            $msg = obterMensagem();
            $res = enviarNotificacao('Comunidade Jessênia - Atualização de artigo', $msg['artigo']['alterado'], $titulo, $id_artigo, 'artigos');
          endif;
          if($res):
            setFlashMessage('Artigo alterado com sucesso!', 'success');
          endif;
        else:
          setFlashMessage('Artigo alterado com sucesso, porem não foi possivel criar os diretorio do tópico, comunique o administrador!', 'warning');
        endif;
      else:
        setFlashMessage('Não foi possível alterar o artigo!', 'danger');
      endif;
    else:
      setFlashMessage('Informe o título do tópico!', 'warning');
    endif;

    $edit = getParam('edit');
    if($edit == 'S')
      echo redirect2('index.php?op=alte_art&grupo='.(int)getParam('grupo').'&topico='.(int)getParam('topico').'&op1='.(int)getParam('artigo'));
    else
      echo redirect2('index.php?op=list_art');
    exit;
  else:
    function messageArticleInvalid()
    {
      setFlashMessage('Assunto inválido!', 'danger');
      echo redirect2('index.php?op=list_art');
      exit;
    }
    $id_artigo = (int)getParam('op1');
    if ($id_artigo):
      $res = mysql_query("SELECT a.*, t.diretorio as d_topico, g.diretorio as d_grupo, a.diretorio as d_artigo, DATE_FORMAT(a.cadastro, '%d/%m/%Y') as data, DATE_FORMAT(a.cadastro, '%H:%i') as hora, CONCAT('/arquivo_site/',g.diretorio,'/topicos/',t.diretorio,'/artigos/',a.diretorio,'/',a.capa) as foto
                          FROM grupos  g, topicos t, artigos a 
                          WHERE t.id_grupo = g.id AND t.id = a.id_topico AND a.id = $id_artigo");
      if (mysql_num_rows($res))
        $ln = mysql_fetch_assoc($res);
      else
        messageArticleInvalid();
    else:
      messageArticleInvalid();
    endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Alterar Artigo</h2>
    </div>
    <?php require 'ARTIGO/form.php';?>
<?php
  endif;
?>
