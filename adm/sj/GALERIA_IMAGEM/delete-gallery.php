<?php
if (empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){
  echo 'Acesso negado!';
  exit;
}
chdir('../../../');
$iGaleria = (int) $_GET["op1"];
if ($iGaleria):
    $res = mysql_query("SELECT g.diretorio as grupo, t.diretorio as topico, gl.diretorio as galeria FROM grupos g, topicos t, galerias gl WHERE gl.id = $iGaleria AND t.id = gl.id_topico AND g.id = t.id_grupo");
    if (mysql_num_rows($res)):
        $ln = mysql_fetch_array($res);
        if (file_exists(getcwd() . '/arquivo_site/' . $ln["grupo"] . '/topicos/' . $ln["topico"] . '/fotos/' . $ln["galeria"] . '/'))
            apagar(getcwd() . '/arquivo_site/' . $ln["grupo"] . '/topicos/' . $ln["topico"] . '/fotos/' . $ln["galeria"] . '/');
        mysql_query("DELETE FROM fotos      WHERE galerias_id = $iGaleria");
        if (mysql_query("DELETE FROM galerias    WHERE id = $iGaleria LIMIT 1"))
            setFlashMessage('Galeria excluída com sucesso!', 'success');
        else
            setFlashMessage('Não foi possivel excluír a galeria!', 'success');
    endif;
endif;
echo redirect2('index.php?op=list_galer');
exit;    
?>