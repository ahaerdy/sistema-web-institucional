<div class="panel panel-default">
  <div class="panel-heading">Permissões de livros</div>
  <div class="panel-body">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="get" id="pesquisa">
      <input type="hidden" name="op" value="permissao_livro">
      <input type="hidden" name="usuario" value="<?=$id_usuario;?>">
      <div class="row">
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
          <input type="text" name="nome" value="<?=$_GET['nome'];?>" placeholder="Pesquisar Livro" class="form-control">
        </div>
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
          <div class="btn-group">
            <input type="submit" name="search" value="Pesquisar" class="btn btn-info">
            <?php if($isSearch): ?>
              <a href="<?=$_SERVER['PHP_SELF'].'?op='.getParam('op');?>" class="btn btn-warning">Limpar Pesquisa</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
      <form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" id="form">
        <tr>
          <th width="10%">Grupo</th>
          <th width="10%">Tópico</th>
          <th>Livro</th>
          <th width="180">Permissão</th>
        </tr>
        <tbody>
          <?php
            $qnt = QTD_ITEM_PAGINATOR;
            $paramsPaginator = getPaginatorCalc('pagina', $qnt);
            $currentPageNumber = $paramsPaginator['current_page_number'];
            $start = $paramsPaginator['start'];

            $nome = getParam('nome');
            if(!empty($nome))
              $w = "lv.titulo like\"%${nome}%\" AND ";
            $sql = "SELECT
                      gp.nome as grupo,
                      tp.nome as topico,
                      lv.id,
                      lv.titulo,
                      lp.permissao
                    FROM
                      grupos gp
                      INNER JOIN topicos tp ON tp.id_grupo = gp.id 
                      INNER JOIN livros lv ON  lv.id_topico = tp.id
                      LEFT JOIN tbl_livro_permissao lp ON (lp.id_livro = lv.id AND lp.id_usuario = ${id_usuario})
                    WHERE
                      $w ( (gp.id IN (${todos_id_le})) OR (gp.id IN (${todos_id_us}) AND gp.id NOT IN (${todos_id_le}) AND lv.compartilhado = 'S') )";
            $res = mysql_query("${sql} LIMIT ${start}, ${qnt}");
            while( $ln = mysql_fetch_assoc($res) ):
          ?>
              <tr>
                <td><?=$ln['grupo'];?></td>
                <td><?=$ln['topico'];?></td>
                <td><?=$ln['titulo'];?></td>
                <td>
                  TL  <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == 'T')?  'checked="checked"' : ''; ?> value="T" title="TOTAL">
                  PC  <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == 'P')?  'checked="checked"' : ''; ?> value="P" title="PARCIAL">
                  TR  <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == 'TR')? 'checked="checked"' : ''; ?> value="TR" title="TRECHO">
                  PCL <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == '')? 'checked="checked"' : ''; ?> value="" title="PERMISSÃO PELO CADASTRO DO LIVRO">
                </td>
              </tr>
          <? endwhile; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan='5'><br/><input type="submit" name="submit_permissao" value="Salvar Permissão"><br/><br/></td>
          </tr>
        </tfoot>
      </form>
    </table>
  </div>
  <div class="panel-footer">
    <?php require('paginacao_sql.php'); ?>
  </div>
</div>