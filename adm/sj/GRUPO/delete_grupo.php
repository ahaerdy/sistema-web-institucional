<?php
if (empty($_SESSION['login']['admin']['todos_id_us'])) { echo 'Acesso negado!'; exit;}
$id_grupo = (int) getParam("op1");
if($id_grupo != 3):
    $res = mysql_query("SELECT diretorio FROM grupos WHERE id = $id_grupo");
    if (mysql_num_rows($res)):
        chdir('../../../');
        $diretorio = mysql_result($res, 0, 'diretorio');
        if (!empty($diretorio)):
            $dir = getcwd() . "/arquivo_site/$diretorio/";
            if (file_exists($dir))
                apagar($dir);
        endif;
        $res = mysql_query("DELETE FROM grupos WHERE id = '$id_grupo' LIMIT 1") or die(mysql_error());
        setFlashMessage('Grupo excluído com sucesso!', 'success');
    else:
        setFlashMessage('Não foi possível excluir o grupo, comunique o administrador!', 'warning');
    endif;
endif;
echo redirect2('index.php?op=lis_grup');
exit;
?>