<?php

	if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

	if(isPost()):

    $id_topico	= (int) $_POST['topico'];

    $titulo		  = addslashes($_POST['titulo']);

    $data       = explode('/', $_POST['data']);

    $cadastro   = $data[2].'-'.$data[1].'-'.$data[0].' '.$_POST['hora'];

    if(!empty($titulo) && !empty($id_topico)):

      $update = mysql_query("UPDATE topicos SET nome = '$titulo', cadastro = '$cadastro' WHERE id = $id_topico") or die (mysql_error());

			if($update):

       	$res = mysql_query("SELECT g.diretorio as grupoDir, t.diretorio as topicoDir FROM grupos g, topicos t WHERE t.id = $id_topico AND t.id_grupo = g.id");

       	if (mysql_num_rows($res)):

          $ln = mysql_fetch_assoc($res);

          chdir('../../../');

          $dir = getcwd()."/arquivo_site/".$ln["grupoDir"];

          if(file_exists($dir)):
          	if(!file_exists($dir."/topicos/".$ln["topicoDir"])				          ){ $dir0 = mkdir($dir."/topicos/".$ln["topicoDir"]				            , 0777); } else { $dir0 = 1; }
            if(!file_exists($dir."/topicos/".$ln["topicoDir"]."/artigos")       ){ $dir1 = mkdir($dir."/topicos/".$ln["topicoDir"]."/artigos"         , 0777); } else { $dir1 = 1; }
          	if(!file_exists($dir."/topicos/".$ln["topicoDir"]."/artigos/audio")	){ $dir2 = mkdir($dir."/topicos/".$ln["topicoDir"]."/artigos/audio"	  , 0777); } else { $dir2 = 1; }
          	if(!file_exists($dir."/topicos/".$ln["topicoDir"]."/videos") 	      ){ $dir3 = mkdir($dir."/topicos/".$ln["topicoDir"]."/videos"	        , 0777); } else { $dir3 = 1; }
          	if(!file_exists($dir."/topicos/".$ln["topicoDir"]."/fotos")         ){ $dir4 = mkdir($dir."/topicos/".$ln["topicoDir"]."/fotos"           , 0777); } else { $dir4 = 1; }
            if(!file_exists($dir."/topicos/".$ln["topicoDir"]."/livros")	      ){ $dir5 = mkdir($dir."/topicos/".$ln["topicoDir"]."/livros"          , 0777); } else { $dir5 = 1; }
          	if($dir0 && $dir1 && $dir2 && $dir3  && $dir4 && $dir5)
          		setFlashMessage('Tópico alterado com sucesso!', 'success');
          	else
          		setFlashMessage('Tópico alterado com sucesso, porem não foi possível criar os diretório do tópico, comunique o administrador!', 'warning');
        	else:
        		setFlashMessage('Tópico alterado com sucesso, porem não foi possível criar os diretório do tópico, comunique o administrador!', 'warning');
        	endif;
        else:
	        setFlashMessage('Tópico alterado com sucesso, porem não foi possível criar os diretório do tópico, comunique o administrador!', 'warning');
        endif;
      else:
        setFlashMessage('Não foi possivel alterar o tópico, comunique o administrador', 'danger');
      endif;
    else:
  		setFlashMessage('Informe o título para alterar o tópico', 'warning');
		endif;
    echo redirect2('index.php?op=list_top');
    exit;
	else:
    function messageTopicInvalid()
    {
      setFlashMessage('Tópico inválido!', 'danger');
      echo redirect2('index.php?op=list_top');
    }

		$id_topico = (int) getParam("op1");
		if($id_topico):
			$res = mysql_query("SELECT 
                            gp.nome as grupo, 
                            tp2.nome as topico,
                            tp1.*, 
                            DATE_FORMAT(tp1.cadastro, '%d/%m/%Y') as data, 
                            DATE_FORMAT(tp1.cadastro, '%H:%i') as hora 
                          FROM 
                            grupos gp 
                          INNER JOIN topicos tp1 ON tp1.id_grupo = gp.id
                          INNER JOIN topicos tp2 ON tp1.id_topico = tp2.id
                          WHERE tp1.id = ${id_topico}") or die(mysql_error());
			if(mysql_num_rows($res)):
				$ln = mysql_fetch_assoc($res);
			else:
				1;//messageTopicInvalid();
      endif;
		else:
			messageTopicInvalid();
		endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Alterar Tópico</h2>
    </div>
    <?php require 'TOPICO/form.php';?>
<?php
  endif;
?>