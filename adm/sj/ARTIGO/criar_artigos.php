<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $id_usuario = $_SESSION['login']['admin']['id_usuarios'];
    $titulo     = getParam('titulo');
    $topico     = (int)getParam('topico');
    $conteudo   = getParam('texto');
    $conteudo2  = trim(strip_tags(str_replace(array('&#160;', '  ', '   '), '', getParam('texto'))));
    $conteudo2=stripslashes($conteudo2);
    $data       = getParam('data');
    $hora       = getParam('hora');
    $publicado  = getParam('publicado');
    $notificacao  = getParam('notificacao');
    $data       = explode('/', $data);
    $data       = $data[2].'-'.$data[1].'-'.$data[0] . ' ' . $hora;
    if(!empty($topico) && !empty($titulo)):
      $res = mysql_query("INSERT INTO artigos (usuarios_id, titulo, texto, texto_pesquisa, situacao, cadastro, id_topico) VALUES ('$id_usuario','$titulo','$conteudo','$conteudo2','$situacao','$data','$topico')")  or die (mysql_error());
      $id_artigo = mysql_insert_id();
      if($id_artigo):
        mysql_query("UPDATE artigos SET diretorio = 'artigo_$id_artigo' WHERE id = $id_artigo") or die (mysql_error());
        $res = mysql_query("SELECT g.diretorio as d_grupo, t.diretorio as d_topico, a.diretorio as d_artigo FROM grupos  g, topicos t, artigos a WHERE a.id_topico = t.id AND t.id_grupo = g.id AND a.id = $id_artigo") or die (mysql_error());
        if(mysql_num_rows($res)):
          $ln = mysql_fetch_assoc($res);
          chdir('../../../');
          if($ln["d_grupo"] && $ln["d_topico"] && $ln["d_artigo"]):
            $dir = getcwd() . "/arquivo_site/" . $ln["d_grupo"] . "/topicos/" . $ln["d_topico"] . "/artigos/" . $ln["d_artigo"];
            $dir0 = mkdir($dir, 0777);
            if($dir0):
              if(!empty($_FILES['capa']['name'])):
                $nome = substr($_FILES['capa']['name'], 0, -4);
                $ext  = substr($_FILES['capa']['name'], -4);
                $foto = $nome . '@' . $id_artigo . $ext;
                $path = $dir . '/' . $foto; 
                if(move_uploaded_file($_FILES['capa']['tmp_name'], $path))
                  mysql_query("UPDATE artigos SET capa = '$foto' WHERE id = $id_artigo");
              endif;
              if($notificacao == 'S'):
                $msg = obterMensagem();
                $res = enviarNotificacao('Comunidade Jessênia - Novo artigo publicado', $msg['artigo']['criado'], $titulo, $id_artigo, 'artigos');
              endif;
              setFlashMessage('Artigo cadastrado com sucesso !', 'success');
            else:
              setFlashMessage('Artigo cadastrado com sucesso, porem não foi possível criar os diretorio do tópico, comunique o administrador!', 'warning');
            endif;
          else:
            setFlashMessage('Artigo cadastrado com sucesso, porem não foi possivel criar os diretorio do tópico, comunique o administrador!', 'warning');
          endif;
        else:
          setFlashMessage('Artigo cadastrado com sucesso, porem não foi possivel criar os diretorio do tópico, comunique o administrador!', 'warning');
        endif;
      else:
        setFlashMessage('Não foi possivel criar o artigo!', 'danger');
      endif;
    else:
      setFlashMessage('Informe o titulo para criar o artigo', 'warning');
    endif;

    echo redirect2('index.php?op=list_art');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Artigo</h2>
    </div>
    <?php require 'ARTIGO/form.php';?>
<?php
  endif;
?>
?>