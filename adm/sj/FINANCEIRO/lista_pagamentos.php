<div class="page-header title-article">
  <h2>Contribuições</h2>
</div>

<?php
	// $query = mysql_query('SELECT p.*, s.id as status_id, s.status FROM pagamentos as p INNER JOIN pagamentos_status as s ON p.pagamento_status_id = s.id WHERE p.usuario_id = '.getIdUsuario().' ORDER BY FIELD(s.id, 2, 1, 3)');

	$query = mysql_query('SELECT p.*, s.id as status_id, s.status FROM pagamentos as p INNER JOIN pagamentos_status as s ON p.pagamento_status_id = s.id WHERE p.usuario_id = '.getIdUsuario().' ORDER BY p.processado_em DESC');
?>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Cód.</th>
			<th>Descrição</th>
			<th>Valor</th>
			<th>Forma de pagamento</th>
			<th>Processado</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? while ($ln = mysql_fetch_assoc($query)): ?>
			<tr>
				<td><?=$ln['id'];?></td>
				<td><?=$ln['descricao'];?></td>
				<td><?=(empty($ln['valor']))?'Não informado':'R$'.number_format($ln['valor'], 2, ',', '.');?></td>
				<td><?=(empty($ln['meio_pagamento']))?'Não informado':$ln['meio_pagamento'];?></td>
				<td><?=formatarData($ln['processado_em'], 1);?></td>
				<td><?=$ln['status'];?></td>
				<td>
					<? if($ln['status_id'] == 2): ?>
						<div class="btn-group">
						  <a href="?op=fazer_pagamento&pagamento_id=<?=$ln['id'];?>&op2=C" class="btn btn-xs btn-success">Pagar</a>
						</div>
					<? endif; ?>
					<? if($ln['status_id'] == 9): ?>
						<div class="btn-group">
						  <a href="?op=fazer_pagamento&pagamento_id=<?=$ln['id'];?>&op2=D" class="btn btn-xs btn-success">Pagar</a>
						</div>
					<? endif; ?>
					<? if($ln['status_id'] == 10): ?>
						<div class="btn-group">
						  <a href="?op=fazer_pagamento&pagamento_id=<?=$ln['id'];?>&op2=N" class="btn btn-xs btn-success">Pagar</a>
						</div>
					<? endif; ?>
				</td>
			</tr>
		<? endwhile ;?>
	</tbody>
</table>