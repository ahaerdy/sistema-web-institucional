<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } 

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_grupo', 'nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_descr', 'descricao', 'A');
  $ordem_descrParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_descr'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);    

  $ordem = getOrder($ordemSQL, 'nome ASC');

  $isSearch = getParam('search');
  
  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading">Lista de Grupos</div>
    <div class="panel-body">
      <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" id="pesquisa" role="form">
        <input type="hidden" name="op" value="<?=getParam('op');?>">
        <div class="row">
          <div class="col-sx-12 col-sm-6 col-md-3 col-lg-3">
            <?=$form->input('text','grupo', getParam('grupo'), array('class'=>'form-control','placeholder'=>'Pesquisar Grupo'));?>
          </div>
          <div class="col-sx-12 col-sm-6 col-md-9 col-lg-9">
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
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th width="50">#</th>
            <th>Nome Interno</th>
            <th><a href="?<?=$urlCompleta.'&ordem_grupo='.$ordem_grupoParametro;?>">Grupo</a> <?=getIcoOrder('ordem_grupo')?></th>
            <th><a href="?<?=$urlCompleta.'&ordem_descr='.$ordem_descrParametro;?>">Descrição</a> <?=getIcoOrder('ordem_descr')?></th>
            <th width="100">Cadastrado</th>
            <th width="50">Assunto</th>
            <th width="50">Tópico</th>
            <th width="50">Evento</th>
            <th width="50">Comunicado</th>
            <th width="50">Sala</th>
            <th width="100"></th>
            <th width="50">PL</th>
            <th width="50">EV</th>
            <th width="50">CM</th>
            <th width="50">CP</th>
            <th width="50">AT</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $w = array();
          if($isSearch):
            $grupo = getParam('grupo');
            if(!empty($grupo)) $w[] = "nome like \"%${grupo}%\"";
          endif;
          if(!empty($w))
            $w = ' AND '.implode(' AND ', $w);
          else
            $w = '';
          $sql = "SELECT *, DATE_FORMAT(cadastro, '%d/%m/%Y') as data FROM grupos WHERE id > 2 ${w} ORDER BY ${ordem}";
          $query = mysql_query("$sql LIMIT ${start}, ${qnt}") or die(mysql_error());
          while($ln = mysql_fetch_array($query)):
        ?>
            <tr>
              <td><?=$ln['id'];?></td>
              <td><?=$ln['nome_principal'];?></td>
              <td><?=$ln['nome'];?></td>
              <td><?=$ln['descricao'];?></td>
              <td><?=$ln['data']; ?></td>
              <td><?php if($ln['id'] > 2){?><a class="btn btn-info btn-xs" href="?op=cad_assunto&iGrupo=<?=$ln['id'];?>"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
              <td><?php if($ln['id'] > 2){?><a class="btn btn-info btn-xs" href="?op=cad_top&iGrupo=<?=$ln['id'];?>"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
              <td><?php if($ln['id'] > 2){?><a class="btn btn-info btn-xs" href="?op=cad_event&iGrupo=<?=$ln['id'];?>"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
              <td><?php if($ln['id'] > 2){?><a class="btn btn-info btn-xs" href="?op=cad_comu&iGrupo=<?=$ln['id'];?>"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
              <td><?php if($ln['id'] > 2){?><a class="btn btn-info btn-xs" href="?op=room_conference&iGrupo=<?=$ln['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a><?php } ?></td>
              <td>
                <div class="btn-group">
                  <?php if($ln['id'] > 2): ?>
                    <a href="?op=alte_grup&op1=<?=$ln['id'];?>" class="btn btn-warning btn-xs">
                      <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                  <?php endif; ?>
                  <?php if($ln['id'] > 3): ?>
                    <a href="?op=exclui_grupo&op1=<?=$ln['id'];?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir grupo \n (<?=$ln['nome'];?>)? ' );">
                      <span class="glyphicon glyphicon-remove"></span>
                    </a>
                  <?php endif; ?>
                  <a href="?op=clonar_grupo&op1=<?=$ln['id']?>" class="btn btn-primary btn-xs" onclick="return confirm('Deseja clonar esse grupo?');" title="Clonar Grupo">
                    <span class="glyphicon glyphicon-tags"></span>
                  </a>
                </div>
              </td>
              <td>
                <a href="index.php?op=permissao_livro_grupo&grupo=<?=$ln['id'];?>" class="btn btn-success btn-xs">
                  <span class="glyphicon glyphicon-book"></span>
                </a>
              </td>
              <td>
                <?php
                  switch($ln['evento']):
                    case 'S':
                      echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="ev" data-id="'.$ln['id'].'" data-ac="N"/>';
                      break;
                    case 'N':
                      echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="ev" data-id="'.$ln['id'].'" data-ac="S"/>';
                      break;
                  endswitch;
                ?>
              </td>
              <td>
                <?php
                  switch($ln['comunicado']):
                      case 'S':
                          echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="cm" data-id="'.$ln['id'].'" data-ac="N"/>';
                          break;
                      case 'N':
                          echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="cm" data-id="'.$ln['id'].'" data-ac="S"/>';
                          break;
                  endswitch;
                ?>
              </td>
              <td>
                <?php
                  switch($ln['capa']):
                      case 'S':
                          echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="N"/>';
                          break;
                      case 'N':
                          echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="S"/>';
                          break;
                  endswitch;
                ?>
              </td>
              <td>
                <?php
                  switch($ln['ativo']):
                      case 'S':
                          echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N"/>';
                          break;
                      case 'N':
                          echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="GRUPO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S"/>';
                          break;
                  endswitch;
                ?>
                </td>
              </tr>
        <?php 
          endwhile; 
        ?>
      </tbody>
    </table>
  </div>
  <div class="panel-footer">
    <?php require('paginacao_sql.php'); ?>
  </div>
</div>