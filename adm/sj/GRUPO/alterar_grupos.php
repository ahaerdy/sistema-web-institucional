<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $id_grupo      = (int) getParam('grupo');
    $nome_principal= getParam('nome_principal');
    $titulo        = getParam('titulo');
    $descricao     = getParam('descricao');
    $id_grupos_art = getParam('grupos_cadastrados_art');
    $id_grupos_com = getParam('grupos_cadastrados_com');
    $id_grupos_eve = getParam('grupos_cadastrados_eve');
    if(!empty($titulo) && !empty($descricao) && !empty($id_grupo)):
      $update = mysql_query("UPDATE grupos SET nome_principal = '$nome_principal', nome = '$titulo', descricao = '$descricao' WHERE id = '$id_grupo'") or die (mysql_error());
      if($update):
        mysql_query("DELETE FROM grupos_dependente WHERE grupos_id = $id_grupo");
        foreach ($id_grupos_art as $ln):
          if (!empty($ln)):
            $sql = mysql_query("SELECT * FROM grupos_dependente WHERE grupos_id = '".$id_grupo."' AND dependentes_id = '".$ln."' AND tipo = 'artigo'");
            if (!mysql_num_rows($sql))
              mysql_query("INSERT INTO grupos_dependente (grupos_id, dependentes_id, tipo) values ('$id_grupo','$ln','artigo')") or die (mysql_error());
          endif;
        endforeach;
        foreach($id_grupos_com as $ln):
          if (!empty($ln)):
            $sql = mysql_query("SELECT * FROM grupos_dependente WHERE grupos_id = '".$id_grupo."' AND dependentes_id = '".$ln."' AND tipo = 'comunicado'");
            if (!mysql_num_rows($sql))
              mysql_query("INSERT INTO grupos_dependente (grupos_id, dependentes_id, tipo) values ('$id_grupo','$ln','comunicado')") or die (mysql_error());
          endif;
        endforeach;
        foreach($id_grupos_eve as $ln):
          if (!empty($ln)):
            $sql = mysql_query("SELECT * FROM grupos_dependente WHERE grupos_id = '".$id_grupo."' AND dependentes_id = '".$ln."' AND tipo = 'evento'");
            if (!mysql_num_rows($sql))
              mysql_query("INSERT INTO grupos_dependente (grupos_id, dependentes_id, tipo) values ('$id_grupo','$ln','evento')") or die (mysql_error());
          endif;
        endforeach;
        // Volta ponteiro do diretorio;
        chdir('../../../');
        // Cia diretorios de conteúdos
        if(!file_exists(getcwd()."/arquivo_site/grupo_$id_grupo"              )){ $dir0 = mkdir(getcwd()."/arquivo_site/grupo_$id_grupo"        , 0777); } else { $dir0 = 1; }
        if(!file_exists(getcwd()."/arquivo_site/grupo_$id_grupo/comunicados"  )){ $dir1 = mkdir(getcwd()."/arquivo_site/grupo_$id_grupo/comunicados"  , 0777); } else { $dir1 = 1; }
        if(!file_exists(getcwd()."/arquivo_site/grupo_$id_grupo/eventos"      )){ $dir2 = mkdir(getcwd()."/arquivo_site/grupo_$id_grupo/eventos"    , 0777); } else { $dir2 = 1; }
        if(!file_exists(getcwd()."/arquivo_site/grupo_$id_grupo/topicos"      )){ $dir3 = mkdir(getcwd()."/arquivo_site/grupo_$id_grupo/topicos"    , 0777); } else { $dir3 = 1; }
        if($dir0 && $dir1 && $dir2 && $dir3)
          setFlashMessage('Grupo alterado com sucesso!', 'success');
        else
          setFlashMessage('Grupo alterado com sucesso, porem não foi possivel criar os diretorio, comunique o administrador!', 'warning');
      else:
        setFlashMessage('Não foi possível alterar o grupo comunique o administrador!', 'danger');
      endif;
    else:
      setFlashMessage('Digite o título ou descrição para criar o grupo!', 'warning');
    endif;
    echo redirect2('index.php?op=lis_grup');
    exit;
  else:
    function messageGroupInvalid()
    {
      setFlashMessage('Grupo inválido!', 'danger');
      echo redirect2('index.php?op=lis_grup');
    }
    $id_grupo = (int) getParam("op1");
    if($id_grupo):
      $res = mysql_query("SELECT * FROM grupos where id = ${id_grupo}");
      if(mysql_num_rows($res))
        $ln  = mysql_fetch_assoc($res);
      else
        messageGroupInvalid();
    else:
      messageGroupInvalid();
    endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Editar Grupo</h2>
    </div>
    <?php require 'GRUPO/form.php';?>
<? endif; ?>