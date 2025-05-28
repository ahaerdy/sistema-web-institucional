<?php
if (getIdUsuario() > '3'):
   $sql = "SELECT count(id) AS contagem,usuario_id,pagamento_status_id FROM pagamentos WHERE usuario_id=".getIdUsuario()." AND pagamento_status_id IN (2,9,10)";
  $query = mysql_query($sql);
  $ln = mysql_fetch_assoc($query);
  $badgeContrib  = null;
  $contagem=$ln['contagem'];
  $xContrib=$contagem;
  $badgeContrib = '<li><a href="?op=pagamentos">Contribuições ';
  if($contagem):
    $badgeContrib .= '<span class="badge" style="color: white; background-color:#CB0000; ">'.$contagem.'</span> </a></li>';
  endif;
  $badgeContrib .= '</a></li>';
  /*echo $badgeContrib; exit;*/
endif;
?>