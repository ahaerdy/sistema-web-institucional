<?php
if (getIdUsuario() > '3'):
  $idLeituraTotal = $_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_le'];
  $idLeituraTotal = explode(',', $idLeituraTotal);
  if(!in_array($_SESSION['login']['iGrupo'], $idLeituraTotal))
    $w3 = " AND ev.compartilhado = 'S' ";
    $w2 = " AND (
                (gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR
                (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_e'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") ${w3}))";

  $query = mysql_query("SELECT
                          ev.id
                        FROM
                          grupos as gp INNER JOIN eventos as ev ON gp.id = ev.id_grupo AND ev.ativo = 'S' AND ev.dia >= '".date('Y-m-d')."' ${w2}
                        WHERE
                          ev.id NOT IN(SELECT secao_id FROM visualizado WHERE usuario_id = ".getIdUsuario()." AND tipo = 'EVENTO') AND gp.ativo = 'S' AND evento = 'S'");
  $badge  = null;
  $xEve = mysql_num_rows($query);
  $badgeEve = '<li><a href="?op=mostra_evento">Ver Eventos ';
  if($xEve):
    $badgeEve .= '<span class="badge" style="color: white; background-color:#CB0000;">'.$xEve.'</span> </a></li>';
  endif;
  $badgeEve .= '</a></li>';
endif;
?>
