<?php
ini_set('mysql.connect_timeout', 3000);
ini_set('default_socket_timeout', 3000);
ini_set('max_execution_time', 0); 

$grupoId = (int)getParam('op1');
if ($grupoId > 0):
  function processaClonagem($id, $idPai = 0, $idGrupo, $nivel = 0, $ids = '')
  {
    if ($nivel == 0):
      $where = "id = ${id}";
    else:
      $where = "id_topico = ${id}";
    endif;
    if (!empty($ids)) 
      $where.= " AND id IN (${ids})";
    $query = mysql_query("SELECT id FROM topicos WHERE ${where}");
    while ($ln = mysql_fetch_assoc($query)):
      $idPai2 = cloneTopicoRegistro($ln['id'], $idPai, $idGrupo, 'topicos');
      if($idPai2):
        cloneRegistrosPorTopico($ln['id'], $idPai2, 'artigos');
        cloneRegistrosPorTopico($ln['id'], $idPai2, 'galerias');
        cloneRegistrosPorTopico($ln['id'], $idPai2, 'galerias_video');
        cloneRegistrosPorTopico($ln['id'], $idPai2, 'livros');
        processaClonagem($ln['id'], $idPai2, $idGrupo, ++$nivel, $ids);
      endif;
    endwhile;
    return true;
  }
  $grupoIdNovo = (int)cloneGrupo($grupoId);
  $query = mysql_query("SELECT id FROM topicos WHERE id_grupo = ${grupoId} AND (id_topico = 0 OR id_topico IS NULL) ORDER BY id ASC");
  while ($ln = mysql_fetch_assoc($query)):
    $ids = obterIdsTopicos($ln['id']);
    $ids = rtrim($ids, ',');
    processaClonagem($ln['id'], 0, $grupoIdNovo, 0, $ids);
  endwhile;
  copiaDiretorios();
  setFlashMessage('Grupo clonado com sucesso!', 'success');
  echo redirect2('index.php?op=lis_grup');
  exit;
endif;
?>