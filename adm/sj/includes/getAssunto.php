<?php
session_start();
require "functions/functions.php";
if (isPost() && isXmlHttpRequest())
{
  require "db/config.inc.php";
  Conectar();
  $op.= '<option value="#" selected="selected"> - Selecione o Assunto1 - </option>';
  $res = mysql_query("SELECT id, nome as topico, id_topico FROM topicos WHERE id != ".(int)getParam('selectedId')." AND id_grupo = ".(int)getParam('groupId')." AND id_topico = 0 ORDER BY nome ASC");
  while ($row = mysql_fetch_assoc($res)):
    $sel = ((int)getParam('selectedId') == $row["id"])? 'selected' : '';
    $op.= '<option value="' . $row["id"] . '" '.$sel.'>' . '(cod. '.$row["id"].') '. $row["topico"] . '</option>';
  endwhile;
  $r['op'] = $op;
  echo json_encode($r);
}