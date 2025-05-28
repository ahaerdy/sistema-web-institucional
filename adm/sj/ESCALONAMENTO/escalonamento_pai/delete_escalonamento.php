<?php
if (empty($_SESSION['login']['admin']['todos_id_us'])) { echo 'Acesso negado!'; exit;}
$id = (int) getParam("op1");
if($id):
    $res = mysql_query("SELECT id, escalonamento_id FROM escalonamentos WHERE id = ${id} OR escalonamento_id = ${id} ORDER BY escalonamento_id DESC") or die(mysql_error());
    if(mysql_num_rows($res)):
        while($ln=mysql_fetch_assoc($res)):
            deleteEscalonamento($ln['id'], $ln['escalonamento_id']);
        endwhile;
        setFlashMessage('Escalonamento excluído com sucesso!', 'success');
    else:
        setFlashMessage('Não foi possível excluir o escalonamento, comunique o administrador!', 'warning');
    endif;
endif;
echo redirect2('index.php?op=lista_escalonamento_pai');
exit;

function deleteEscalonamento($id, $pai=0)
{
    $res1 = mysql_query("SELECT id FROM usuarios WHERE escalonamento_id = ${id}") or die(mysql_error());
    if(mysql_num_rows($res1)):
        while($ln = mysql_fetch_assoc($res1)):
            mysql_query("DELETE FROM grupos_usuarios WHERE id_usuario = ".$ln['id']." AND escalonamento = 1") or die(mysql_error());
            mysql_query("UPDATE usuarios SET grupos_id = NULL, grupo_home = NULL WHERE id = ".$ln['id']) or die(mysql_error());
        endwhile;
    endif;
    $where = (!(int)$pai)? "id = ${id}":"escalonamento_id = ${id}";
    return mysql_query("DELETE FROM escalonamentos WHERE ${where} LIMIT 1") or die(mysql_error());
}
?>
