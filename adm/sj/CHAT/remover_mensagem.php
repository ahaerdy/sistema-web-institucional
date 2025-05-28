<?php 

  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $res = false;

  $id = (int)getParam("mensagem");
  if($id):
    $where = "id = ${id} AND (remetente_id = ".getIdUsuario()." OR destinatario_id = ".getIdUsuario().") LIMIT 1";
      $query = mysql_query("SELECT * FROM chats_mensagens WHERE $where");
    if(mysql_num_rows($query)):
      $row = mysql_fetch_assoc($query);
      if(($row['enviado_por_id'] == getIdUsuario() && $row['visivel_destinatario'] == 'N') || 
         ($row['destinatario_id'] == getIdUsuario() && $row['visivel_remetente'] == 'N') || 
         (getParam('caixa-saida') == true)):
        $res = mysql_query("DELETE FROM chats_mensagens WHERE $where");
        if(!empty($ln['arquivo'])):
          echo $path = realpath($_SERVER['DOCUMENT_ROOT'].'/../arquivo_site/chat/').$row['arquivo'];
          exit;
        endif;
      else:
        if(getIdUsuario() == $row['remetente_id']):
          $campo = "visivel_remetente = 'N'";
        elseif(getIdUsuario() == $row['destinatario_id']):
          $campo = "visivel_destinatario = 'N'";
        endif;
        if($row['destinatario_id'] == getIdUsuario()):
          mysql_query("UPDATE chats_mensagens SET visualizado = 'S' WHERE $where") or die(mysql_error());
        endif;
        $res = mysql_query("UPDATE chats_mensagens SET ${campo} WHERE $where");
      endif;
    endif;
    if($res)
      setFlashMessage("Mensagem excluída com sucesso!", "success");
    else
      setFlashMessage("Mensagem não foi excluída!", "danger");
  endif;
  echo redirect2('index.php?op=caixa_entrada');
  exit;
?>