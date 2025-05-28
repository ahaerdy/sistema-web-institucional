<?php
if (getIdUsuario() > '3'):
	$sql = "SELECT m.*, DATE_FORMAT(m.criado_em, '%d/%m/%Y ás %H:%i') as data, u1.nome as remetente_nome, u2.nome as destinatario_nome, c.categoria
            FROM chats_mensagens m
            INNER JOIN chats_categorias c ON m.chat_categoria_id = c.id
            INNER JOIN usuarios u1 ON m.remetente_id = u1.id
            INNER JOIN usuarios u2 ON m.destinatario_id = u2.id
            WHERE m.visualizado = 'N' AND  m.enviado_por_id != ".getIdUsuario()." AND m.destinatario_id = ".getIdUsuario();
  $query = mysql_query($sql);
  $badgeMen  = null;
  $xMen = mysql_num_rows($query);
  $badgeMen = '<li><a href="?op=caixa_entrada">Mensagens ';
  if($xMen):
    $badgeMen .= '<span class="badge" style="color: white; background-color:#CB0000; ">'.$xMen.'</span> </a></li>';
  endif;
  $badgeMen .= '</a></li>';
endif;
?>