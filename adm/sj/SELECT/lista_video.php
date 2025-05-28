<?
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $url = array();
  $ordem = '';
  $ordemSQL = '';
  $urlPaginacao='';
  $urlOrderTopico = '';
  $urlOrderData = '';
  $urlGrid = '';
  
  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('vd_pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('vd_ordem_topico', 'at.titulo');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('vd_ordem_data', 'at.cadastro');
  $ordem_dataParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $gridType = getGridType('tipo_list');

  $url = getUrlParams(array('at_ordem_topico', 'at_ordem_data', 'ft_ordem_topico', 'ft_ordem_data', 'vd_ordem_topico', 'vd_ordem_data', 'lv_ordem_topico', 'lv_ordem_data'));
  $urlGrid = getUrl($url);

  $url = getUrlParams(array($fieldPag));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'at.cadastro DESC, gp.nome ASC, tp.nome ASC, at.titulo ASC');
  
  $sql = "SELECT
            CONCAT('/arquivo_site/',gp.diretorio,'/topicos/',tp.diretorio,'/videos/',at.diretorio,'/',vd.foto) as foto,
            vd.foto as capa,
            gp.nome as grupo, 
            tp.nome as assunto, 
            at.id, 
            at.titulo, 
            DATE_FORMAT(at.cadastro, '%d/%m/%Y') as cadastro
          FROM
            grupos as gp 
            INNER JOIN topicos as tp ON tp.id_grupo  = gp.id
            INNER JOIN galerias_video as at ON at.id_topico = tp.id
            INNER JOIN videos vd ON vd.galerias_id = at.id
          WHERE
              ((gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
              ( gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'].") AND 
              gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND at.compartilhado = 'S' )) AND 
              tp.id = ${iTopico} AND
              gp.ativo = 'S' AND
              tp.ativo = 'S' AND
              at.ativo = 'S'
              group by vd.galerias_id";
  $query = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}");
  if(mysql_num_rows($query)):
    $rows = 1;
?>
    <div id="3" class="tab-pane">
      <div class="well well-sm grid-toolbar">
        <div class="row">
          <div class="col-xs-4 col-sm-6 col-md-8 col-lg-10">
            <div class="btn-group">
              <a href="?<?="${urlGrid}&tipo_list=B&aba=3";?>" class="btn btn-info <?=getActiveNav($tipoList,'B',0);?>"><span class="glyphicon glyphicon-th"></span></a></li>
              <a href="?<?="${urlGrid}&tipo_list=T&aba=3";?>" class="btn btn-info <?=getActiveNav($tipoList,'T',0);?>"><span class="glyphicon glyphicon-align-justify"></span></a></li>
              <a href="?<?="${urlGrid}&tipo_list=L&aba=3";?>" class="btn btn-info <?=getActiveNav($tipoList,'L',0);?>"><span class="glyphicon glyphicon-list"></span></a></li>
            </div>
          </div>
          <div class="col-xs-8 col-sm-6 col-md-4 col-lg-2">
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                Ordernar por <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?<?="${urlGrid}&aba=3&vd_ordem_topico=${ordem_topicoParametro}";?>">Título <span class="glyphicon <?=($ordem_topicoParametro =='A')?'glyphicon-sort-by-alphabet':'glyphicon-sort-by-alphabet-alt';?>"></span></a></li>
                <li><a href="?<?="${urlGrid}&aba=3&vd_ordem_data=${ordem_dataParametro}";?>">Data <span class="glyphicon <?=($ordem_dataParametro =='A')?'glyphicon-sort-by-attributes-alt':'glyphicon-sort-by-attributes';?>"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="row">
        <? $urlLink = '?op=mostra_galeria_video&galeria='; ?>
        <? $typeColor = 'info'; ?>
        <? require 'includes/html/grid.inc.php';?>
      </div>
      <? require('paginacao_sql.php'); ?>
    </div>
<?php
  else:
    echo '<script>
            $("a[href=\'#3\']").parent("li").remove();
          </script>';
  endif;
?>
