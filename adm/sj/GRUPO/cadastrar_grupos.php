<?php
	if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
	if(isPost()):
    	$id_usuario     = $_SESSION['login']['admin']['id_usuarios'];
    	$nome_principal	= getParam('nome_principal');
    	$titulo		    = getParam('titulo');
		$descricao      = getParam('descricao');
		$id_grupos_art	= getParam('grupos_cadastrados_art');
		$id_grupos_com	= getParam('grupos_cadastrados_com');
		$id_grupos_eve	= getParam('grupos_cadastrados_eve');
		if(!empty($titulo) && !empty($descricao)):
      		$insere   = mysql_query("INSERT INTO grupos (nome_principal,nome,descricao,id_usuario,cadastro) values ('$nome_principal', '$titulo','$descricao','$id_usuario',NOW())")  or die (mysql_error());
 			$id_grupo = mysql_insert_id();
			if($id_grupo):
				mysql_query("UPDATE grupos SET diretorio = 'grupo_$id_grupo' WHERE id = $id_grupo") or die (mysql_error());
				foreach ($id_grupos_art as $ln):
					if((int)$ln):
						$res = mysql_query("SELECT grupos_id FROM grupos_dependente WHERE grupos_id = '".$id_grupo."' AND dependentes_id = '".$ln."'") or die (mysql_error());
						if(!mysql_num_rows($res) && $ln)
			   			mysql_query("INSERT INTO grupos_dependente (grupos_id, dependentes_id, tipo) values ('$id_grupo','$ln','artigo')") or die (mysql_error());
					endif;
				endforeach;
				foreach ($id_grupos_com as $ln):
					if((int)$ln):
						$res = mysql_query("SELECT grupos_id FROM grupos_dependente WHERE grupos_id = '".$id_grupo."' AND dependentes_id = '".$ln."'") or die (mysql_error());
						if (!mysql_num_rows($res) && $ln)
			   				mysql_query("INSERT INTO grupos_dependente (grupos_id, dependentes_id, tipo) values ('$id_grupo','$ln','comunicado')") or die (mysql_error());
          endif;
				endforeach;
				foreach ($id_grupos_eve as $ln):
					if((int)$ln):
						$res = mysql_query("SELECT grupos_id FROM grupos_dependente WHERE grupos_id = '".$id_grupo."' AND dependentes_id = '".$ln."'") or die (mysql_error());
						if (!mysql_num_rows($res) && $ln)
			   			mysql_query("INSERT INTO grupos_dependente (grupos_id, dependentes_id, tipo) values ('$id_grupo','$ln','evento')") or die (mysql_error());
					endif;
				endforeach;
				chdir('../../../');
				$dir0 = mkdir(getcwd() . "/arquivo_site/grupo_$id_grupo"				, 0777);
				$dir1 = mkdir(getcwd() . "/arquivo_site/grupo_$id_grupo/comunicados"	, 0777);
				$dir2 = mkdir(getcwd() . "/arquivo_site/grupo_$id_grupo/eventos"    	, 0777);
				$dir3 = mkdir(getcwd() . "/arquivo_site/grupo_$id_grupo/topicos"    	, 0777);
				if($dir0 && $dir1 && $dir2 && $dir3):
					setFlashMessage('Grupo cadastrado com sucesso!', 'success');
				else:
					setFlashMessage('Grupo cadastrado com sucesso, porem não foi possivel criar os diretorio o grupo, comunique o administrador!', 'warning');
        endif;
			else:
				setFlashMessage('Não foi possivel criar o grupo, comunique o administrador', 'danger');
			endif;
		else:
      setFlashMessage('Digite o título ou descrição para criar o grupo!', 'warning');
    endif;
    echo redirect2('index.php?op=lis_grup');
    exit;
	else:
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Criar Grupo</h2>
    </div>
    <?php require 'GRUPO/form.php';?>
<? endif; ?>