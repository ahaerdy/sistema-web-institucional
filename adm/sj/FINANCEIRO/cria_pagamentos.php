<?php

ini_set('default_charset','UTF-8');
$conn=mysql_connect('localhost','JESNET_USUARIO','JESNET_SENHA') or die('Erro na conexão com o usuário do banco de dados!');
$db=mysql_select_db('JESNET_ADMINISTRADOR',$conn) or die('Erro na conexão com o banco de Dados!');
mysql_set_charset('utf8');

// if (empty ( $_SESSION ['login'] [$_SESSION ['login'] ['tipo']] ['todos_id_us'] )):
//   echo 'Acesso negado!';
//   exit;
// else:
  $i=0; /* Inicializa em zero a flag $i. */
  /* Gera tabela de usuários NÃO ISENTOS de pagamento. */
  $query = mysql_query('SELECT id, categoria_pagamento_id FROM usuarios WHERE categoria_pagamento_id!="" AND bloqueado NOT LIKE "%sim%"');
  /* Armazena em $x o número de linhas desta tabela. */
  $x = mysql_num_rows($query);
  /* Verifica cada linha desta tabela. */
  while($ln = mysql_fetch_assoc($query)):
    /* Gera nova cobrança mensal para cada usuário. */
    $ins = mysql_query("INSERT INTO pagamentos (pagamento_status_id, usuario_id, descricao, processado_em, criado_em, atualizado_em)
                        VALUES (2, ".$ln['id'].", 'Contribuição Mensal para a Comunidade Jessênia ref. ao mês ". date('m') . " de ". date ('Y')  ."', NOW(), NOW(), NOW())") or die(mysql_error());
    /* Se a flag $i for zero atribui o valor 1, isto é, sinaliza que passou pelo loop.*/
    if($ins) $i++; 
  endwhile;
  if($x == $i) echo 'Pagamentos processados com sucesso!'; /* Avisa que concluiu o loop.*/
  else /* Não passou pelo loop. */
    echo 'Não foi possivel gerar todos pagamentos, verifique com o administrador do sistema';
//endif;