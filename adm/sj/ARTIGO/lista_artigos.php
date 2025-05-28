<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_cadastro', 'at.cadastro', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_grupo', 'gp.nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_topico', 'tp.nome', 'A');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_artigo', 'at.titulo', 'A');
  $ordem_artigoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_topico', 'ordem_artigo', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'at.cadastro DESC, gp.nome ASC, tp.nome ASC, at.titulo ASC');

  $isSearch = getParam('search');
  
  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading">Artigos</div>
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
            <?=$form->input('text','artigo', getParam('artigo'), array('class'=>'form-control','placeholder'=>'Pesquisar Artigo'));?>
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
            <th><a href="?<?=$urlCompleta.'&ordem_grupo='.$ordem_grupoParametro;?>">Grupo</a><?=getIcoOrder('ordem_grupo')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_topico='.$ordem_topicoParametro;?>">Assunto/Tópico/Sub-Tópico</a><?=getIcoOrder('ordem_topico')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_artigo='.$ordem_artigoParametro;?>">Artigo</a><?=getIcoOrder('ordem_artigo')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_cadastro='.$ordem_cadastroParametro;?>">Cadastrado</a><?=getIcoOrder('ordem_cadastro')?></th>
            <th>Ação</th>
            <th>AT</th>
            <th>CP</th>
            <th>VS</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $w = array();
          if($isSearch):
            $grupo = (int)getParam('grupo');
            $topico = (int)getParam('topico');
            $artigo = getParam('artigo');
            if(!empty($grupo))  $w[] = "gp.id = ${grupo}";
            if(!empty($topico)) $w[] = "tp.id = ${topico}";
            if(!empty($artigo)) $w[] = "at.titulo like \"%${artigo}%\"";
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
                at.id,
                at.titulo,
                at.situacao,
                at.ativo,
                at.compartilhado,
                at.home,
                DATE_FORMAT(at.cadastro,'%d/%m/%Y - %H:%i') AS datas
              FROM
                grupos gp
                INNER JOIN topicos tp ON gp.id = tp.id_grupo
                INNER JOIN artigos at ON tp.id = at.id_topico
                $w";
          $query = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}") or die(mysql_error());
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
        ?>
              <tr>
                <td><?='(cod. '.$ln['id_grupo'].') - '.$ln['grupo']; ?></td>
                <td><?='(cod. '.$ln['id_topico'].') - '.$ln['topico']; ?></td>
                <td><?=$ln['titulo'];?></td>
                <td><?=$ln['datas']?></td>
                <td align="center">
                  <a href="index.php?op=alte_art&grupo=<?=$ln['id_grupo'];?>&topico=<?=$ln['id_topico'];?>&op1=<?=$ln['id'];?>" class="btn btn-warning btn-xs">
                    <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="?op=exclui_art&op1=<?=$ln['id']?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir este artigo  \n (<?=$ln['titulo'];?>)? ' );">
                    <span class="glyphicon glyphicon-remove"></span>
                  </a>
                  <a href="?op=clonar_art&op1=<?=$ln['id']?>" class="btn btn-primary btn-xs" title="Clonar artigo">
                    <span class="glyphicon glyphicon-tags"></span>
                  </a>
                </td>
                <td align="center">
                  <?php
                    switch($ln['ativo']):
                      case 'S':
                        echo '<img src="img/aprovado.png"  alt="" name="ativar" data-url="ARTIGO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N" data-tp="1"/>';
                        break;
                      case 'N':
                        echo '<img src="img/bloqueado.png" alt="" name="ativar" data-url="ARTIGO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S" data-tp="1"/>';
                        break;
                    endswitch;
                  ?>
                </td>                 
                <td align="center">
                  <?php
                    switch($ln['compartilhado']):
                      case 'S':
                        echo '<img src="img/aprovado.png"  alt="" name="ativar" data-url="ARTIGO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="N" data-tp="2"/>';
                        break;
                      case 'N':
                        echo '<img src="img/bloqueado.png" alt="" name="ativar" data-url="ARTIGO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="S" data-tp="2"/>';
                        break;
                    endswitch;
                  ?>
                </td>
                <td align="center">
                  <?php
                    switch($ln['home']):
                        case 'S':
                            echo '<img src="img/aprovado.png"  alt="" name="ativar" data-url="ARTIGO/acao.php" data-tipo="hm" data-id="'.$ln['id'].'" data-ac="N" data-tp="2"/>';
                            break;
                        case 'N':
                            echo '<img src="img/bloqueado.png" alt="" name="ativar" data-url="ARTIGO/acao.php" data-tipo="hm" data-id="'.$ln['id'].'" data-ac="S" data-tp="2"/>';
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
      <li class="list-group-item">VS - Exibir na home.</li>
    </ul>
  </div>
</div>