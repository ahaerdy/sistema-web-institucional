<?php 
  session_start();

  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_financeiro".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");
  
  require "../../includes/functions/verifica.php";
  require('../../includes/functions/functions.php');
  require('../../../config.inc.php');
  Conectar();

  $usuario = getParam('usuario_id');
  $mes = getParam('mes');
  $status = getParam('status');

  $where = array();
  if(!empty($usuario)):
    $where[] = "u.id = ${usuario}";
  endif;  
  if(!empty($mes)):
    $where[] = "MONTH(p.pago_em) = ${mes}";
  endif;
  if(!empty($status)):
    $where[] = "p.pagamento_status_id = ${status}";
  endif;

  if(!empty($where)):
    $where = 'WHERE ' . implode(' AND ', $where);
  else:
    $where = '';
  endif;

  $sql = 'SELECT p.*, s.id as status_id, s.status, u.id as usuario_id, u.nome, u.email
          FROM pagamentos as p 
          INNER JOIN pagamentos_status as s ON p.pagamento_status_id = s.id 
          INNER JOIN usuarios as u ON p.usuario_id = u.id '.$where.'
          ORDER BY FIELD(s.id, 2, 1, 3)';
  $query = mysql_query($sql) or die(mysql_error());
?>
<table border="1" cellpadding="5" cellspacing="5">
  <thead>
    <tr>
      <td colspan="11">
        <h1>Relatório Financeiro &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1>
      </td>
    </tr>
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
    </tr>
  </thead>
  <tbody>
    <? while ($ln = mysql_fetch_assoc($query)): ?>
      <tr>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=$ln['id'];?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=$ln['transacao'];?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=$ln['nome'] . '<br>' . $ln['email'] . '<br>CPF: ' . $ln['cpf'];?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=(empty($ln['meio_pagamento']))?'Não informado':$ln['meio_pagamento'];?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=formatarData($ln['processado_em'], 1);?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=formatarData($ln['pago_em'], 1);?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=$ln['status'];?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=(empty($ln['valor']))?'Não informado':'R$'.number_format($ln['valor'], 2, ',', '.');?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" >(+) <?=(empty($ln['acresimo']))?'R$0,00':'R$'.number_format($ln['acresimo'], 2, ',', '.');?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" >(-) <?=(empty($ln['desconto']))?'R$0,00':'R$'.number_format($ln['desconto'], 2, ',', '.');?></td>
        <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" style="color:#f00;">
          <? $total = ($ln['valor']+$ln['acresimo'])-$ln['desconto'];
             echo 'R$'.number_format($total, 2, ',', '.'); 
             $total2 += $total; ?>
        </td>
      </tr>
    <? endwhile ;?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="10">
      </th>
      <th style="background: #f2f2f2; color:#f00;">Total: R$<?=number_format($total2, 2, ',', '.');?> </th>
    </tr>
  </tfoot>
</table>