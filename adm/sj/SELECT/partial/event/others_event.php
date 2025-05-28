<?php
  if($iEvento):
      $sql = "SELECT 
                    *, date_format(dia,'%d/%m/%Y') as dia
                  FROM 
                    grupos as gp INNER JOIN eventos as ev ON ev.id_grupo = gp.id
                  WHERE
                    ((gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
                      (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_c'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND ev.compartilhado = 'S'))
                    AND gp.ativo='S' 
                    AND ev.ativo='S' 
                    AND ev.id != ${iEvento}
                    AND dia  >= '".date("Y-m-d")."' ORDER BY ev.dia ASC";
    $res = mysql_query("${sql}");
    if(mysql_num_rows($res)):
      echo "<div class=\"panel panel-default\">";
        echo '<div class="panel-heading">Outros Eventos</div>';
        echo "<div class=\"list-group\">";
          while ($ln = mysql_fetch_assoc($res)):
            echo '<a href="index.php?op=mostra_evento&evento='.$ln['id'].'" class="list-group-item">'.$ln['dia'].' - <b>'.$ln['titulo'] . '</b><br><small>'.$ln['descricao'] .'</small>'.'</a>';
          endwhile;
        echo "</div>";
      echo "</div>";
    endif;
  endif;
?>