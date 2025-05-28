<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
$id = (int)getParam("op1");
if($id && $id > 2):
    mysql_query("DELETE FROM acesso 			    WHERE usuarios_id 	= ${id}");
    mysql_query("DELETE FROM online 			    WHERE usuarios_id 	= ${id}");
    mysql_query("DELETE FROM grupos_usuarios 	    WHERE id_usuario 	= ${id}");
    mysql_query("DELETE FROM mensalidade 		    WHERE cod_usuario 	= ${id}");
    mysql_query("DELETE FROM mensalidade            WHERE id_usuario    = ${id}");
    mysql_query("DELETE FROM tbl_livro_permissao    WHERE id_usuario    = ${id}");
    mysql_query("DELETE FROM visualizado            WHERE usuario_id 	= ${id}");
    mysql_query("DELETE FROM usuarios 			    WHERE id 			= ${id} LIMIT 1");
    setFlashMessage("Usuário excluído com sucesso!", "success");
endif;
echo redirect2('index.php?op=lis_usu');
exit;
?>