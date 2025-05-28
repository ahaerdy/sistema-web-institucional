<?php
if (empty($_SESSION['login']['admin']['todos_id_us'])) { echo 'Acesso negado!'; exit; }
function getSubTopicoId($idPai)
{
    $res = mysql_query("SELECT t.id, t.diretorio as topico, g.diretorio as grupo FROM grupos g INNER JOIN topicos t ON t.id_grupo = g.id WHERE t.id_topico = $idPai") or die(mysql_error());
    while($row = mysql_fetch_assoc($res)):
      $dGrupo   = $row['grupo'];
      $dTopico  = $row['topico'];
      chdir('../../../');
      $dir = getcwd() . "/arquivo_site/$dGrupo/topicos/$dTopico/";
      if (file_exists($dir))
        apagar($dir);

      //--------------------------------------------------------------------------------------------------------

      $res = mysql_query("SELECT id FROM galerias WHERE id_topico = " . $row['id']);
      while ($ln = mysql_fetch_assoc($res)):
        mysql_query("DELETE FROM fotos WHERE galerias_id = '" . $ln['id'] . "'");
      endwhile;
      mysql_query("DELETE FROM galerias WHERE id_topico = " . $row['id']);

      //--------------------------------------------------------------------------------------------------------

      $res = mysql_query("SELECT id FROM galerias_video WHERE id_topico = " . $row['id']);
      while ($ln = mysql_fetch_assoc($res)):
        mysql_query("DELETE FROM videos WHERE galerias_id = '" . $ln['id'] . "'");
      endwhile;
      mysql_query("DELETE FROM galerias_video   WHERE id_topico  = " . $row['id']);

      //--------------------------------------------------------------------------------------------------------

      mysql_query("DELETE FROM artigos          WHERE id_topico  = " . $row['id']);
      mysql_query("DELETE FROM topicos          WHERE id         = " . $row['id']);

      //--------------------------------------------------------------------------------------------------------

      getSubTopicoId($row['id']);

    endwhile;
}
$id_topico = (int) getParam("op1");
getSubTopicoId($id_topico);

$res = mysql_query("DELETE FROM topicos WHERE id = " . $id_topico);
if($res)
  setFlashMessage('Tópico excluído com sucesso!', 'success');
else
  setFlashMessage('Não foi possivel excluí o topico!', 'danger');
echo redirect2('index.php?op=list_top');
exit;
?>