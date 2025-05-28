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
                    AND ev.id = ${iEvento}";
      $res = mysql_query("${sql}");
      if(mysql_num_rows($res)):
        $ln = mysql_fetch_assoc($res);
      echo '<div class="clearfix"></div>';
      echo '<div class="page-header title-event">';
        echo '<h2>'.$ln['titulo'].'</h2>';
      echo '</div>';
      echo '<p>Local: '.$ln['local'].'</p>';
      echo '<p>Data: '.$ln['dia'].'</p>';
      echo '<div class="">'.$ln['texto'].'</div>';
      endif;
    else:
      echo '<h3 style="text-align:center;">Conteúdo indisponível!</h3>';
    endif;
?>