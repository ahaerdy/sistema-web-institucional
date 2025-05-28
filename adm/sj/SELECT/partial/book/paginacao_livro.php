<?php
  $query = mysql_query("SELECT lv.id, cp.id as sessao, pg.numero, cp.paginado FROM livros lv INNER JOIN capitulos cp ON cp.id_livro = lv.id INNER JOIN paginas pg ON pg.id_capitulo = cp.id WHERE ${wPg1}");
  if(mysql_num_rows($query)):
    $ini = ($idPagina-3);
    $ini = ( ($ini) >= 0 )? $ini : 0 ;
    echo '<div class="row">';
      echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
        echo '<div class="pull-right">';
          echo '<ul class="pagination" style="margin-top: 0">';
            $ul = array();
            $i = 0;
            $count = 0;
            while( $ln = mysql_fetch_assoc($query) ):
              if($idSessao == $ln['sessao']):
                if($ln['paginado'] == 'SIM'):
                  if($i == 0) echo '<li><a href="/adm/sj/index.php?op=mostra_livro&livro='.$ln['id'].'&sessao='.$ln['sessao'].'&pagina='.$ln['numero'].'&paginacao=0'.$urlCompleta.'">Primeira página</a></li>';
                  if($i >= $ini && $i <= ($idPagina+1)):
                    $curr = ($idPagina == $ln['numero']) ? 'class="active"' : '';
                    echo '<li '.$curr.'><a href="/adm/sj/index.php?op=mostra_livro&livro='.$ln['id'].'&sessao='.$ln['sessao'].'&pagina='.$ln['numero'].'&paginacao='.$count.$urlCompleta.'">'.$ln['numero'].'</a></li>';
                  endif;
                  $i++;
                  $ul = array($ln, $count);
                endif;
              endif;
              $count++;
            endwhile;
            if(!empty($ul))
              echo '<li><a href="/adm/sj/index.php?op=mostra_livro&livro='.$ul[0]['id'].'&sessao='.$ul[0]['sessao'].'&pagina='.$ul[0]['numero'].'&paginacao='.$ul[1].$urlCompleta.'">Ultima página</a></li>';
          echo '</ul>';
        echo '</div>';
      echo '</div>';
    echo '</div>';
?>
<form class="form-horizontal" role="form" id="abrir-pagina">
  <div class="form-group">
    <label for="sessao" class="col-sm-6 control-label">Sessão:</label>
    <div class="col-sm-6">
      <select name="sessao2" class="form-control">
        <? mysql_data_seek($qrSessao,0); ?>
        <? while ( $ln3 = mysql_fetch_assoc($qrSessao) ): ?>
            <option value="<?=$ln3['id']?>" <?=($ln2['id_sessao'] == $ln3['id'])? 'selected="selected"' : ''; ?>><?=$ln3['sessao']?></option>
        <? endwhile; ?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="sessao" class="col-sm-6 control-label">Abrir página nº:</label>
    <div class="col-sm-6">
      <div class="input-group">
        <input type="text" name="pagina" class="form-control"/>
        <span class="input-group-btn">
          <input type="submit" name="" value="Visualizar" class="btn btn-info btn-block" style="padding-left: 5px; padding-right: 5px;"/>
        </span>
      </div>
    </div>
  </div>
</form>
<? endif; ?>
