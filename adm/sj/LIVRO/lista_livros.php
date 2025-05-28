<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_cadastro', 'cadastrado', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_grupo', 'gp.nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_topico', 'tp.nome', 'A');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_titulo', 'titulo', 'A');
  $ordem_tituloParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_topico', 'ordem_titulo', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'cadastrado DESC, grupo ASC');

  $isSearch = getParam('search');

  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading"> Livros </div>
    <div class="panel-body">
      <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" id="pesquisa" role="form">
        <input type="hidden" name="op" value="<?=getParam('op');?>">
        <div class="row">
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <? $params = array('class'=>"form-control search-topic-ajax", 'data-fill'=>"topico");?>
            <? require('includes/html/select/select-group.php'); ?>
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <?=$form->select('topico', null, null, array('id'=>'topico', 'class'=>'form-control'), '-');?>
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <?=$form->input('text','titulo', getParam('titulo'), array('class'=>'form-control','placeholder'=>'Pesquisar Título'));?>
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <div class="btn-group">
              <?=$form->input('submit','search', 'Pesquisar', array('class'=>'btn btn-info'));?>
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
            <th><a href="?<?=$urlCompleta.'&ordem_grupo='.$ordem_grupoParametro;?>">Grupo</a> <?=getIcoOrder('ordem_grupo')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_topico='.$ordem_topicoParametro;?>">Tópico</a> <?=getIcoOrder('ordem_topico')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_titulo='.$ordem_tituloParametro;?>">Título</a> <?=getIcoOrder('ordem_titulo')?></th>
            <th>Descricão</th>
            <th width="150"><a href="?<?=$urlCompleta.'&ordem_cadastro='.$ordem_cadastroParametro;?>">Cadastrado <?=getIcoOrder('ordem_cadastro')?></a></th>
            <th width="100">AÇ</th>
            <th>AT</th>
            <th>CP</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $w = array();
          if($isSearch):
            $grupo = (int)getParam('grupo');
            $topico = (int)getParam('topico');
            $titulo = getParam('titulo');
            if(!empty($grupo)) $w[] = "gp.id = ${grupo}";
            if(!empty($topico)) $w[] = "tp.id = ${topico}";
            if(!empty($titulo)) $w[] = "lv.titulo like \"%${titulo}%\"";
          endif;
          if(!empty($w))
            $w = ' WHERE '.implode(' AND ', $w);
          else
            $w = '';
          
          $sql = "SELECT
                    gp.id as id_grupo,
                    gp.nome as grupo,
                    tp.id as id_topico,
                    tp.nome as topico,
                    lv.id, 
                    lv.titulo, 
                    lv.descricao, 
                    date_format(lv.cadastrado, '%d/%m/%Y ás %h:%i') as cadastro,
                    lv.ativo,
                    lv.compartilhado
                  FROM 
                    grupos gp
                    INNER JOIN topicos tp ON tp.id_grupo = gp.id
                    INNER JOIN livros lv ON tp.id = lv.id_topico
                    $w";
          $query = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}") or die(mysql_error());
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
        ?>
              <tr>
                <td nowrap><?='(cod. '.$ln['id_grupo'].') - '.$ln['grupo']; ?></td>
                <td nowrap><?='(cod. '.$ln['id_topico'].') - '.$ln['topico']; ?></td>
                <td><?=$ln['titulo'];?></td>
                <td><?=substr($ln['descricao'], 0, 200);?>...</td>
                <td><?=$ln['cadastro'];?></td>
                <td>
                  <a href="?op=cad_livro&id=<?=$ln['id'];?>&grupo=<?=$ln['id_grupo'];?>&topico=<?=$ln['id_topico'];?>" class="btn btn-warning btn-xs">
                    <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="?op=excluir_livro&id=<?=$ln['id'];?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir o livro <?=str_replace(array('\'', '"'), '', $ln['titulo']);?>?' );">
                    <span class="glyphicon glyphicon-remove"></span>
                  </a>
                  <a href="?op=clonar_livro&op1=<?=$ln['id']?>" class="btn btn-primary btn-xs" title="Clonar Livro">
                    <span class="glyphicon glyphicon-tags"></span>
                  </a>
                </td>
                <td align="center">
                  <?php
                    switch($ln['ativo']):
                      case 'S':
                        echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="LIVRO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N" data-tp="1"/>';
                        break;
                      case 'N':
                        echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="LIVRO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S" data-tp="1"/>';
                        break;
                    endswitch;
                  ?>
                </td>                 
                <td align="center">
                  <?php
                    switch($ln['compartilhado']):
                    case 'S':
                      echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="LIVRO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="N" data-tp="2"/>';
                      break;
                    case 'N':
                      echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="LIVRO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="S" data-tp="2"/>';
                      break;
                    endswitch;
                  ?>
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
      <li class="list-group-item">AÇ - Ação para editar o registro.</li>
      <li class="list-group-item">AT - Registro está ativo.</li>
      <li class="list-group-item">CP - Compartilhado com outros grupo.</li>
    </ul>
  </div>