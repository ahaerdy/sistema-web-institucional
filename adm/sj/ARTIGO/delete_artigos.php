<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

$id_artigo  = (int)getParam("op1");
$res = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico,  a.diretorio as artigo FROM grupos g, topicos t, artigos a WHERE a.id = ${id_artigo} AND t.id = a.id_topico AND g.id = t.id_grupo");
if(mysql_num_rows($res)):
  $ln = mysql_fetch_assoc($res);
  if($ln['grupo'] && $ln['topico'] && $ln['artigo']):
    chdir('../../../');
    $dir = getcwd().'/arquivo_site/'.$ln['grupo'].'/topicos/'.$ln['topico'].'/artigos/'.$ln['artigo'].'/';
    if(file_exists($dir))
        apagar($dir);
      if(!file_exists($dir)):
          $res = mysql_query("DELETE FROM artigos WHERE id = '$id_artigo' LIMIT 1") or die (mysql_error());
            if($res)
                setFlashMessage('Artigo excluído com sucesso!', 'success');
            else
                setFlashMessage('Não foi possível excluír o artigo!', 'danger');
    else:
          setFlashMessage('Não foi possível excluír o diretorio do artigo, comunique o administrador.!"', 'danger');
        endif;
  else:
    setFlashMessage('Não foi possível excluír o diretorio do artigo, comunique o administrador.!"', 'danger');
  endif;
else:
  setFlashMessage('Artigo não encontrado!', 'info');
endif;
echo redirect2('index.php?op=list_art');
exit;
?>