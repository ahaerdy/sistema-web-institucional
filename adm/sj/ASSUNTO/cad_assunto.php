<?php

	if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

	if(isPost()):

    $id_usuario = $_SESSION['login']['admin']['id_usuarios'];

    $titulo 		= addslashes($_POST['titulo']);

    $grupo			= (int) $_POST['grupo'];

    $data       = explode('/', $_POST['data']);

    $cadastro   = $data[2].'-'.$data[1].'-'.$data[0].' '.$_POST['hora'];

    if(!empty($titulo) && !empty($grupo)):

			mysql_query("INSERT INTO topicos (id_topico, id_grupo, nome, id_usuario, cadastro) values (0,'$grupo','$titulo','$id_usuario','$cadastro')") or die (mysql_error());

			$id_topico = mysql_insert_id();

			if($id_topico):

				mysql_query("UPDATE topicos SET diretorio = 'topico_$id_topico' WHERE id = $id_topico") or die (mysql_error());

        $res = mysql_query("SELECT diretorio FROM grupos WHERE id = $grupo"); 

        if (mysql_num_rows($res)):

          $ln = mysql_fetch_assoc($res);

          chdir('../../../');

          $dir = getcwd()."/arquivo_site/".$ln["diretorio"];

          if(file_exists($dir)):
            $dir0 = mkdir($dir."/topicos/topico_$id_topico"               , 0777);
            $dir1 = mkdir($dir."/topicos/topico_$id_topico/artigos"       , 0777);
            $dir2 = mkdir($dir."/topicos/topico_$id_topico/artigos/audio" , 0777);
            $dir3 = mkdir($dir."/topicos/topico_$id_topico/videos"        , 0777);
            $dir4 = mkdir($dir."/topicos/topico_$id_topico/fotos"         , 0777);
            $dir5 = mkdir($dir."/topicos/topico_$id_topico/livros"        , 0777);
            if($dir0 && $dir1 && $dir2 && $dir3 && $dir4 && $dir5)
          		setFlashMessage('Assunto cadastrado com sucesso!', 'success');
          	else
          		setFlashMessage('Assunto cadastrado com sucesso, porem não foi possível criar os diretório do assunto, comunique o administrador!', 'warning');
        	else:
         		setFlashMessage('Assunto cadastrado com sucesso, porem não foi possível criar os diretório do grupo, comunique o administrador!', 'warning');
          endif;
        else:
       		setFlashMessage('Assunto cadastrado com sucesso, porem não foi possível encontrar os diretório do grupo, comunique o administrador!', 'warning');
        endif;
      else:
     	  setFlashMessage('Não foi possivel criar o assunto, comunique o administrador', 'danger');
      endif;
    else:
			setFlashMessage('Informe o título ou grupo para criar o assunto', 'warning');
    endif;
    echo redirect2('index.php?op=lista_assunto');
	else:

    $form = new formHelper();

?>

    <div class="page-header">

      <h2>Criar Assunto</h2>

    </div>

    <?php require 'ASSUNTO/form.php';?>

<?php 

  endif;

?>