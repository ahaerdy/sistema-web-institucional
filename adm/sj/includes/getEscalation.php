<?php
session_start();
require "functions/functions.php";
if (isPost() && isXmlHttpRequest())
{
  require "db/config.inc.php";
  Conectar();

  $op.= '<option value="" selected="selected"> - Selecione o escalonamento filho - </option>';
  $res = mysql_query("SELECT id, titulo, ordem FROM escalonamentos WHERE escalonamento_id = ".(int)getParam('escalationId')." ORDER BY ordem ASC");
  while ($row = mysql_fetch_assoc($res)):
    $sel = ((int)getParam('selectedId') == $row["id"])? 'selected' : '';
    $op.= '<option value="' . $row["id"] . '" '.$sel.'>' . $row["ordem"].') '.  $row["titulo"] . '</option>';
  endwhile;
  $r['op'] = $op;
  echo json_encode($r);
}