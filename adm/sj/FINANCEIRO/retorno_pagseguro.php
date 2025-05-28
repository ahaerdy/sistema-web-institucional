<?php
/*
 ************************************************************************
 Copyright [2011] [PagSeguro Internet Ltda.]

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 ************************************************************************
 */
// header("access-control-allow-origin: https://sandbox.sandbox.pagseguro.uol.com.br");
header("access-control-allow-origin: https://pagseguro.uol.com.br");
require_once "../includes/functions/functions.php";
require_once "../includes/db/config.inc.php";
require_once "../includes/PagSeguroLibrary/PagSeguroLibrary.php";



//Verifica se foi enviado um método post
if($_SERVER['REQUEST_METHOD'] == 'POST'){


  //Recebe o post como o Tipo de Notificação
  $tipoNotificacao   = $_POST['notificationType'];

  //Recebe o código da Notificação
  $codigoNotificacao = $_POST['notificationCode'];

  //Verificamos se tipo da notificação é transaction
  if($tipoNotificacao == 'transaction'){

    Conectar();

    //Informa as credenciais : Email, e TOKEN
    //$credencial = new PagSeguroAccountCredentials('PAGSEGURO_EMAIL', '59C96EA8ED6D4BBCA91A55963D42469C');
    $credencial = new PagSeguroAccountCredentials('PAGSEGURO_EMAIL', 'PAGSEGURO_TOKEN');


    //Verifica as informações da transação, e retorna
                //o objeto Transaction com todas as informações
    $transacao = PagSeguroNotificationService::checkTransaction($credencial, $codigoNotificacao);

    //Retorna o objeto TransactionStatus, que vamos resgatar o valor do status
    $status = $transacao->getStatus();

    /**
     * Verificamos se realizado o pagamento para mudar no banco de dados
     * O valor 3 se referente o tipo de status, no caso informando
     * que cliente realizou o pagamento.
     * https://pagseguro.uol.com.br/v2/guia-de-integracao/documentacao-da-biblioteca-pagseguro-em-php.html#TransactionStatus
     */

    /**
     * Pegamos o código que passamos por referência para o pagseguro
     * Que no nosso exemplo é id da tabela pedido
     */
    $idPedido = $transacao->getReference();
    $idPedido = base64_decode($idPedido);
    $idPedido = explode(':', $idPedido);
    $idPedido = (int)$idPedido[0];



    if(!empty($idPedido)) {
      // PAGO
      if($status->getValue() == 3){
        $sql = "UPDATE pagamentos SET meio_pagamento='Pagseguro',
                                      transacao='".$transacao->getCode()."',
                                      valor='".$transacao->getGrossAmount()."',
                                      pagamento_status_id = '1',
                                      pago_em = NOW(),
                                      atualizado_em = NOW()
                                  WHERE
                                      id = '$idPedido'";
        mysql_query($sql) or die(mysql_error());
        $pedido = getUsuarioDoPedido($idPedido);
        require_once('./volta-escalonamento.php');
        // voltaEscalonamentoPagamento($pedido['usuario_id']);
      // CANCELADO
      } elseif($status->getValue() == 7){
          $sql = "UPDATE pagamentos SET meio_pagamento='Pagseguro',
                                     transacao='".$transacao->getCode()."',
                                     valor='".$transacao->getGrossAmount()."',
                                     pagamento_status_id = '3',
                                     pago_em = NOW(),
                                     atualizado_em = NOW()
                                 WHERE
                                     id = '$idPedido'";
          mysql_query($sql) or die(mysql_error());
          $pedido = getUsuarioDoPedido($idPedido);
          /* Gera NOVA COBRANÇA específica para esse usuário, com status "Em Aberto". */
          mysql_query("INSERT INTO pagamentos (pagamento_status_id, usuario_id, descricao, processado_em, criado_em, atualizado_em) VALUES (2, ".$pedido['usuario_id'].", 'Contribuição Mensal para a Comunidade Jessênia ref. ao mês ". date('m') . " de ". date ('Y')  ."', NOW(), NOW(), NOW())") or die(mysql_error());
      // AGUARDANDO PGTO
      } elseif($status->getValue() == 1){
          $sql = "UPDATE pagamentos SET meio_pagamento='Pagseguro',
                                     transacao='".$transacao->getCode()."',
                                     valor='".$transacao->getGrossAmount()."',
                                     pagamento_status_id = '4',
                                     pago_em = NOW(),
                                     atualizado_em = NOW()
                                 WHERE
                                     id = '$idPedido'";
          mysql_query($sql) or die(mysql_error());
      // EM ANÁLISE
      } elseif($status->getValue() == 2){
          $sql = "UPDATE pagamentos SET meio_pagamento='Pagseguro',
                                     transacao='".$transacao->getCode()."',
                                     valor='".$transacao->getGrossAmount()."',
                                     pagamento_status_id = '5',
                                     pago_em = NOW(),
                                     atualizado_em = NOW()
                                 WHERE
                                     id = '$idPedido'";
          mysql_query($sql) or die(mysql_error());
      // EM DISPUTA
      } elseif($status->getValue() == 5){
          $sql = "UPDATE pagamentos SET meio_pagamento='Pagseguro',
                                     transacao='".$transacao->getCode()."',
                                     valor='".$transacao->getGrossAmount()."',
                                     pagamento_status_id = '7',
                                     pago_em = NOW(),
                                     atualizado_em = NOW()
                                 WHERE
                                     id = '$idPedido'";
          mysql_query($sql) or die(mysql_error());
      // DEVOLVIDO
      } elseif($status->getValue() == 6){
          $sql = "UPDATE pagamentos SET meio_pagamento='Pagseguro',
                                     transacao='".$transacao->getCode()."',
                                     valor='".$transacao->getGrossAmount()."',
                                     pagamento_status_id = '8',
                                     pago_em = NOW(),
                                     atualizado_em = NOW()
                                 WHERE
                                     id = '$idPedido'";
          mysql_query($sql) or die(mysql_error());
              $pedido = getUsuarioDoPedido($idPedido);          
          /* Gera NOVA COBRANÇA específica para esse usuário, com status "Em Aberto". */
          mysql_query("INSERT INTO pagamentos (pagamento_status_id, usuario_id, descricao, processado_em, criado_em, atualizado_em) VALUES (2, ".$pedido['usuario_id'].", 'Contribuição Mensal para a Comunidade Jessênia ref. ao mês ". date('m') . " de ". date ('Y')  ."', NOW(), NOW(), NOW())") or die(mysql_error());
      } elseif(in_array($status->getValue(), array(1))) {
        $sql = "UPDATE pagamentos SET meio_pagamento='Pagseguro',
                                      transacao='".$transacao->getCode()."',
                                      valor='".$transacao->getGrossAmount()."',
                                      pagamento_status_id = '4',
                                      atualizado_em = NOW()
                                  WHERE
                                      id = '$idPedido'";

      }
    }
  }
}