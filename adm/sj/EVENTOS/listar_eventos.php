<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_cadastro', 'e.cadastro', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_grupo', 'g.nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_evento', 'e.titulo', 'A');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_local', 'e.local', 'A');
  $ordem_galeriaParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_evento', 'ordem_local', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);

  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'e.cadastro DESC, e.titulo ASC, g.nome ASC');

  $isSearch = getParam('search');
  
  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading"> Eventos </div>
    <div class="panel-body">
      <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" id="pesquisa" role="form">
        <input type="hidden" name="op" value="<?=getParam('op');?>">
        <div class="row">
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <? $params = array('class'=>"form-control");?>
            <? require('includes/html/select/select-group.php'); ?>
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <?=$form->input('text','evento', getParam('evento'), array('class'=>'form-control','placeholder'=>'Pesquisar Evento'));?>
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <?=$form->input('text','local', getParam('local'), array('class'=>'form-control','placeholder'=>'Pesquisar Local'));?>
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <div class="btn-group">
              <?=$form->input('submit','search', 'Pesquisar', array('class'=>'btn btn-info'));?>
              <?php if(getParam('grupo') || getParam('topico') || getParam('galeria')): ?>
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
            <th><a href="?<?=$urlCompleta.'&ordem_evento='.$ordem_eventoParametro;?>">Evento</a> <?=getIcoOrder('ordem_evento')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_local='.$ordem_localParametro;?>">Local</a> <?=getIcoOrder('ordem_local')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_cadastrado='.$ordem_cadastradoParametro;?>">Data</a> <?=getIcoOrder('ordem_cadastrado')?></th>
            <th>AÇ</th>
            <th>AT</th>
            <th>CP</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $w = array();
          if($isSearch):
            $grupo = (int)getParam('grupo');
            $titulo = (int)getParam('titulo');
            $local = getParam('local');
            if(!empty($grupo))  $w[] = "g.id = ${grupo}";
            if(!empty($titulo)) $w[] = "e.titulo like \"%${titulo}%\"";
            if(!empty($local))  $w[] = "e.local like \"%${local}%\"";
          endif;
          if(!empty($w))
            $w = ' WHERE '.implode(' AND ', $w);
          else
            $w = '';

          $sql = "SELECT e.id, e.titulo, e.local, e.ativo, e.compartilhado, g.id  as id_grupo, g.nome as grupo, DATE_FORMAT(e.dia, '%d/%m/%Y %H:%i') AS datas FROM grupos g INNER JOIN eventos e ON e.id_grupo = g.id $w";
          $query = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}") or die(mysql_error());
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
        ?>
              <tr>
                <td><?='(cod. '.$ln['id_grupo'].') - '.$ln['grupo']; ?></td>
                <td><?=$ln['titulo'];?></td>
                <td><?=$ln['local'];?></td>
                <td><?=$ln['datas'];?></td>
                <td>
                  <a href="index.php?op=alte_event&op1=<?=$ln['id']; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="index.php?op=exclui_event&op1=<?= $ln['id'] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Deseja realmente excluir este evento \n (<?=$ln['titulo'];?>)?');">
                    <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
                <td align="center">
                  <?php
                    switch($ln['ativo']):
                      case 'S':
                        echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="EVENTOS/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N" data-tp="1"/>';
                        break;
                      case 'N':
                        echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="EVENTOS/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S" data-tp="1"/>';
                        break;
                    endswitch;
                  ?>
                </td>                 
                <td align="center">
                  <?php
                    switch($ln['compartilhado']):
                    case 'S':
                      echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="EVENTOS/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="N" data-tp="2"/>';
                      break;
                    case 'N':
                      echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="EVENTOS/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="S" data-tp="2"/>';
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