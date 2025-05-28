<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } 

  $qnt = 25;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $where='';
  $s = getParam('search');
  if(isset($s) && !empty($s)):
    $where[] = 'u.nome like "%'.$s.'%"';
    $where[] = 'u.email like "%'.$s.'%"';
    $where[] = 's.status like "%'.$s.'%"';
    $where[] = 'p.transacao like "%'.$s.'%"';
    $where = 'WHERE ' . implode(' OR ', $where);
  endif;

  $sql = 'SELECT p.*, s.id as status_id, s.status, u.id as usuario_id, u.nome, u.email
          FROM pagamentos as p 
          INNER JOIN pagamentos_status as s ON p.pagamento_status_id = s.id 
          INNER JOIN usuarios as u ON p.usuario_id = u.id '.$where.'
          ORDER BY FIELD(s.id, 2, 1, 3) LIMIT '.$start.', '.$qnt;
  $query = mysql_query($sql) or die(mysql_error());
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
    Listando Pagamentos
  </div>
  <div class="panel-body">
    <form action="/adm/sj/index.php" method="get" id="pesquisa" role="form">
        <input type="hidden" name="op" value="<?=getParam('op');?>">
        <div class="row">
          <div class="col-sx-12 col-sm-6 col-md-3 col-lg-3">
            <input type="text" name="search" class="form-control" placeholder="Pesquisar">          </div>
          <div class="col-sx-12 col-sm-6 col-md-9 col-lg-9">
            <div class="btn-group">
              <input type="submit"  value="Pesquisar" class="btn btn-info">                          </div>
          </div>
        </div>
      </form>
  </div>
  <table class="table table-striped table-condensed">
    <thead>
      <tr>
        <th>Cód.</th>
        <th>Transação</th>
        <th>Nome</th>
        <th>Forma de pagamento</th>
        <th>Processado</th>
        <th>Pago</th>
        <th>Status</th>
        <th>Valor</th>
        <th>Acresimo</th>
        <th>Desconto</th>
        <th>Total</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <? while ($ln = mysql_fetch_assoc($query)): ?>
        <tr>
          <td><?=$ln['id'];?></td>
          <td><?=$ln['transacao'];?></td>
          <td>
            <a href="index.php?op=alte_usua&op1=<?=$ln["usuario_id"];?>" target="_blank">
              <?=$ln['nome'] . '<br>' . $ln['email'] . '<br>CPF: ' . $ln['cpf'];?>
            </a>
          </td>
          <td><?=(empty($ln['meio_pagamento']))?'Não informado':$ln['meio_pagamento'];?></td>
          <td><?=formatarData($ln['processado_em'], 1);?></td>
          <td><?=formatarData($ln['pago_em'], 1);?></td>
          <td><?=$ln['status'];?></td>
          <td><?=(empty($ln['valor']))?'Não informado':'R$'.number_format($ln['valor'], 2, ',', '.');?></td>
          <td>(+) <?=(empty($ln['acresimo']))?'R$0,00':'R$'.number_format($ln['acresimo'], 2, ',', '.');?></td>
          <td>(-) <?=(empty($ln['desconto']))?'R$0,00':'R$'.number_format($ln['desconto'], 2, ',', '.');?></td>
          <td style="background: #f2f2f2; color:#f00;">
            <? $total = ($ln['valor']+$ln['acresimo'])-$ln['desconto'];
               echo 'R$'.number_format($total, 2, ',', '.'); 
               $total2 += $total; ?>
          </td>
          <td>
            <div class="btn-group">
              <? if($ln['status'] != 'Cancelado'): ?>
                <button type="button" class="btn btn-xs btn-warning status-pagamento" data-id="<?=$ln['id'];?>" data-status="cancelar">Cancelar</button>
              <? endif; ?>
              <? if($ln['status'] != 'Pago'): ?>
                <button type="button" class="btn btn-xs btn-success status-pagamento"  data-id="<?=$ln['id'];?>" data-status="baixa-manual">Baixa Manual</button>
              <? endif; ?>
            </div>
          </td>
        </tr>
      <? endwhile ;?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="10">
        </th>
        <th style="background: #f2f2f2; color:#f00;">Total: R$<?=number_format($total2, 2, ',', '.');?> </th>
        <th colspan="5">
          <?php require('paginacao_sql.php'); ?>
        </th>
      </tr>
    </tfoot>
  </table>
</div>
