<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
    if(isPost()):
      $id_usuario = $_SESSION['login']['admin']['id_usuarios'];
      $topico     = (int)getParam('topico');
      $titulo     = getParam('titulo');
      $descricao = getParam('descricao');
      $data       = getParam('data');
      $hora       = getParam('hora');
      $data       = explode('/', $data);
      $data       = $data[2].'-'.$data[1].'-'.$data[0].' '.$hora;
    if($topico && $titulo):
      mysql_query("INSERT INTO galerias ( id_topico, titulo, descricao, cadastro, id_usuario) values ('$topico','$titulo','$descricao', '$data','$id_usuario')");
      $id_galeria = mysql_insert_id();
      if ($id_galeria):
        mysql_query("UPDATE galerias SET diretorio = 'foto_$id_galeria' WHERE id = $id_galeria");
        $res = mysql_query("SELECT g.diretorio as d_grupo, g.id as grupo_id,  t.diretorio as d_topico, t.id as topico_id, a.diretorio as d_galeria, a.id as galeria_id FROM grupos g, topicos t, galerias a WHERE a.id_topico = t.id AND t.id_grupo = g.id AND a.id = ${id_galeria}");
        if (mysql_num_rows($res)):
          $ln = mysql_fetch_assoc($res);
          chdir('../../../');
          if($ln["d_grupo"] && $ln["d_topico"] && $ln["d_galeria"]):
            $dir = getcwd()."/arquivo_site/".$ln["d_grupo"]."/topicos/".$ln["d_topico"]."/fotos/".$ln["d_galeria"];
            $dir0 = mkdir($dir, 0777);
            if($dir0):
              setFlashMessage('Galeria cadastrada com sucesso !', 'success');
              echo redirect2('index.php?op=carr_img&grupo='.$ln["grupo_id"].'&topico='.$ln["topico_id"].'&galeria='.$ln["galeria_id"]);
              exit;
            else:
              setFlashMessage('Galeria cadastrada com sucesso, porem não foi possível encontrar o diretorio do tópico, comunique o administrador!', 'warning');
            endif;
          else:
            setFlashMessage('Galeria cadastrada com sucesso, porem não foi possivel encontrar o diretorio do tópico, comunique o administrador!', 'warning');
          endif;
        else:
          setFlashMessage('Galeria cadastrada com sucesso, porem não foi possivel encontrar o diretorio do tópico, comunique o administrador!', 'warning');
        endif;
      else:
        setFlashMessage('Não foi possivel criar a galeria!', 'danger');
      endif;
    else:
      setFlashMessage('Informe o título para criar a galeria', 'warning');
    endif;
    echo redirect2('index.php?op=list_galer');
    exit;
  else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Galeria de Imagem</h2>
    </div>
    <?php require 'GALERIA_IMAGEM/form.php';?>
<?php
  endif;
?>