<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_cadastro', 'gl.cadastro', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_grupo', 'gp.nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_topico', 'tp.nome', 'A');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_galeria', 'gl.titulo', 'A');
  $ordem_galeriaParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_topico', 'ordem_galeria', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'gl.cadastro DESC, gp.nome ASC, tp.nome ASC, gl.titulo ASC');

  $isSearch = getParam('search');
  
  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading"> Galerias de Fotos </div>
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
            <?=$form->input('text','galeria', getParam('galeria'), array('class'=>'form-control','placeholder'=>'Pesquisar Galeria'));?>
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
						<th><a href="?<?=$urlCompleta.'&ordem_topico='.$ordem_topicoParametro;?>">Assunto/Tópico/Sub-Tópico</a> <?=getIcoOrder('ordem_topico')?></th>
						<th><a href="?<?=$urlCompleta.'&ordem_galeria='.$ordem_galeriaParametro;?>">Galeria</a> <?=getIcoOrder('ordem_galeria')?></th>
						<th><a href="?<?=$urlCompleta.'&ordem_cadastro='.$ordem_cadastroParametro;?>">Cadastrado</a> <?=getIcoOrder('ordem_cadastro')?></th>
						<th>Total</th>
            <th>Foto</th>
						<th>AÇ</th>
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
            $galeria = getParam('galeria');
            if(!empty($grupo))  $w[] = "gp.id = ${grupo}";
            if(!empty($topico)) $w[] = "tp.id = ${topico}";
            if(!empty($galeria)) $w[] = "gl.titulo like \"%${galeria}%\"";
          endif;
          if(!empty($w))
            $w = ' WHERE '.implode(' AND ', $w);
          else
            $w = '';

					$sql = "SELECT gp.id as id_grupo,gp.nome as grupo, tp.id as id_topico, tp.nome as topico, gl.id, gl.titulo, gl.ativo, gl.compartilhado, gl.home, DATE_FORMAT(gl.cadastro, '%d/%m/%Y - %H:%i') AS data FROM grupos gp INNER JOIN topicos tp ON gp.id = tp.id_grupo INNER JOIN galerias gl ON tp.id = gl.id_topico $w";
          $query = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}");
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
  						$res1  = mysql_query("SELECT count(id) as count FROM fotos WHERE galerias_id = " . $ln['id']);
  						$total = mysql_result($res1,0,'count');
			   ?>
              <tr>
                <td><?='(cod. '.$ln['id_grupo'].') - '.$ln['grupo']; ?></td>
                <td><?='(cod. '.$ln['id_topico'].') - '.$ln['topico']; ?></td>
                <td><?=$ln['titulo'];?></td>
                <td><?=$ln['data'];?></td>
                <td><?=$total;?> foto(s)</td>
                <td><a href="?op=carr_img&grupo=<?=$ln['id_grupo'];?>&topico=<?=$ln['id_topico'];?>&galeria=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                <td>
                  <a href="index.php?op=alte_galer&op1=<?=$ln['id'];?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="index.php?op=exclui_galeria&op1=<?=$ln['id']?>" class="btn btn-danger btn-xs" onclick="return confirm('Deseja realmente excluir esta galeria \n (<?=$ln['titulo'];?>)?');"><span class="glyphicon glyphicon-remove"></span></a>
                  <a href="?op=clonar_galeria&op1=<?=$ln['id']?>" class="btn btn-primary btn-xs" title="Clonar Galeria de Foto">
                    <span class="glyphicon glyphicon-tags"></span>
                  </a>
                </td>
                <td>
                  <?php
                    switch($ln['ativo']):
                      case 'S':
                        echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="GALERIA_IMAGEM/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N" data-tp="1"/>';
                        break;
                      case 'N':
                        echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="GALERIA_IMAGEM/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S" data-tp="1"/>';
                        break;
                    endswitch;
                  ?>
								</td>									
                <td>
                  <?php
                  switch($ln['compartilhado']):
                    case 'S':
                      echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="GALERIA_IMAGEM/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="N" data-tp="2"/>';
                      break;
                    case 'N':
                      echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="GALERIA_IMAGEM/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="S" data-tp="2"/>';
                      break;
                  endswitch;
                  ?>
                </td>
                <td>
                  <?php
                  switch($ln['home']):
                    case 'S':
                      echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="GALERIA_IMAGEM/acao.php" data-tipo="hm" data-id="'.$ln['id'].'" data-ac="N" data-tp="2"/>';
                      break;
                    case 'N':
                      echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="GALERIA_IMAGEM/acao.php" data-tipo="hm" data-id="'.$ln['id'].'" data-ac="S" data-tp="2"/>';
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
<script type="text/javascript">
	<? if((int) $_GET['topico']): ?>
	    var sel = $('select[name="grupo"]');
	    var selectItem = <?=(int) $_GET['topico'];?>;
	<? endif; ?>
</script>