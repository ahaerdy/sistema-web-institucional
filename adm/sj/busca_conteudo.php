<? if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>

  <?php
    $params['usuario_id'] = getIdUsuario();
    $params['palavra'] = getParam('b_palavra');
    setLogAtividade($params);
  ?>

  <? require('includes/busca_sql.php'); ?>

  <div class="panel panel-success">
    <div class="panel-heading">
      Pesquisa Avançada 
      <div class="pull-right toggle-advance-search" id="toggle-advance-search"  data-element=".advance-search-body">
        <span class="glyphicon glyphicon-chevron-up"></span>
      </div>
    </div>
    <div class="panel-body advance-search-body" style="padding-bottom: 0;">
      <?require('includes/busca_select.php');?>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-hover search-table">
      <thead>
        <tr>
          <th></th>
          <th><a href="<?="?${urlCompleta}&ordem_cadastro=${ordem_cadastroParametro}";?>">Data</a><?=getIcoOrder('ordem_cadastro')?></th>
          <th><a href="<?="?${urlCompleta}&ordem_sessao=${ordem_sessaoParametro}";?>">Seção</a><?=getIcoOrder('ordem_sessao')?></th>
          <th><a href="<?="?${urlCompleta}&ordem_titulo=${ordem_tituloParametro}";?>">Título</a><?=getIcoOrder('ordem_titulo')?></th>
          <th><a href="<?="?${urlCompleta}&ordem_grupo=${ordem_grupoParametro}";?>">Grupo</a><?=getIcoOrder('ordem_grupo')?></th>
          <th><a href="<?="?${urlCompleta}&ordem_topico=${ordem_topicoParametro}";?>">Assunto / Tópico / Pastas</a><?=getIcoOrder('ordem_topico')?></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <? 
          if( $w != array() ):
            $paramUrlSearch = "&b_palavra=${b_palavra}&b_tipo=${b_tipo}";
            $query = mysql_query("$sql $order $limit") or die(mysql_error());
            $x = mysql_num_rows($query);
            --$x;
            for ( $i = 0; $i <= $x;  $i++ ):
              $id = mysql_result($query, $i, 'id');
              switch(mysql_result($query, $i,'tipo')):
                case 'Artigos':
                  $type = 'success';
                  $jsLink = 'link-artigo';
                  $link = '/adm/sj/index.php?op=mostra_artigo&artigo='.$id.$paramUrlSearch;
                  break;
                case 'Fotos':
                  $type = 'danger';
                  $jsLink = 'link-foto';
                  $link = '/adm/sj/index.php?op=mostra_galeria_foto&galeria='.$id.$paramUrlSearch;
                  break;
                case 'Vídeos':
                  $type = 'primary';
                  $jsLink = 'link-video';
                  $link = '/adm/sj/index.php?op=mostra_galeria_video&galeria='.$id.$paramUrlSearch;
                  break;
                default:
                  $type = 'warning';
                  $jsLink = 'link-livro';
                  $link = '';
              endswitch;
              if ( mysql_result($query, $i, 'tipo') == 'Livros' ):
                $pag    = mysql_result($query, $i, 'pagina');
                $sessao = mysql_result($query, $i, 'capitulo');
                $paginas[] = "<a href='index.php?op=mostra_livro&livro=" . $id . "&sessao=${sessao}&pagina=${pag}${paramUrlSearch}' class=\"btn btn-default btn-xs\" style='margin-bottom: 10px;' target='_blank'>${pag}</a>";
                if ( $i < $x ):
                  $z = $i;
                  if( mysql_result($query, ++$z, 'id') == $id ):
                    continue;
                  endif;
                endif;
              endif;
              if( !empty($paginas) ):
                $lk_paginas = '<span class="btn btn-info btn-xs" style="margin-bottom: 10px;">Pagina(s)</span> ' . implode(' ', $paginas);
                $paginas = array();
              endif;
        ?>
              <tr>
                <td>
                  <? if($link): ?>
                    <a href="<?=$link;?>" class="btn btn-<?=$type;?>" target="_blank">Visualizar</a>
                  <? endif; ?>
                </td>
                <td><?=mysql_result($query, $i, 'cadastro');?></td>
                <td><?=mysql_result($query, $i, 'tipo');?></td>
                <td><?=mysql_result($query, $i, 'titulo');?> <br/> <?=$lk_paginas;?></td>
                <td><?=mysql_result($query, $i, 'grupo');?></td>
                <td><?=mysql_result($query, $i, 'topico');?></td>
                <td>
                  <?
                    $pr = '';
                    $lp_permissao = mysql_result($query,$i,'lp_permissao'); 
                    $lv_permissao = mysql_result($query,$i,'lv_permissao');
                    $pr = (empty($lp_permissao)) ? $lv_permissao : $lp_permissao; 

                    switch ($pr):
                      case 'T':
                        echo 'Exibição total.';
                        break;
                      case 'P':
                        echo 'Exibição parcial.';
                        break;
                      case 'TR':
                        echo 'Exibição por trecho.';
                        break;
                      default: 
                        if(mysql_result($query, $i, 'tipo') == 'Livros')
                          echo 'Exibição por trecho.';
                    endswitch;
                  ?>
                </td>
              </tr>
        <?
              $lk_paginas = '';
            endfor;
            if($x == -1):
              echo '<tr><td colspan="7" align="center"><h3>Nenhum registro encontrado!</h3></td></tr>';
            endif;
          else:
            echo '<tr><td colspan="7" align="center"><h3>Nenhum registro encontrado!</h3></td></tr>';
          endif; 
        ?>
      </tbody>
    </table>
  </div>
  
  <? require('paginacao_sql.php'); ?>