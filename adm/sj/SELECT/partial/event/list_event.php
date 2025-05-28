<?php
      $sql = "SELECT
                    gp.nome as grupo, 
                    ev.*, 
                    date_format(dia,'%d/%m/%Y') as dia,
                    dia as data,
                    vs.id as visualizado
                  FROM 
                    grupos as gp 
                    INNER JOIN eventos as ev ON ev.id_grupo = gp.id
                    LEFT JOIN visualizado as vs ON ev.id = vs.secao_id AND vs.usuario_id = ".getIdUsuario()." AND vs.tipo = 'EVENTO'
                  WHERE
                    ((gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
                      (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_c'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND ev.compartilhado = 'S')) 
                    AND gp.ativo='S' 
                    AND ev.ativo='S' 
                    AND gp.comunicado = 'S'
                  ORDER BY visualizado ASC, ev.dia DESC, gp.nome ASC";
    $res = mysql_query("${sql}");
    if(mysql_num_rows($res)):
      echo "<div class=\"panel panel-default\">";
        echo '<div class="panel-heading">Eventos</div>';
        echo "<div class=\"list-group\">";
          while ($ln = mysql_fetch_assoc($res)):
            $badge = (empty($ln['visualizado']) && ($ln['data'] >= date('Y-m-d')))? '<span class="badge" style="background: #d2322d;">Novo</span>' : '';
            echo '<a href="index.php?op=mostra_evento&evento='.$ln['id'].'" class="list-group-item">'.$badge.'Grupo: '.$ln['grupo'].' | '.$ln['dia'].' - <b>'.$ln['titulo'] . '</b><br><small>'.$ln['descricao'] .'</small>'.'</a>';
          endwhile;
        echo "</div>";
      echo "</div>";
    endif;
?>