<?php

  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $iAtigo = (int) getParam('artigo');
  if($iAtigo):
    $query = mysql_query("SELECT at.*, tp.id as id_topico, date_format(at.cadastro,'%d/%m/%Y') as cadastro FROM 
                          grupos gp 
                          INNER JOIN topicos tp ON tp.id_grupo = gp.id
                          INNER JOIN artigos at ON at.id_topico = tp.id 
                          WHERE
                            ((gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") ) OR 
                            ( gp.id IN (" . $_SESSION['login']['usuario']['todos_id_dep_a'] . ") AND gp.id NOT IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") AND at.compartilhado = 'S' )) AND 
                            at.id = $iAtigo AND 
                            gp.ativo = 'S' AND 
                            tp.ativo = 'S' AND 
                            at.ativo = 'S'");
    if(mysql_num_rows($query)):
      $ln = mysql_fetch_assoc($query);
      $params['usuario_id'] = getIdUsuario();
      $params['artigo_id'] = getParam('artigo');

      
      if ($params['artigo_id']==112) {
          $_SESSION['RF']["subfolder"] = 'FTP_COAM';
          $_SESSION['RF']["bloqueia_COAM"] = true;
      }

      if ($params['artigo_id']==1265) {
          $_SESSION['RF']["subfolder"] = 'SIGNATURA';
          $_SESSION['RF']["bloqueia_SIGNATURA"] = true;
      }

      if ($params['artigo_id']==2398) {
          $_SESSION['RF']["subfolder"] = 'CEGME';
          $_SESSION['RF']["bloqueia_CEGME"] = true;
      }

      if ($params['artigo_id']==2429) {
          $_SESSION['RF']["subfolder"] = 'AURORA';
          $_SESSION['RF']["bloqueia_CEGME"] = true;
      }

      if ($params['artigo_id']==2556) {
          $_SESSION['RF']["subfolder"] = 'PLANTAS_MEDICINAIS';
          $_SESSION['RF']["bloqueia_PLANTAS_MEDICINAIS"] = true;
      }

      if ($ln['at_id']==2628) { 
           $_SESSION['RF']["subfolder"] = 'VIAGEM_A_ISRAEL';
           $_SESSION['RF']["bloqueia_VIAGEM_A_ISRAEL"] = true; 
         }

      if ($ln['at_id']==2703) { 
           $_SESSION['RF']["subfolder"] = 'ESTUDOS_BIBLICOS';
           $_SESSION['RF']["bloqueia_ESTUDOS_BIBLICOS"] = true; 
         }


      setLogAtividade($params);
      echo '<div class="pull-right">'.$ln['cadastro'].'</div>';
      echo '<div class="clearfix"></div>';
      echo '<div class="page-header title-article">';
        echo '<h2>'.$ln['titulo'].'</h2>';
      echo '</div>';
      echo '<div class="artigo-texto">'.stripslashes(($ln['texto'])).'</div>';
      echo '<hr>';
      $res = mysql_query("SELECT at.id, at.titulo, date_format(at.cadastro,'%d/%m/%Y') as cadastro
                                      FROM 
                                      grupos gp 
                                      INNER JOIN topicos tp ON tp.id_grupo = gp.id
                                      INNER JOIN artigos at ON at.id_topico = tp.id 
                                      WHERE
                                        ((gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") ) OR 
                                        ( gp.id IN (" . $_SESSION['login']['usuario']['todos_id_dep_a'] . ") AND gp.id NOT IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") AND at.compartilhado = 'S' )) AND 
                                        tp.id = ".$ln['id_topico']." AND 
                                        at.id != $iAtigo AND 
                                        gp.ativo = 'S' AND 
                                        tp.ativo = 'S' AND 
                                        at.ativo = 'S' LIMIT 5");
      if(mysql_num_rows($res)):
        echo '<div class="panel panel-default">';
          echo '<div class="panel-heading">Outros Artigos</div>';
          echo '<div class="list-group">';
            while ($ln = mysql_fetch_assoc($res)):
              echo '<a href="index.php?op=mostra_artigo&artigo='.$ln['id'].'" class="list-group-item">'.$ln['cadastro'].' - '.$ln['titulo'] .'</a>';
            endwhile;
          echo '</div>';
        echo '</div>';
      endif;
    else:
      echo '<div class="page-header"><h3>Artigo não encontrado!</h3></div>';
    endif;
  else: 
?>
    <div class="box">
      <div class="box-esp">
        <div class="tit-azul">ARTIGOS</div>
        <div class="h20px"></div>
        <div class="box-content">
          <?php
            $query = mysql_query("SELECT at.id, at.titulo, date_format(at.cadastro,'%d/%m/%Y') as cadastro 
                                  FROM 
                                  grupos gp 
                                  INNER JOIN topicos tp ON tp.id_grupo = gp.id
                                  INNER JOIN artigos at ON at.id_topico = tp.id 
                                  WHERE
                                    ((gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") ) OR 
                                    ( gp.id IN (" . $_SESSION['login']['usuario']['todos_id_dep_a'] . ") AND gp.id NOT IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") AND at.compartilhado = 'S' )) AND 
                                    gp.ativo = 'S' AND 
                                    tp.ativo = 'S' AND 
                                    at.ativo = 'S'
                                  ORDER BY
                                    at.cadastro DESC");
            if( mysql_num_rows($query) ):
              $ln = mysql_fetch_assoc($query);
              echo '<li><a href="index.php?op=mostra_artigo&artigo='.$ln['id'].'&'.strtolower((str_replace(' ', '-', $ln['titulo']))).'">'.($ln['titulo']).' - <b>postado: '.$ln['cadastro'].'</b></a></li>';
              echo '<div class="clear h10px"></div>';
            else:
              echo 'Nenhum artigo disponível!';
            endif;
          ?>
        <div class="clear h20px"></div>
       </div>
      </div>
    </div>
<?php 
  endif;
?>