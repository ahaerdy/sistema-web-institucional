<?php
if (empty($_SESSION['login']['admin']['todos_id_us'])) { echo 'Acesso negado!'; exit;}
$id = (int) getParam("op1");
if($id):
    $res = mysql_query("DELETE FROM escalonamentos WHERE id = ${id} LIMIT 1");
    if ($res):
        $res1 = mysql_query("SELECT id FROM usuarios WHERE escalonamento_id = ${id}");
        if(mysql_num_rows($res1)):
            while($ln = mysql_fetch_assoc($res1)):
                mysql_query("DELETE FROM grupos_usuarios WHERE id_usuario = ".$ln['id']." AND escalonamento = 1");
                mysql_query("UPDATE usuarios SET grupos_id = NULL, grupo_home = NULL WHERE id = ".$ln['id']);
            endwhile;
        endif;
        setFlashMessage('Escalonamento excluído com sucesso!', 'success');
    else:
        setFlashMessage('Não foi possível excluir o escalonamento, comunique o administrador!', 'warning');
    endif;
endif;
echo redirect2('index.php?op=lista_escalonamento_filho');
exit;
?>