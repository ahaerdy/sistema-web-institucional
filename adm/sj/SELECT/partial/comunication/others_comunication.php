<?php
  if($iComunicado):
    $sql = "SELECT 
                  *, date_format(cm.cadastro,'%d/%m/%Y') as cadastro
                FROM 
                  grupos as gp INNER JOIN comunicados as cm ON cm.grupos_id = gp.id
                WHERE
                  ((gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
                   (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_c'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND cm.compartilhado = 'S')) 
                  AND gp.ativo='S' 
                  AND cm.ativo='S' 
                  AND cm.id != ${iComunicado} ORDER BY cm.cadastro DESC LIMIT 8";
    $res = mysql_query("${sql}");
    if(mysql_num_rows($res)):
      echo "<div class=\"panel panel-default\">";
        echo '<div class="panel-heading">Outros Comunicados</div>';
        echo "<div class=\"list-group\">";
          while ($ln = mysql_fetch_assoc($res)):
            echo '<a href="index.php?op=mostra_comunicado&comunicado='.$ln['id'].'" class="list-group-item">'.$ln['cadastro'].' - <b>'.$ln['titulo'] . '</b><br><small>'.$ln['descricao'] .'</small>'.'</a>';
          endwhile;
        echo "</div>";
      echo "</div>";
    endif;
  endif;
?>