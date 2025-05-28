<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $id             = (int)getParam('id');
    $grupo_id       = (int)getParam('iGrupo');
    $name           = getParam('name');
    $room_id        = (int)getParam('room_id');
    $room_password  = getParam('room_password');
    $data_inicio    = getParam('data_inicio');
    $data_final     = getParam('data_final');
    $hora_inicio    = getParam('hora_inicio');
    $hora_final     = getParam('hora_final');
    $filtro_cidade  = getParam('filtro_cidade');
  
    if(!empty($name) && !empty($room_id) && !empty($room_password) && !empty($data_inicio) && !empty($data_final)):

      $data_inicio = explode('/', $data_inicio);
      $data_inicio = $data_inicio[2].'-'.$data_inicio[1].'-'.$data_inicio[0] . ' ' . $hora_inicio;
      $data_final = explode('/', $data_final);
      $data_final = $data_final[2].'-'.$data_final[1].'-'.$data_final[0] . ' ' . $hora_final;

      if(!$id):
        $sql = "INSERT INTO `sala_conference` (`grupo_id`, `name`, `room_id`, `room_password`, `data_inicio`, `data_final`,`filtro_cidade`) 
                VALUES ($grupo_id, '$name', '$room_id', '$room_password', '$data_inicio', '$data_final','$filtro_cidade');";
      else:
        $sql = "UPDATE `sala_conference` SET `grupo_id` = $grupo_id, `name` = '$name', `room_id` = '$room_id', `room_password` = '$room_password', `data_inicio` = '$data_inicio', `data_final` = '$data_final', `filtro_cidade` = '$filtro_cidade' 
                WHERE grupo_id = $grupo_id;";
      endif;
      $ins = mysql_query($sql) or die(mysql_error());
      if($ins)
        setFlashMessage('Sala modificada com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel salvar a sala!', 'danger');
    else:
      setFlashMessage('Digite os campos obrigatórios!', 'warning');
    endif;
    echo redirect2('index.php?op=lis_grup');
    exit;
  else:
    function messageGroupInvalid()
    {
      setFlashMessage('Grupo inválido!', 'danger');
      echo redirect2('index.php?op=lis_grup');
    }
    $id_grupo = (int) getParam("iGrupo");
    if($id_grupo):
      $res = mysql_query("SELECT *, 
                          DATE_FORMAT(data_inicio, '%d/%m/%Y') as data_inicio, 
                          DATE_FORMAT(data_final, '%d/%m/%Y') as data_final,
                          DATE_FORMAT(data_inicio, '%H:%i') as hora_inicio, 
                          DATE_FORMAT(data_final, '%H:%i') as hora_final
                          FROM sala_conference where grupo_id = ${id_grupo} LIMIT 1");
      $ln  = mysql_fetch_assoc($res);
    else:
      messageGroupInvalid();
    endif;
    $form = new formHelper();
?>
    <div class="page-header">
      <h2>Sala de conferência</h2>
    </div>
    <?php require 'GRUPO/form-conference.php';?>
<? endif; ?>
