<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
$id  = (int)getParam("op1");
if(mysql_query("DELETE FROM comunicados WHERE id = $id LIMIT 1"))
    setFlashMessage('Comunicado excluído com sucesso!', 'success');
else 
    setFlashMessage('Não foi possível excluír o comunicado!', 'danger');
echo redirect2('index.php?op=list_comu');
exit;
?>