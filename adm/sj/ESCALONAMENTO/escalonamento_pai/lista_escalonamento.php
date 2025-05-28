<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<?php
  $orderParam = getOrderByParamUrl('ordem_cadastro', 'e.cadastro', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_grupo', 'g.nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_titulo', 'e.titulo', 'A');
  $ordem_tituloParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_titulo', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $form = new formHelper();
?>
<div class="panel panel-default">
  <div class="panel-heading"> Escalonamentos Pai</div>
  <div class="panel-body">
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" id="pesquisa" role="form">
      <input type="hidden" name="op" value="<?=getParam('op');?>">
      <div class="row">
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
          <? $params = array('class'=>"form-control");?>
          <? require('includes/html/select/select-group.php'); ?>
        </div>
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
          <?=$form->input('text','topico', getParam('topico'), array('class'=>'form-control','placeholder'=>'Pesquisar Tópicos'));?>
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
    <table class="table table-condensed table-striped">
      <thead>
        <tr>
          <th width="50">#</th>
          <th><a href="?<?=$urlCompleta.'&ordem_titulo='.$ordem_tituloParametro;?>">Escalonamento</a> <?=getIcoOrder('ordem_titulo')?></th>
          <th width="100">AÇ</th>
          <th width="100">AT</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM escalonamentos WHERE ";
          $query = mysql_query("${sql} escalonamento_id IS NULL ORDER BY ordem ASC") or die(mysql_error());
          if(mysql_num_rows($query)):
            while($row = mysql_fetch_array($query)):
              require 'grid.php';
            endwhile;
          endif;
        ?>
      </body>
    </table>
  </div>
  <ul class="list-group">
    <li class="list-group-item">AÇ - Ação para editar o registro.</li>
    <li class="list-group-item">AT - Registro está ativo.</li>
  </ul>
</div>