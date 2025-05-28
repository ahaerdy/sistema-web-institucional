<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<?php
  $orderParam = getOrderByParamUrl('ordem_cadastro', 't.cadastro', 'D');
  $ordem_cadastroParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_grupo', 'g.nome', 'A');
  $ordem_grupoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_topico', 't.nome', 'A');
  $ordem_topicoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_grupo', 'ordem_topico', 'ordem_cadastro'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $form = new formHelper();
?>
<div class="panel panel-default">
  <div class="panel-heading"> Tópicos </div>
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
          <th width="250"><a href="?<?=$urlCompleta.'&ordem_grupo='.$ordem_grupoParametro;?>">Grupo</a> <?=getIcoOrder('ordem_grupo')?></th>
          <th><a href="?<?=$urlCompleta.'&ordem_topico='.$ordem_topicoParametro;?>">Assunto / Tópico / Sub-Tópico</a> <?=getIcoOrder('ordem_topico')?></th>
          <th width="100"><a href="?<?=$urlCompleta.'&ordem_cadastro='.$ordem_cadastroParametro;?>">Cadastrado</a> <?=getIcoOrder('ordem_cadastro')?></th>
          <th width="80">Sub-Item</th>
          <th width="50">Artigo</th>
          <th width="50">Foto</th>
          <th width="50">Vídeo</th>
          <th width="100"></th>
          <th width="50">AT</th>
          <th width="50">CP</th>
        </tr>
      </thead>
      <tbody>
        <?php
          function getTable($pai = 0, $nivel = '', $nivelCor = 0){
            $isSearch = getParam('search');

            $orderParam = getOrderByParamUrl('ordem_grupo', 'g.nome', 'A');
            $ordem_grupoParametro = $orderParam['order'];
            $ordemSQL[] = $orderParam['fieldSql'];
            $orderParam = getOrderByParamUrl('ordem_topico', 't.nome', 'A');
            $ordem_topicoParametro = $orderParam['order'];
            $ordemSQL[] = $orderParam['fieldSql'];
            $orderParam = getOrderByParamUrl('ordem_cadastro', 't.cadastro', 'D');
            $ordem_cadastroParametro = $orderParam['order'];
            $ordemSQL[] = $orderParam['fieldSql'];

            $ordem = getOrder($ordemSQL, 'g.nome ASC, t.nome ASC');

            $cor = array('', 'success','#d9edf7','#fcf8e3', '#f2dede', '#f5f5f5');

            if($nivelCor > 0)
              $nivel    = '-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;'.$nivel;
            $nivelCor   = ++$nivelCor;

            $w = array();
            if($isSearch):
              $grupo = (int)getParam('grupo');
              $topico = getParam('topico');
              if(!empty($grupo))    $w[] = "g.id = ${grupo}";
              if(!empty($topico))  $w[] = "t.nome like \"%${topico}%\"";
            endif;
            if(!empty($w))
              $w = ' AND '.implode(' AND ', $w);
            else
              $w = '';

            $sql = "SELECT t.id, t.id_topico, t.nome, t.ativo, t.compartilhado, g.id as id_grupo, g.nome as grupo, g.id as id_grupo_t, DATE_FORMAT(t.cadastro, '%d/%m/%Y') AS datas FROM grupos g INNER JOIN topicos t ON t.id_grupo = g.id WHERE t.id_topico = ${pai} ${w}";
            $query = mysql_query("${sql} ORDER BY ${ordem}") or die(mysql_error());
            if(mysql_num_rows($query)):
              while($ln = mysql_fetch_array($query)):
          ?>
                <tr class="<?=$cor[$nivelCor];?>">
                  <td><?=$ln['id']; ?></td>
                  <td><?='(cod. '.$ln['id_grupo'].') - '.$ln['grupo']; ?></td>
                  <?php 
                    if($ln['id_topico'] == 0){
                  ?>
                      <td><b><?=$nivel.$ln['nome'];?></b></td>
                  <?php 
                    }else{
                  ?>
                      <td><?=$nivel.$ln['nome'];?></td>
                  <?php 
                    }
                  ?>
                  <td><?=$ln['datas']; ?></td>
                  <td><a href="?op=cad_top&grupo=<?=$ln['id_grupo'];?>&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                  <td><a href="?op=cad_art&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                  <td><a href="?op=cad_galer&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                  <td><a href="?op=cria_galeria_video&topico=<?=$ln['id'];?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></a></td>
                  <?php 
                    if($ln['id_topico'] > 0):
                  ?>
                      <td>
                        <div class="btn-group">
                          <a href="?op=alte_topico&op1=<?=$ln['id'];?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                          <a href="?op=exclui_topico&op1=<?=$ln['id']?>" class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir tópico \n (<?=$ln['nome'];?>)?');"><span class="glyphicon glyphicon-remove"></span></a>
                          <a href="?op=clonar_topico&op1=<?=$ln['id']?>" class="btn btn-primary btn-xs" title="Clonar Tópico">
                            <span class="glyphicon glyphicon-tags"></span>
                          </a>
                        </div>
                      </td>
                      <td>
                        <?php
                          switch($ln['ativo']):
                            case 'S':
                              echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="TOPICO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N" data-tp="1"/>';
                              break;
                            case 'N':
                              echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="TOPICO/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S" data-tp="1"/>';
                              break;
                          endswitch;
                        ?>
                      </td>
                      <td>
                        <?php
                          switch($ln['compartilhado']):
                            case 'S':
                              echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="TOPICO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="N" data-tp="1"/>';
                              break;
                            case 'N':
                              echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="TOPICO/acao.php" data-tipo="cp" data-id="'.$ln['id'].'" data-ac="S" data-tp="1"/>';
                              break;
                          endswitch;
                        ?>
                      </td>
                  <?php
                    else:
                  ?>
                      <td>
                        <div class="btn-group">
                          <a href="?op=alt_assunto&op1=<?=$ln['id'];?>"     class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                          <a href="?op=excluir_assunto&op1=<?=$ln['id']?>"  class="btn btn-danger btn-xs" onclick="return confirm( 'Deseja realmente excluir esse assunto  \n (<?=$ln['nome'];?>)? ' );"><span class="glyphicon glyphicon-remove"></span></a>
                          <a href="?op=clonar_topico&op1=<?=$ln['id']?>"   class="btn btn-primary btn-xs" title="Clonar Tópico"><span class="glyphicon glyphicon-tags"></span></a>
                        </div>
                      </td>
                      <td></td>
                      <td></td>
                  <?php
                    endif;
                  ?>
                </tr>
        <?php
                echo getTable($ln['id'], $nivel, $nivelCor);
              endwhile;
            endif;
          }
          echo getTable();
        ?>
      </body>
    </table>
  </div>
  <ul class="list-group">
    <li class="list-group-item">AÇ - Ação para editar o registro.</li>
    <li class="list-group-item">AT - Registro está ativo.</li>
  </ul>
</div>