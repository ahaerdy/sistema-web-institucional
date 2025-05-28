<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  if(isset($_GET['op']  ) && !empty($_GET['op']   )){ $url[] = 'op='   . $_GET['op'];   }
  if(isset($_GET['usuario']  ) && !empty($_GET['usuario'] )){ $url[] = 'usuario=' . $_GET['usuario'];   }
  $urlPaginacao = implode('&', $url);
  $id_usuario = (int)$_GET['usuario'];
  if( !$id_usuario )
    setFlashMessage('Usuário não encontrado!', 'warning');
  if( !empty($_POST) && !empty($_GET['usuario']) && !empty($_POST['submit_permissao'])):
    foreach ($_POST['permissao'] as $key => $value):
      $res = mysql_query("SELECT id FROM tbl_livro_permissao WHERE id_usuario = ${id_usuario} AND id_livro = ${key}") or die ( mysql_error() );
      if( mysql_num_rows($res) == 0 )
        mysql_query( "INSERT INTO tbl_livro_permissao (id_usuario, id_livro, permissao) VALUES ('${id_usuario}', '${key}', '${value}')" ) or die ( mysql_error() );
      else
        mysql_query( "UPDATE tbl_livro_permissao SET permissao = '${value}' WHERE id_usuario = ${id_usuario} AND id_livro = ${key}") or die ( mysql_error() );
    endforeach;
    setFlashMessage('Permissão alterada com sucesso!', 'success');
    echo redirect2('index.php?op=lis_usu');
    exit;
  else:
    $query = mysql_query("SELECT group_concat(gu.id_grupo) as id_grupo_user FROM grupos g, grupos_usuarios gu WHERE g.id = gu.id_grupo AND gu.id_usuario = ${id_usuario} AND g.ativo = 'S'");
    $ln  = mysql_fetch_assoc($query);
    if( empty($ln['id_grupo_user']) ):
      setFlashMessage('Nenhum grupo definido para seu usuário', 'danger');
    else:
      $ln1 = explode(',', $ln['id_grupo_user']);
      function gruposArtigo($ids, $iArtigos, $not=false)
      {
        if($ids):
          if(!$not)
            $sql = "SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo='artigo' AND grupos_id IN ({$ids})";
          else
            $sql = "SELECT group_concat(dependentes_id) as dependentes_id FROM grupos_dependente WHERE tipo='artigo' AND grupos_id IN ({$ids}) AND dependentes_id NOT IN (${not})";
          $res = mysql_query($sql);
          if(mysql_num_rows($res)):
            $res = mysql_fetch_assoc($res);
            $iArtigos[] = $res['dependentes_id'];
            gruposArtigo($res['dependentes_id'], $iArtigos, $ids);
          endif;
        endif;
        return $iArtigos;
      }
      $gruposArtigo = gruposArtigo($ln['id_grupo_user'], array());
      $gruposArtigo = implode(',', $gruposArtigo);
      $gruposArtigo = explode(',', $gruposArtigo);
      $gruposArtigo = array_merge(array_values($ln1), array_values($gruposArtigo));
      $gruposArtigo = array_unique($gruposArtigo);
      $gruposArtigo = implode(',', $gruposArtigo);
      $gruposArtigo = (substr($gruposArtigo, -1) != ',') ? $gruposArtigo : substr($gruposArtigo, 0, -1);
      if($gruposArtigo):
          $ids = explode(',',$gruposArtigo);
          $ids = array_merge(array_values($ln1), array_values($ids));
          $ids = array_unique($ids);
          $ids1 = $ids;
      endif;
      $todos_id_us = array_merge(array_values($ids1));
      $todos_id_us = array_unique($todos_id_us);
      $todos_id_us = implode(',',$todos_id_us);
      $todos_id_le = $ln['id_grupo_user'];
    endif;
    require "partial/list_permission.php";
  endif; 
?>