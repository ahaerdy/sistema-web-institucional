<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_descr', 'categoria', 'A');
  $ordem_CatParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_descr'));
  $urlCompleta = getUrl($url);

  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'categoria ASC');
?>
  <div class="panel panel-default">
    <div class="panel-heading"> Categorias </div>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
					<tr>
						<th><a href="<?="?${urlCompleta}&ordem_descr=${ordem_CatParametro}";?>">Título</th>
						<th width="100">Ação</th>
					</tr>
				</thead>
				<tbody>
        <?php
          $sql = "SELECT * FROM chats_categorias ORDER BY ${ordem}";
          $query = mysql_query("${sql} LIMIT ${start}, ${qnt}") or die(mysql_error());
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
        ?>
						<tr>
							<td><?=$ln['categoria'];?></td>
							<td>
                <a href="?op=alt_chat_categoria&op1=<?=$ln['id'];?>" title="Editar" class="btn btn-warning btn-xs">
                  <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a href="?op=del_chat_categoria&op1=<?=$ln['id'];?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir esta categoria? ' );">
                  <span class="glyphicon glyphicon-remove"></span>
                </a>
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
    </ul>
  </div>
