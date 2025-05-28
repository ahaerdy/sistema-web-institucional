<?php
session_start();
require "functions/functions.php";
$id = (int)getParam('categoryId');
if (isPost() && isXmlHttpRequest() && $id)
{
  require "db/config.inc.php";
  Conectar();
  $selectedId = (int) getParam('selectedId');
  $op.= '<option value="#" selected="selected"> Selecione um destinatário </option>';
  $res = mysql_query("SELECT u.id, u.nome
                      FROM chats_categorias c
                      INNER JOIN  chats_categorias_x_usuarios x ON x.chat_categoria_id = c.id
                      INNER JOIN usuarios u ON x.usuario_id = u.id
                      WHERE c.id = ${id} AND u.id != ".getIdUsuario(). " UNION SELECT id, nome FROM usuarios WHERE id = ${selectedId}");
  while ($row = mysql_fetch_assoc($res)):
    $sel = ((int)getParam('selectedId') == $row["id"])? 'selected' : '';
    $op.= '<option value="' . $row["id"] . '" '.$sel.'>' . $row["nome"] . '</option>';
  endwhile;
  $r['op'] = $op;
  $r['qtd'] = mysql_num_rows($res);
  echo json_encode($r);
}