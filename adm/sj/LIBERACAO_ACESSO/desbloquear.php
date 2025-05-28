<?php 
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_ip', 'ip', 'A');
  $ordem_ipParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $orderParam = getOrderByParamUrl('ordem_usuario', 'username', 'A');
  $ordem_usuarioParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $orderParam = getOrderByParamUrl('ordem_senha', 'password', 'A');
  $ordem_senhaParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $orderParam = getOrderByParamUrl('ordem_data', 'data', 'A');
  $ordem_dataParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $orderParam = getOrderByParamUrl('ordem_bloqueado', 'bloqueado', 'A');
  $ordem_bloqueadoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_ip', 'ordem_usuario', 'ordem_senha', 'ordem_data', 'ordem_bloqueado'));
  $urlCompleta = getUrl($url);

  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'bloqueado DESC, data DESC, ip');

  $id = (int)getParam('id');
  if(!empty($id)):
    if(mysql_query("UPDATE bloqueio_ip SET bloqueado = 'n' WHERE id = '${id}' LIMIT 1"))
      setFlashMessage('Ip desbloqueado com sucesso!', 'success');
    else
      setFlashMessage('Não foi possivel desbloquear o ip, entre em contato com administrador.', 'danger');
    echo redirect2('index.php?op=desbloqueio');
    exit;
  endif;

  $limitar = (int)getParam('limitar');
  if(!empty($limitar)):
    $res = mysql_query("SELECT (max(id)-200) as id FROM bloqueio_ip");
    $n = mysql_fetch_assoc($res);
    if($n['id'] > 0):
      if(mysql_query("DELETE FROM bloqueio_ip WHERE id <= ".$n['id']))
        setFlashMessage('Limitação realizada com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel limitar o ip, entre em contato com administrador.', 'danger');
    else:
      setFlashMessage('A quantide de registro(s) existente não é maior que 200 registros.', 'warning');
    endif;
    echo redirect2('index.php?op=desbloqueio');
    exit;
  endif;
?>
  <div class="panel panel-default">
    <div class="panel-heading">Desbloqueio de IP </div>
    <div class="panel-body">
      <div class="pull-right">
        <a href="/adm/sj/index.php?op=desbloqueio&limitar=1" onclick="return confirm('Confirma a exclusão?')" class="btn btn-danger">
          Limitar a 200 útimos registros
        </a>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th><a href="?<?=$urlCompleta.'&ordem_ip='       .$ordem_ipParametro;?>">IP</a></th>
            <th><a href="?<?=$urlCompleta.'&ordem_usuario='  .$ordem_usuarioParametro;?>">Usuário</a></th>
            <th><a href="?<?=$urlCompleta.'&ordem_senha='    .$ordem_senhaParametro;?>">Senha</a></th>
            <th><a href="?<?=$urlCompleta.'&ordem_data='     .$ordem_dataParametro;?>">Data</a></th>
            <th><a href="?<?=$urlCompleta.'&ordem_bloqueado='.$ordem_bloqueadoParametro;?>">Bloqueado</a></th>     
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = 'SELECT *, DATE_FORMAT(data, "%d/%m/%Y - %H:%i") as data1 FROM bloqueio_ip';
            $res = mysql_query("${sql} ORDER BY $ordem LIMIT ${start}, ${qnt}");
            while($ln = mysql_fetch_assoc($res)):
          ?>
              <tr>
                <td><?=$ln['ip'];?></td>
                <td><?=$ln['username'];?></td>
                <td><?=$ln['password'];?></td>
                <td><?=$ln['data1'];?></td>
                <td><?=($ln['bloqueado'] != 'n')? '<a href="?op=desbloqueio&id='.$ln['id'].'" onclick="return confirm(\'Deseja realmente desbloquear?\');" style="color: #f00;">[ Desbloquear ]</a>' : '-';?></td>
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
</div>