<?php
if (empty($_SESSION['login']['admin']['todos_id_us'])) { echo 'Acesso negado!'; exit;}
function getIds($id_topico, $id = array())
{
  $query = mysql_query("SELECT id FROM topicos WHERE id_topico = " . $id_topico);
  while ($ln = mysql_fetch_assoc($query)):
    $id[] = $ln['id'];
    $id   = getIds($ln['id'], $id);
  endwhile;
  return $id;
}
$id_topico = (int) getParam("op1");
$ids       = implode(',', getIds($id_topico));
if (!$ids)
  $ids = $id_topico;

$res1 = mysql_query('SELECT id, id_grupo, diretorio FROM topicos WHERE id IN (' . $ids . ')');
if (mysql_num_rows($res1)):
    while ($ln = mysql_fetch_assoc($res1)):
        $res = mysql_query("SELECT diretorio FROM grupos WHERE id = " . $ln['id_grupo']);
        $dGrupo = mysql_result($res, 0, 'diretorio');
        if (!empty($ln['diretorio']) && !empty($ln['diretorio'])):
            chdir('../../../');
            $dir = getcwd() . "/arquivo_site/$dGrupo/topicos/" . $ln['diretorio'] . "/";
            if (file_exists($dir))
                apagar($dir);
        endif;
        mysql_query("DELETE FROM topicos WHERE id = " . $ln['id']);
    endwhile;
    mysql_query("DELETE FROM topicos WHERE id = " . $id_topico);
  setFlashMessage('Assunto excluído com sucesso!', 'success');
endif;
echo redirect2('index.php?op=lista_assunto');
exit;
?>