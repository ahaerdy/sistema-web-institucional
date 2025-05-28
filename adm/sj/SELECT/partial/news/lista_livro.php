<?
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $url = array();
  $ordem = '';
  $ordemSQL = '';
  $urlPaginacao='';
  $urlOrderTopico = '';
  $urlOrderData = '';
  $urlGrid = '';
  $inicio = '';
  
  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('lv_pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('lv_ordem_topico', 'lv.titulo');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('lv_ordem_data', 'lv.cadastrado');
  $ordem_dataParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $gridType = getGridType('tipo_list', $tipoList);

  $url = getUrlParams(array('at_ordem_topico', 'at_ordem_data', 'ft_ordem_topico', 'ft_ordem_data', 'vd_ordem_topico', 'vd_ordem_data', 'lv_ordem_topico', 'lv_ordem_data'));
  $urlGrid = getUrl($url);
  $url = getUrlParams(array($fieldPag));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'lv.cadastrado DESC, gp.nome ASC, tp.nome ASC, lv.titulo ASC');

  $sql = "SELECT 
              gp.nome as grupo, 
              tp.nome as assunto,
              lv.foto as capa,
              CONCAT('/arquivo_site/',gp.diretorio,'/topicos/',tp.diretorio,'/livros/',lv.foto) as foto,
              lv.id,
              lv.titulo,
              lv.permissao as lv_permissao,
              lp.permissao as lp_permissao, 
              DATE_FORMAT(lv.cadastrado, '%d/%m/%Y') as cadastro
          FROM
            grupos as gp 
          INNER JOIN topicos as tp ON tp.id_grupo = gp.id
          INNER JOIN livros as lv ON lv.id_topico = tp.id
          LEFT JOIN tbl_livro_permissao lp ON lp.id = ( SELECT 
                                                          id
                                                        FROM 
                                                          tbl_livro_permissao lp2
                                                        WHERE 
                                                          lp2.id_livro = lv.id AND (lp2.id_usuario = ".getIdUsuario()." OR lp2.id_grupo = gp.id) 
                                                        ORDER BY 
                                                          lp2.id_usuario IS NULL ASC 
                                                        LIMIT 1)
          WHERE
              (( gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
              ( gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND lv.compartilhado = 'S' )) AND 
              gp.ativo = 'S' AND 
              tp.ativo = 'S' AND 
              lv.ativo = 'S'
          ORDER BY ${ordem}";

  $query = mysql_query("${sql} LIMIT 20");

  if(mysql_num_rows($query) > 0):
  $rows = 1;
?>
    <div id="4" class="tab-pane">
      <div class="well well-sm grid-toolbar">
        <div class="row">
          <div class="col-xs-4 col-sm-6 col-md-8 col-lg-10">
            <div class="btn-group">
              <a href="?<?="${urlGrid}&tipo_list=B&aba=4";?>" class="btn btn-warning <?=getActiveNav($tipoList,'B',0);?>"><span class="glyphicon glyphicon-th"></span></a></li>
              <a href="?<?="${urlGrid}&tipo_list=T&aba=4";?>" class="btn btn-warning <?=getActiveNav($tipoList,'T',0);?>"><span class="glyphicon glyphicon-align-justify"></span></a></li>
              <a href="?<?="${urlGrid}&tipo_list=L&aba=4";?>" class="btn btn-warning <?=getActiveNav($tipoList,'L',0);?>"><span class="glyphicon glyphicon-list"></span></a></li>
            </div>
          </div>
          <div class="col-xs-8 col-sm-6 col-md-4 col-lg-2">
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                Ordernar por <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?<?="${urlGrid}&aba=4&lv_ordem_topico=${ordem_topicoParametro}";?>">Título <span class="glyphicon <?=($ordem_topicoParametro =='A')?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt';?>"></span></a></li>
                <li><a href="?<?="${urlGrid}&aba=4&lv_ordem_data=${ordem_dataParametro}";?>">Data <span class="glyphicon <?=($ordem_dataParametro =='A')?'glyphicon-sort-by-attributes-alt':'glyphicon-sort-by-attributes';?>"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="row">
        <? $urlLink = '?op=mostra_livro&livro='; ?>
        <? $typeColor = 'warning'; ?>
        <? require 'includes/html/grid.inc.php';?>
      </div>
      <? //require('paginacao_sql.php'); ?>
    </div>
<? else:  
    echo '<script>
            $("a[href=\'#4\']").parent("li").remove();
          </script>';
  endif; 
?>