<?php
    $sql = "SELECT
                  gp.nome as grupo, 
                  cm.*, 
                  date_format(cm.cadastro,'%d/%m/%Y') as cadastro,
                  vs.id as visualizado
                FROM 
                  grupos as gp 
                  INNER JOIN comunicados as cm ON cm.grupos_id = gp.id
                  LEFT JOIN visualizado as vs ON cm.id = vs.secao_id AND vs.usuario_id = ".getIdUsuario()." AND vs.tipo = 'COMUNICADO'
                WHERE
                  ((gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
                   (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_c'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND cm.compartilhado = 'S')) 
                  AND gp.ativo='S' 
                  AND cm.ativo='S'
                  AND gp.comunicado = 'S' 
                ORDER BY visualizado ASC, cm.cadastro DESC, gp.nome ASC";
    $res = mysql_query("${sql}");
    if(mysql_num_rows($res)):
      echo "<div class=\"panel panel-default\">";
        echo '<div class="panel-heading">Comunicados</div>';
        echo "<div class=\"list-group\">";
          while ($ln = mysql_fetch_assoc($res)):
            $badge = (empty($ln['visualizado']))? '<span class="badge" style="background: #d2322d;">Novo</span>' : '';
            echo '<a href="index.php?op=mostra_comunicado&comunicado='.$ln['id'].'" class="list-group-item">'.$badge.'Grupo: '.$ln['grupo'].' | '.$ln['cadastro'].' - <b>'.$ln['titulo'] . '</b><br><small>'.$ln['descricao'] .'</small>'.'</a>';
          endwhile;
        echo "</div>";
      echo "</div>";
    endif;
?>