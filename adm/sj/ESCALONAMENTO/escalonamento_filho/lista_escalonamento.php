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
  <div class="panel-heading"> Escalonamentos Filho</div>
  <div class="panel-body">
    <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" id="pesquisa" role="form">
      <input type="hidden" name="op" value="<?=getParam('op');?>">
      <div class="row">
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
          <? $params = array('class'=>"form-control");?>
          <? require('includes/html/select/select-group.php'); ?>
        </div>
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
          <?=$form->input('text','escalonamento_filho', getParam('escalonamento_filho'), array('class'=>'form-control','placeholder'=>'Pesquisar Grupo'));?>
        </div>
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3">
          <div class="btn-group">
            <?=$form->input('submit','search', 'Pesquisar', array('class'=>'btn btn-info'));?>
            <?php if(getParam('grupo') || getParam('escalonamento_filho') || getParam('galeria')): ?>
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
          <th><a href="?<?=$urlCompleta.'&ordem_grupo='.$ordem_grupoParametro;?>">Grupo</a> <?=getIcoOrder('ordem_grupo')?></th>
          <th><a href="?<?=$urlCompleta.'&ordem_titulo='.$ordem_tituloParametro;?>">Escalonamento Pai / Escalonamento</a> <?=getIcoOrder('ordem_titulo')?></th>
          <th width="100">Ordem</th>
          <th width="100">AÇ</th>
          <th width="100">AT</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $query = mysql_query("SELECT * FROM escalonamentos WHERE escalonamento_id IS NULL ORDER BY ordem ASC"); 
          if(mysql_num_rows($query)):
            while($ln = mysql_fetch_array($query)):
              $row = $ln;
              $pai = 1;
              require 'grid.php';
              $query1 = mysql_query("SELECT e.*, g.id as grupo_id, g.nome as grupo FROM grupos g RIGHT JOIN escalonamentos e ON e.grupo_id = g.id WHERE e.escalonamento_id = ".$ln['id']."  ORDER BY ordem ASC");
              if(mysql_num_rows($query1)):
                $pai = 0;
                while($ln1 = mysql_fetch_array($query1)):
                  $row = $ln1;
                  $row['titulo'] = '-   -   -   ' . $row['titulo'];
                  require 'grid.php';
                endwhile;
              endif;
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