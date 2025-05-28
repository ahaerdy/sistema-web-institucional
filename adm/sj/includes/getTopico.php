<?php
session_start();
require "functions/functions.php";
if (isPost() && isXmlHttpRequest())
{
  require "db/config.inc.php";
  Conectar();
  function recurOption($pai, $nivel = '')
  {
    $nivel = '-- ' . $nivel;
    $res = mysql_query("SELECT id, nome as topico, id_topico FROM topicos WHERE id_grupo = ".(int)getParam('groupId')." AND id_topico = ${pai} ORDER BY nome ASC");
    while ($row = mysql_fetch_assoc($res)):
      if ($row["id_topico"] == 0)
        $op.= '<optgroup label="' . $row["topico"] . '">';
    	$sel = ((int)getParam('selectedId') == $row["id"])? 'selected' : '';
      $op.= '<option value="' . $row["id"] . '" '.$sel.'>' . $nivel . '(cod. '.$row["id"].') '.  $row["topico"] . '</option>';
      $op.= recurOption($row["id"], $nivel);
      if ($row["id_topico"] == 0)
        $op.= '</optgroup>';
    endwhile;
    return $op;
  }
  $op.= '<option value="" selected="selected"> - Selecione - </option>';
  $op.= recurOption(0);
  $r['op'] = $op;
  echo json_encode($r);
}