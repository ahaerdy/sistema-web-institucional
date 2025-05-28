<?php validaGrupo(); ?>
<?php if (getIdUsuario() > '3'): ?>
  <?php
    $idLeituraTotal = $_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_le'];
    $idLeituraTotal = explode(',', $idLeituraTotal);
    if(empty($_SESSION['login']['iGrupo']) && !(int)$_SESSION['login']['iGrupo']):
      $w1 = " gp.id  = ".$_SESSION['login']['usuario']['grupo_inicial'];
      $w2 = " ((gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
               (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_a'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND at.compartilhado = 'S')) AND ";
    else:
      $w1 = ' gp.id  = '.(int)$_SESSION['login']['iGrupo'];
      $w2 = " ((gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
               (gp.id IN (".$_SESSION['login']['usuario']['todos_id_dep_a'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND at.compartilhado = 'S')) AND ";
    endif;
    $query = mysql_query("SELECT
                              gp.nome      as grupo,
                              gp.diretorio as gp_diretorio,
                              tp.diretorio as tp_diretorio,
                              at.diretorio as at_diretorio,
                              at.id        as at_id,
                              at.titulo    as at_nome,
                              at.texto     as at_descricao,
                              at.capa      as at_capa,
                              date_format(at.cadastro,'%d/%m/%Y') as at_cadastro
                            FROM 
                              grupos  gp
                              INNER JOIN topicos tp ON tp.id_grupo = gp.id 
                              INNER JOIN artigos at ON at.id_topico = tp.id 
                            WHERE
                              ${w1} AND 
                              ${w2}
                              gp.ativo = 'S' AND 
                              tp.ativo = 'S' AND 
                              at.ativo = 'S' AND 
                              at.home  = 'S'
                            ORDER BY at_cadastro DESC 
                            LIMIT 1") or die(mysql_error());
    if(mysql_num_rows($query)):

      while ($ln = mysql_fetch_assoc($query)):
        /* echo '<div class="page-header title-article">
                <h2>Grupo <small>('.$ln['grupo'].')</small></h2>
              </div>'; 
        */
        if ($ln['at_id']==112) { 
          $_SESSION['RF']["subfolder"] = 'FTP_COAM';
          $_SESSION['RF']["bloqueia_COAM"] = true; 
        }              
        
        if ($ln['at_id']==1265) { 
           $_SESSION['RF']["subfolder"] = 'SIGNATURA';
           $_SESSION['RF']["bloqueia_SIGNATURA"] = true; 
         }

        if ($ln['at_id']==2398) { 
           $_SESSION['RF']["subfolder"] = 'CEGME';
           $_SESSION['RF']["bloqueia_CEGME"] = true; 
         }

         if ($ln['at_id']==2429) { 
           $_SESSION['RF']["subfolder"] = 'AURORA';
           $_SESSION['RF']["bloqueia_AURORA"] = true; 
         }

         if ($ln['at_id']==2556) { 
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

        echo $ln['at_descricao'];
        echo '<hr>';
        // echo '<p>postado: '.$ln['at_cadastro'].'</p>';
      endwhile;
       
    else:
      echo 'Nenhum artigo disponível!';
    endif;
  else:
    require('pag_inicial_2.php');
  endif;
?>


