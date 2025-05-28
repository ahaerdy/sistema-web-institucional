<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
    if(isPost()):
      $id_usuario   = $_SESSION['login']['admin']['id_usuarios'];
      $topicoId       = (int) getParam('topico');
      $titulo       = getParam('titulo');
      $descricao    = getParam('descricao');
      $data         = getParam('data');
      $hora         = getParam('hora');
      $publicado    = getParam('publicado');
      $notificacao  = getParam('notificacao');
      $data         = explode('/', $data);
      $data         = $data[2].'-'.$data[1].'-'.$data[0].' '.$hora;
    if($topicoId && $titulo):
     	mysql_query("INSERT INTO galerias_video ( id_topico, titulo, descricao, cadastro, id_usuario) values ('$topicoId','$titulo','$descricao', '$data', '$id_usuario')") or die (mysql_error());
    	$id_galeria = mysql_insert_id();
      if($id_galeria):
        mysql_query("UPDATE galerias_video SET diretorio = 'video_$id_galeria' WHERE id = $id_galeria") or die (mysql_error());
				$res = mysql_query("SELECT g.diretorio as d_grupo, g.id as grupo_id,  t.diretorio as d_topico, t.id as topico_id, a.diretorio as d_galeria, a.id as galeria_id FROM grupos  g, topicos t, galerias_video a WHERE a.id_topico = t.id AND t.id_grupo = g.id AND a.id = $id_galeria");
				if(mysql_num_rows($res)):
					$ln = mysql_fetch_assoc($res);
					chdir('../../../');
					if($ln["d_grupo"] && $ln["d_topico"] && $ln["d_galeria"]):
						$dir = getcwd() . "/arquivo_site/" . $ln["d_grupo"] . "/topicos/" . $ln["d_topico"] . "/videos/" . $ln["d_galeria"];
						$dir0 = mkdir($dir, 0777);
  					if($dir0):
              if($notificacao == 'S'):
                $msg = obterMensagem();
                $res = enviarNotificacao('Comunidade Jessênia - Nova galeria de vídeo publicada', $msg['galeria_video']['criado'], $titulo, $topicoId, 'galeria_video');
              endif;
	   					setFlashMessage('Galeria cadastrada com sucesso !', 'success');
              echo redirect2('index.php?op=carrega_video&grupo='.$ln["grupo_id"].'&topico='.$ln["topico_id"].'&galeria='.$ln["galeria_id"]);
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
    echo redirect2('index.php?op=lista_galeria_video');
    exit;
  else:
    $form = new formHelper();
?>

    <div class="page-header">

      <h2>Criar Galeria de Vídeo</h2>

    </div>

    <?php require 'GALERIA_VIDEO/form.php';?>

<?php

  endif;

?>