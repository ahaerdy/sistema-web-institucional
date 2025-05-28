<div class="row">
  <div class="col-lg-12">
    <form class="form-horizontal" role="form">
      <div class="form-group">
        <label for="sessao" class="col-sm-1 col-md-offset-6 control-label">Sessão:</label>
        <div class="col-sm-3">
          <select name="sessao" class="form-control">
            <? while ( $ln3 = mysql_fetch_assoc($qrSessao) ): ?>
                <option value="<?=$ln3['id']?>" <?=($ln2['id_sessao'] == $ln3['id'])? 'selected="selected"' : ''; ?>><?=$ln3['sessao']?></option>
            <? endwhile; ?>
          </select>
        </div>
        <div class="col-sm-2">
          <a href="/adm/sj/index.php?op=mostra_prefacio&livro=<?=$idLivro;?>" class="btn btn-info btn-block">Dados Técnicos do Livro</a>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default book-content">
      <div class="panel-body" style="padding: 15px 70px;">
        <?=$texto;?>
      </div>
    </div>
  </div>
</div>

<?php
  $url = array();
  $urlCompleta = '';
  $bTipo = getParam('b_tipo');
  if(!empty($palavra  )){ $url[] = "b_palavra=${palavra}"; }
  if(!empty($ocorencia)){ $url[] = "ocorencia=${ocorencia}"; }
  if( !empty($url) )
    $urlCompleta = '&' . implode('&', $url);
  $idSessao = ($idSessao)? $idSessao : $ln2['id_sessao'];
  $idPagina = ($idPagina)? $idPagina : $ln2['numero'];
  $wPg  = "lv.id = ${idLivro} AND cp.id = ${idSessao}";
  $wPg1 = "lv.id = ${idLivro} ORDER BY cp.ordem ASC, pg.numero ASC";
  $inicio  = ($paginacao) ? $paginacao : 0;
  $inicio1 = ($inicio == 0)? 0 : $inicio - 1;
  $fim = ($inicio == 0)? 2 : 3;
  $inicio2 = $inicio + 1;
  $res = mysql_query("SELECT
                        lv.id, cp.id as sessao, pg.numero
                      FROM
                        livros lv
                        INNER JOIN capitulos cp ON cp.id_livro = lv.id
                        INNER JOIN paginas pg   ON pg.id_capitulo = cp.id
                      WHERE ${wPg1} LIMIT ${inicio1}, $fim") or die(mysql_error());
  while($ln = mysql_fetch_assoc($res)):
    ++$i;
    if($i == 1 && $inicio > 0):
      echo "<div class='arrow-pagination arrow-pagination-left'>";
        echo '<a href="/adm/sj/index.php?op=mostra_livro&livro='.$ln['id'].'&sessao='.$ln['sessao'].'&pagina='.$ln['numero']."&paginacao=${inicio1}&b_tipo=".$bTipo."&b_palavra=".getParam('b_palavra')."\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>";
      echo '</div>';
    endif;
    if($i == $fim):
      echo "<div class='arrow-pagination arrow-pagination-right'>";
        echo '<a href="/adm/sj/index.php?op=mostra_livro&livro='.$ln['id'].'&sessao='.$ln['sessao'].'&pagina='.$ln['numero']."&paginacao=${inicio2}&b_tipo=".$bTipo."&b_palavra=".getParam('b_palavra')."\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
      echo '</div>';
    endif;
  endwhile;
?>
<div class="row">
  <div class="col-lg-6">
    <?php require "description_book.php"; ?>
  </div>
  <div class="col-lg-6">
    <?php require "paginacao_livro.php"; ?>
  </div>
</div>
