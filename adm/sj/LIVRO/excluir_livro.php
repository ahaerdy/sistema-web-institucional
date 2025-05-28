<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $id  = (int)getParam("id");
  if($id):
    $res = mysql_query("SELECT id FROM capitulos WHERE id_livro = $id");
    while( $ln = mysql_fetch_assoc($res) ):
      mysql_query("DELETE FROM paginas WHERE id_capitulo = " . $ln['id']);
    endwhile;
    mysql_query("DELETE FROM capitulos WHERE id_livro = $id");  
    if(mysql_query("DELETE FROM livros WHERE id = $id LIMIT 1"))
      setFlashMessage('Livro excluído com sucesso!', 'success');
    else
      setFlashMessage('Não foi possível excluír o livro, comunique o administrador!', 'danger');
  endif;
  echo redirect2('index.php?op=lista_livros');
  exit;
?>