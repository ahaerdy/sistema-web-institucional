<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_usuario', 'g.nome', 'A');
  $ordem_usuarioParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_destinatario', 't.nome', 'A');
  $ordem_destinatarioParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_cadastro', 't.cadastro', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_usuario', 'ordem_destinatario', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'g.nome ASC, t.nome ASC');

  $isSearch = getParam('search');

  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading"> Chat </div>
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
              <th><a href="?<?=$urlCompleta.'&ordem_usuario='.$ordem_usuarioParametro;?>">Usuário</a> <?=getIcoOrder('ordem_usuario')?></th>
              <th><a href="?<?=$urlCompleta.'&ordem_destinatario='.$ordem_destinatarioParametro;?>">Destinatário</a> <?=getIcoOrder('ordem_destinatario')?></th>
              <th><a href="?<?=$urlCompleta.'&ordem_cadastro='.$ordem_cadastroParametro;?>">Criado em</a> <?=getIcoOrder('ordem_cadastro')?></th>
              <th>Visualizar Mensagens</th>
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
                <td><?=$ln['grupo']; ?></td>
                <td><?=$ln['nome'];?></td>
                <td><?=$ln['data']; ?></td>
                <td></td>
                <td>
                  <a href="?op=alt_assunto&op1=<?=$ln['id'];?>" 	 class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                  <a href="?op=excluir_assunto&op1=<?=$ln['id']?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir esse assunto? ' );"><span class="glyphicon glyphicon-remove"></span></a>
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
<script>
  function upload(blobOrFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'core.php', true);
    xhr.onload = function (e) {
        var result = e.target.result;
    };
    xhr.send(blobOrFile);
  }
  function createDownloadLink() {
    recorder && recorder.exportWAV(function(blob) {
        var url = URL.createObjectURL(blob);
        var formData = new FormData();
        form.append( 'file', blob, 'nome-do-arquivo.wav' );
        upload( form );
        var li = document.createElement('div');
        var au = document.createElement('audio');
        var hf = document.createElement('a');
        au.controls = true;
        au.src = url;
        hf.href = url;
        hf.download = new Date().toISOString() + '.wav';
        hf.innerHTML = hf.download;
        li.appendChild(au);
        li.appendChild(hf);
        recordingslist.appendChild(li);
    });
}
</script>