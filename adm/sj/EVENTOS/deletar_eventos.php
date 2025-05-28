<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
$id  = (int)getParam("op1");
if(mysql_query("DELETE FROM eventos WHERE id = $id LIMIT 1"))
    setFlashMessage('Evento excluído com sucesso!', 'success');
else 
    setFlashMessage('Não foi possível excluír o evento!', 'danger');
echo redirect2('index.php?op=list_event');
exit;
?>