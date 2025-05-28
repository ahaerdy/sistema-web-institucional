<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_grupo', 'g.nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_topico', 't.nome', 'A');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_cadastro', 't.cadastro', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_topico', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'g.nome ASC, t.nome ASC');

  $isSearch = getParam('search');
  
  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading"> Assuntos </div>
    <div class="panel-body">
      <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" id="pesquisa" role="form">
        <?=$form->input('hidden','op', getParam('op'));?>
        <div class="row">
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <? $params = array('class'=>"form-control");?>
            <? require('includes/html/select/select-group.php'); ?>
          </div>
          <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
            <?=$form->input('text','assunto', getParam('assunto'), array('class'=>'form-control','placeholder'=>'Pesquisar Assunto'));?>
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
              <th>#</th>
              <th><a href="?<?=$urlCompleta.'&ordem_grupo='.$ordem_grupoParametro;?>">Grupo</a> <?=getIcoOrder('ordem_grupo')?></th>
              <th><a href="?<?=$urlCompleta.'&ordem_topico='.$ordem_topicoParametro;?>">Assunto</a> <?=getIcoOrder('ordem_topico')?></th>
              <th><a href="?<?=$urlCompleta.'&ordem_cadastro='.$ordem_cadastroParametro;?>">Cadastrado</a> <?=getIcoOrder('ordem_cadastro')?></th>
              <th>Tópico</th>
              <th>Artigo</th>
              <th>Foto</th>
              <th>Vídeo</th>
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
            $assunto = getParam('assunto');
            if(!empty($grupo))    $w[] = "g.id = ${grupo}";
            if(!empty($assunto))  $w[] = "t.nome like \"%${assunto}%\"";
          endif;
          if(!empty($w))
            $w = ' WHERE '.implode(' AND ', $w);
          else
            $w = '';

					$sql = "SELECT t.id, t.nome, t.ativo, t.compartilhado, g.id as id_grupo, g.nome as grupo, g.id as id_grupo_t, DATE_FORMAT(t.cadastro, '%d/%m/%Y') AS data FROM grupos g INNER JOIN topicos t ON (t.id_topico = 0 OR t.id_topico IS NULL) AND t.id_grupo = g.id $w";
          $query = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}") or die(mysql_error());
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
        ?>
              <tr>
                <td><?=$ln['id']; ?></td>
                <td><?='(cod. '.$ln['id_grupo'].') - '.$ln['grupo']; ?></td>
                <td><?=$ln['nome'];?></td>
                <td><?=$ln['data']; ?></td>
                <td><a href="?op=cad_top&grupo=<?=$ln['id_grupo'];?>&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                <td><a href="?op=cad_art&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                <td><a href="?op=cad_galer&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                <td><a href="?op=cria_galeria_video&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                <td>
                  <a href="?op=alt_assunto&op1=<?=$ln['id'];?>" 	 class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="?op=excluir_assunto&op1=<?=$ln['id']?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir esse assunto \n (<?=$ln['nome'];?>)? ' );"><span class="glyphicon glyphicon-remove"></span></a>
                  <a href="?op=clonar_assunto&op1=<?=$ln['id']?>" class="btn btn-primary btn-xs" title="Clonar Assunto">
                    <span class="glyphicon glyphicon-tags"></span>
                  </a>
                </td>
								<td>
                  <?php
                    switch($ln['ativo']):
                      case 'S':
                        echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="ASSUNTO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N" data-tp="1"/>';
                        break;
                      case 'N':
                        echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="ASSUNTO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S" data-tp="1"/>';
                        break;
                    endswitch;
                  ?>
                </td>                 
                <td>
                  <?php
                    switch($ln['compartilhado']):
                    case 'S':
                      echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="ASSUNTO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="N" data-tp="2"/>';
                      break;
                    case 'N':
                      echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="ASSUNTO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="S" data-tp="2"/>';
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