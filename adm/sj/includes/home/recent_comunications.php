<?php
if (getIdUsuario() > '3'):
  $idLeituraTotal = $_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_le'];
  $idLeituraTotal = explode(',', $idLeituraTotal);
  if(!in_array($_SESSION['login']['iGrupo'], $idLeituraTotal))
    $w3 = " AND cm.compartilhado = 'S' ";

    $w2 = " AND (
                (gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR
                (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_c'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") ${w3})
            )";

  $query = mysql_query("SELECT
                          cm.id
                        FROM
                          grupos as gp INNER JOIN comunicados as cm ON gp.id = cm.grupos_id AND cm.ativo = 'S' ${w2}
                        WHERE
                          cm.id NOT IN(SELECT secao_id FROM visualizado WHERE usuario_id = ".getIdUsuario()." AND tipo = 'COMUNICADO') AND gp.ativo = 'S' AND gp.comunicado = 'S'");
  $badgeCom  = null;
  $xCom = mysql_num_rows($query);
  $badgeCom = '<li><a href="?op=mostra_comunicado">Ver Comunicados ';
  if($xCom):
    $badgeCom .= '<span class="badge" style="color: white; background-color:#CB0000;">'.$xCom.'</span> </a></li>';
  endif;
  $badgeCom .= '</a></li>';
endif;
?>