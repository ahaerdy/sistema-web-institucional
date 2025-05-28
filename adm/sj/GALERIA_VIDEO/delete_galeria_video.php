<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

chdir('../../../');
$iGaleria = (int) $_GET["op1"];
if ($iGaleria):
  $res = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico, gl.diretorio as galeria FROM grupos g, topicos t, galerias_video gl WHERE gl.id = $iGaleria AND t.id = gl.id_topico AND g.id = t.id_grupo");
  if (mysql_num_rows($res)):
    $ln = mysql_fetch_array($res);
    if (file_exists(getcwd() . '/arquivo_site/' . $ln["grupo"] . '/topicos/' . $ln["topico"] . '/videos/' . $ln["galeria"] . '/'))
      apagar(getcwd() . '/arquivo_site/' . $ln["grupo"] . '/topicos/' . $ln["topico"] . '/videos/' . $ln["galeria"] . '/');
    mysql_query("DELETE FROM        videos         WHERE galerias_id = $iGaleria");
    if (mysql_query("DELETE FROM galerias_video WHERE id = $iGaleria LIMIT 1"))
      setFlashMessage('Galeria excluída com sucesso!', 'success');
    else
      setFlashMessage('Não foi possivel excluír a galeria!', 'danger');
  endif;
endif;
echo redirect2('index.php?op=lista_galeria_video');
exit;
?>