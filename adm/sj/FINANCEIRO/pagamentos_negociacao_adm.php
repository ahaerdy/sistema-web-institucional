<?php
	if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
	if(isPost()):
    	$usuario_id		= (int)getParam('usuario_id');
    	/*$valor		    = getParam('valor');
    	$valor 			= str_replace(',', '.', $valor);*/
		$descricao      = getParam('descricao');
		/*if(!empty($valor) && !empty($descricao)):*/
        if(!empty($descricao)):            
            mysql_query("UPDATE pagamentos SET pagamento_status_id = 3 WHERE pagamento_status_id = 2 AND usuario_id = ${usuario_id}");
            /*$insere = mysql_query("INSERT INTO pagamentos (usuario_id,valor,descricao,pagamento_status_id,processado_em,criado_em,atualizado_em) 
                                   VALUES ('$usuario_id', '$valor','$descricao','2',NOW(),NOW(),NOW())")  or die (mysql_error());*/
            $insere = mysql_query("INSERT INTO pagamentos (usuario_id,descricao,pagamento_status_id,processado_em,criado_em,atualizado_em) 
                                   VALUES ('$usuario_id', '$descricao','10',NOW(),NOW(),NOW())")  or die (mysql_error());
            if($insere):
				setFlashMessage('Negociação cadastrada com sucesso!', 'success');
			else:
			 setFlashMessage('Negociação não gerada, comunique o administrador!', 'warning');
        	endif;
		else:
    	  setFlashMessage('Digite o usuário, valor e descrição para gerar a negociação!', 'warning');
    	endif;
    	echo redirect2('index.php?op=pagamentos-adm');
    	exit;
	else:
    	$form = new formHelper();
?>
    <div class="page-header">
      <h2>Negociação</h2>
    </div>
    <?php require 'FINANCEIRO/form.php';?>
<? endif; ?>