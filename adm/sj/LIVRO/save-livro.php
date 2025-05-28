<?php
session_start();
if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }
require '../includes/functions/functions.php';
if(isXmlHttpRequest() && isPost()):
  require ("../../config.inc.php");
  Conectar ();
  $livroId = (int)getParam('id_livro');
  $grupoId = (int)getParam('grupo');
  $topicoId = (int)getParam('topico');
  $categoriaId = (int)getParam('categoria');
  $titulo = getParam('titulo');
  $autor = getParam('autor');
  $revisao = getParam('revisao');
  $isbn = getParam('isbn');
  $descricao = getParam('descricao');
  $url_loja = getParam('url_loja');
  $permissao = getParam('permissao');
  $fotoat = getParam('fotoat');
  $excluirFoto = getParam('excluir-foto');
  $hora = getParam('hora');
  $data = getParam('data');
  $data = explode ( '/',$data );
  $data = $data[2].'-'.$data[1].'-'.$data[0];
  if(empty($topicoId) || empty($categoriaId)):
    $res ['erro'] = 1;
    $res ['message'] = array('Informe o dados obrigatórios para adicionar o capítulo.', 'warning');
  else:
    $foto = '';
    $dir = getDir($grupoId, $topicoId);
    if(!empty($dir)):
      if($excluirFoto=='S'):
        deleteFoto($dir, $fotoat);
        mysql_query("UPDATE livros SET foto = '' WHERE id = ${livroId}");
      endif;

      if(!empty($_FILES['foto']['name'])):
        deleteFoto($dir, $fotoat);
        $nome = substr($_FILES['foto']['name'], 0, -4);
        $ext  = substr($_FILES['foto']['name'], -4);
        $foto = $nome . '@' . $id_artigo . $ext;
        $path = $dir . '/' . $foto; 
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $path)):
          if($livroId)
            mysql_query("UPDATE livros SET foto = '$foto' WHERE id = ${livroId}");
          $res['foto'] = $foto;
        endif;
      endif;
    endif;

    if(empty($livroId)):
      $ins = mysql_query("INSERT INTO livros (id_topico,id_categoria,titulo,autor,revisao,isbn,descricao,url_loja,permissao,foto,cadastrado,ativo) 
                          VALUES ('${topicoId}','${categoriaId}','${titulo}','${autor}','${revisao}','${isbn}','${descricao}','${url_loja}','${permissao}','${foto}','${data} ${hora}','N')") or  die(mysql_error());
      if($ins):
        $res ['erro'] = 0;
        $res ['id_livro'] = mysql_insert_id();
        $res ['message'] = array('Livro adicionado com sucesso!', 'success');
      else:
        $res ['erro'] = 1;
        $res ['message'] = array('Não foi possível adicionar o livro, tente novamente!', 'warning');
      endif;
    else:
      $ins = mysql_query ( "UPDATE livros SET id_topico='${topicoId}',id_categoria='${categoriaId}',titulo='${titulo}',autor='${autor}',revisao='${revisao}',isbn='${isbn}',descricao='${descricao}',url_loja='${url_loja}',permissao='${permissao}',cadastrado='${data} ${hora}' WHERE id = ${livroId}");
      if ($ins):
        $res ['erro'] = 0;
        $res ['id_livro'] = $livroId;
        $res ['message'] = array('Livro alterado com sucesso!', 'success');
      else:
        $res ['erro'] = 1;
        $res ['message'] = array('Não foi possível alterar o livro, tente novamente!', 'warning');
      endif;
    endif;
  endif;
  echo json_encode ( $res );
endif;

function getDir($grupo, $id_topico)
{
  $res = mysql_query("SELECT diretorio FROM grupos WHERE id = ${grupo}");
  if (mysql_num_rows($res)):
    $ln = mysql_fetch_assoc($res);
    chdir('../../../../');
    $dir = getcwd() . "/arquivo_site/".$ln["diretorio"];
    if(is_dir($dir."/topicos/topico_$id_topico/livros")):
      return $dir."/topicos/topico_$id_topico/livros";
    endif;
  endif;
}
function deleteFoto($dir, $fotoat)
{
  if(!empty($fotoat))
    if(file_exists($dir.'/'.$fotoat))
      return unlink($dir.'/'.$fotoat);
}
?>