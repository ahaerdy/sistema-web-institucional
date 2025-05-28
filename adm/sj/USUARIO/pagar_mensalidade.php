<?php
    $id_usuario =  $_SESSION['id_usuarios'];
    $cod_usuario = $_GET['op1'];
    
    $sql = mysql_query("SELECT
    					id,
    					matricula,
    					DATE_FORMAT(data_ingresso, '%d/%m/%Y  %H:%i:%s') AS data_ingresso,
    					nome,
    					cpf,
    					endereco,
    					complemento, bairro,
    					cidade, estado, pais, cep,
    					telefone_com, telefone_res, telefone_cel,
    					email
    					FROM 
    					usuarios
    					where id='$cod_usuario' LIMIT 1");

	if($linha = mysql_fetch_array($sql))
	{
			$cad_id					= $linha['id'];
			$matricula				= $linha['matricula'];	
			$caddata_ingresso		= $linha['data_ingresso'];
			$cadnome				= $linha['nome'];
			$cadcpf					= $linha['cpf'];
			$cadendereco			= $linha['endereco'];
			$cadbairro				= $linha['complemento']." ". $linha['bairro'];
			$cadcidade				= $linha['cidade']."  ".$linha['estado']."  ".$linha['pais']."  ".$linha['cep'];
			$cadtelefone			= $linha['telefone_com']."  ".$linha['telefone_res']."  ".$linha['telefone_cel'];
			$cademail				= $linha['email'];
	}
?>

<form method="post" action="USUARIO/gravar_pagamento.php" enctype="multipart/form-data" id="form">

	<div class="box left box-w756px">

		<div class="box-esp">

			<div class="tit-azul"> Situação de Mensalidades </div>
			
			<div class="h20px"></div>
			
			<div class="box-content">

			<div class="box-row-input">
				<label class="c-titulo">Dados do Usuário:</label>
				<div class="campo"><?=($cadnome);?></div> 
			</div>
			<div class="box-row-input">
				<label class="c-titulo">Matrícula:</label>
				<div class="campo"><?=($matricula)?></div>
			</div>
			<div class="box-row-input"> 
				<label class="c-titulo">CPF:</label> 
				<div class="campo"><?=($cadcpf);?></div>
			</div>
			<div class="box-row-input">
				<label class="c-titulo"></label>
				<div class="campo">
			    	<?= ($cadendereco); ?> - <?= ($cadbairro) ?>
			    	<?= ($cadcidade) ?>	
				</div>
			</div>
			<div class="box-row-input">
				<label class="c-titulo">Tel:</label>
				<div class="campo"><?= $cadtelefone ?> - <a href="mailto:<?= $cademail ?>"><?= $cademail ?></a></div>
			</div>
			<div class="box-row-input">			
				<label class="c-titulo">Data:</label>
				<div class="campo"><input type="text" name="requiredmes" class="required" id="data" size="14"></div>
			</div>
			<div class="box-row-input">
				<label class="c-titulo">Valor R$:</label>
				<div class="campo">
					<input type="text" name="requiredvalor" class="required" size="10"> - <input type="submit" value="Efetuar Recebimento" />
					<input type="hidden" name="ID_USUARIO" value="<? echo $id_usuario;?>" />
					<input type="hidden" name="COD_USUARIO" value="<? echo $cod_usuario;?>" />
				</div>
			</div>
			<div class="box-row-input">
				<table class="table table-striped">
					<tr>
	    				<th>DATA PAGAMENTO</th>
	    				<th>MÊS PAGAMENTO</th>
	    				<th>VALOR</th>
	    				<th>EXCLUIR</th>
	    			</tr>
	    			<tbody>
		                <?php
		    				$sqlmen = mysql_query("SELECT 
		    									id,
		    									valor,
		    									DATE_FORMAT(cadastro, '%d/%m/%Y') AS data_pagamento,
		    									DATE_FORMAT(data, '%d/%m/%Y') AS mes_pagamento
		    									FROM mensalidade
		    									WHERE cod_usuario = '$cod_usuario'
		    									order by data");
		    				if($sqlmen >='1')
		    				{	
		    					while($linhamen = mysql_fetch_array($sqlmen))
		    					{
		    						$id 			= $linhamen['id'];
		    						$valores		= $linhamen['valor'];
		    						$data_pagamento = $linhamen['data_pagamento'];
		    						$mes_pagamento 	= $linhamen['mes_pagamento'];
		    						$valor          = number_format($valores, 2, ',', '');
		                ?>
									<tr>					
										<td><?=$data_pagamento;?></td>		
										<td><?=$mes_pagamento;?></td>
										<td><?=$valor;?></td>
										<td><a href="?op=exclui_mensalidade&op1=<?=$id?>" title="Excluir Topico" onclick="return confirm( 'Deseja realmente excluir Mensalidade? ' );">Excluir</a></td>
									</tr>
						<?php
		    					}
			    			}
						
							$sql_ttl = mysql_query("SELECT 
													sum(valor) as valor
													from mensalidade
													where cod_usuario = '$cod_usuario'");
							if($sql_ttl >='1')
							{
								while($linha_ttl = mysql_fetch_array($sql_ttl))
								{
									$ttl_valores = $linha_ttl['valor'];
									$ttl_valor = number_format($ttl_valores, 2, ',', '');
		                ?>
		    						<tr>					
		    							<td colspan="4" style="color: #f00;" align="right"><b>TOTAL: <?=$ttl_valor;?></b></td>
		    						</tr>
						<?
								}
							}
						?>
					</tbody>
				</table>
			</div>

		</div>

	</div>

</form>