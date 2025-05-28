<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_cadastro', 'data_ingresso', 'A');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_codigo', 'id', 'A');
  $ordem_codigoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_nome', 'nome', 'A');
  $ordem_nomeParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_matricula', 'matricula', 'A');
  $ordem_matriculaParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  
  $url = getUrlParams(array('ordem_codigo', 'ordem_nome', 'ordem_matricula', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'nome ASC');

  $isSearch = getParam('search');
?>
  <div class="panel panel-default">
    <div class="panel-heading"> Usuários </div>
    <div class="panel-body">
      <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" id="pesquisa" role="form">
        <input type="hidden" name="op" value="<?=getParam('op');?>">
        <div class="row">
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <input type="text" name="codigo" value="<?=getParam('codigo');?>" placeholder="Pesquisar Código" class="form-control">
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <input type="text" name="nome" value="<?=getParam('nome');?>" placeholder="Pesquisar Nome" class="form-control">
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <input type="text" name="matricula" value="<?=getParam('matricula');?>" placeholder="Pesquisar Matrícula" class="form-control">
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
        <thead>
          <tr>
            <th><a href="<?="?${urlCompleta}&ordem_codigo=${ordem_codigoParametro}";?>">Código</a> <?=getIcoOrder('ordem_codigo');?></th>
            <th><a href="<?="?${urlCompleta}&ordem_nome=${ordem_nomeParametro}";?>">Nome</a> <?=getIcoOrder('ordem_nome');?></th>
            <th>Cidade / Estado</th>
            <th><a href="<?="?${urlCompleta}&ordem_matricula=${ordem_matriculaParametro}";?>">Matrícula</a> <?=getIcoOrder('ordem_matricula');?></th>
            <th><a href="<?="?${urlCompleta}&ordem_cadastro=${ordem_cadastroParametro}";?>">Cadastrado</a> <?=getIcoOrder('ordem_cadastro');?></th>
            <?php if($ln["id"] > 2): ?>
              <th>PL</th>
            <?php endif; ?>
            <th>AÇ</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $w = array();
          if($isSearch):
            $codigo = (int)getParam('codigo');
            $nome = getParam('nome');
            $matricula = getParam('matricula');
            if(!empty($codigo))    $w[] = "id = ${codigo}";
            if(!empty($nome))      $w[] = "nome like \"%${nome}%\"";
            if(!empty($matricula)) $w[] = "matricula like \"%${matricula}%\"";
          endif;
          if(!empty($w))
            $w = ' AND '.implode(' AND ', $w);
          else
            $w = '';

          $sql = "SELECT id,nome,matricula,cidade,estado,DATE_FORMAT(data_ingresso, '%d/%m/%Y ás %H:%i') AS data_i FROM usuarios WHERE id > 2 ${w}";
          $query = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}") or die(mysql_error());
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
        ?>
              <tr>
                <td><?=$ln["id"];?></td>
                <td><?=$ln["nome"];?></td>
                <td><?=$ln["cidade"];?> / <?=$ln["estado"];?></td>
                <td><?=$ln["matricula"];?></td>
                <td><?=$ln["data_i"];?></td>
                <?php if($ln["id"] > 2): ?>
                <td>
                  <a href="index.php?op=permissao_livro&usuario=<?=$ln["id"];?>" class="btn btn-info btn-xs">
                    <span class="glyphicon glyphicon-book"></span>
                  </a>
                </td>
                <?php endif; ?>
                <td>
                  <a href="index.php?op=alte_usua&op1=<?=$ln["id"];?>" class="btn btn-warning btn-xs">
                    <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <?php if($ln["id"] > 2): ?>
                    <a href="?op=exclui_usu&op1=<?=$ln["id"];?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir este usuário \n (<?=$ln['nome'];?>)?' );">
                      <span class="glyphicon glyphicon-remove"></span>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
          <?php
              endwhile;
            endif;
          ?>
        </tbody>
      </table>
    </div>
    <div class="panel-footer">
      <?php require('paginacao_sql.php'); ?>
    </div>
    <ul class="list-group">
      <li class="list-group-item">PL - Ação para editar a permissão de livros.</li>
      <li class="list-group-item">PG - Ação para editar o financeiro.</li>
      <li class="list-group-item">AÇ - Ação para editar o registro.</li>
    </ul>
  </div>  