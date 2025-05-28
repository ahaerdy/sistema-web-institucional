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
                  AND cm.id = ${iComunicado}";
      $res = mysql_query("${sql}");
      if(mysql_num_rows($res)):
        $ln = mysql_fetch_assoc($res);
      echo '<div class="pull-right">'.$ln['cadastro'].'</div>';
      echo '<div class="clearfix"></div>';
      echo '<div class="page-header title-comunication">';
        echo '<h2>'.$ln['titulo'].'</h2>';
      echo '</div>';
        echo '<div class="">'.$ln['texto'].'</div>';
      endif;
    else:
      echo '<h3 style="text-align:center;">Conteúdo indisponível!</h3>';
    endif;
?>