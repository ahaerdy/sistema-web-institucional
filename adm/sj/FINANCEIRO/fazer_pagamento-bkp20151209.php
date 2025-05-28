<div class="page-header title-article">
  <h2>Pagamentos</h2>
</div>
<?php
  if(!isPost()):
    $form = new formHelper();
?>
    <div class="well well-lg form-horizontal">
      <div class="form-group">
        <label class="col-sm-2 control-label">Valor:</label>
        <div class="col-sm-10">
          <? $query = mysql_query('SELECT valor FROM categorias_pagamentos_valores WHERE categoria_pagamento_id = '.$_SESSION['login']['categoria_pagamento_id'].' ORDER BY valor ASC'); ?>
          <select id="valor" name="valor" class="form-control value-donation" required>
            <option value="">Selecione</option>
            <?php
              while ($ln = mysql_fetch_assoc($query)) {
                echo '<option value="'.number_format($ln['valor'], 2, '.', '.').'">R$'.number_format($ln['valor'], 2, ',', '.').'</option>';
              }
            ?>
          </select>
        </div>
      </div>
      <div class="form-group buttons" style="display:none;">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" class="pull-left" style="margin-right: 15px;">
            <!--Tipo do botão-->
            <input type="hidden" name="cmd" value="_xclick" />

            <!--Vendedor e URL de retorno, cancelamento e notificação-->
            <input type="hidden" name="business" value="djras_rafael-facilitator@hotmail.com" />
            <input type="hidden" name="return" value="http://www.jessenios.net/adm/sj/FINANCEIRO/retorno_paypal.php" />
            <input type="hidden" name="cancel" value="http://www.jessenios.net/adm/sj/FINANCEIRO/retorno_paypal.php" />
            <input type="hidden" name="notify_url" value="http://www.jessenios.net/adm/sj/FINANCEIRO/retorno_paypal.php" />

            <!--Internacionalização e localização da página de pagamento-->
            <input type="hidden" name="invoice" value="<?=getParam('pagamento_id');?>">
            <input type="hidden" name="charset" value="utf-8" />
            <input type="hidden" name="lc" value="BR" />
            <input type="hidden" name="country_code" value="BR" />
            <input type="hidden" name="currency_code" value="BRL" />

            <!--Informações sobre o produto e seu valor-->
            <input type="hidden" name="amount" value="0" />
            <input type="hidden" name="item_name" value="Contribuição mensal para Comunidade Jessênia" />
            <input type="hidden" name="quantity" value="1" />

            <!--Botão para submissão do formulário-->
            <button type="submit" name="submit" class="btn btn-primary">Pagar com Paypal</button>
          </form>

          <form method="post" target="_blank" action="https://pagseguro.uol.com.br/v2/checkout/payment.html" class="pull-left">

            <!-- Campos obrigatórios -->
            <input name="receiverEmail" type="hidden" value="djras_rafael@hotmail.com">
            <input name="currency" type="hidden" value="BRL">

            <!-- Código de referência do pagamento no seu sistema (opcional) -->  
            <input name="reference" type="hidden" value="<?=base64_encode(getParam('pagamento_id').':'.getIdUsuario())
            ;?>">  

            <!-- Itens do pagamento (ao menos um item é obrigatório) -->
            <input name="itemId1" type="hidden" value="0001">
            <input name="itemDescription1" type="hidden" value="Contribuição mensal para Comunidade Jessênia">
            <input name="itemAmount1" type="hidden" value="0">
            <input name="itemQuantity1" type="hidden" value="1">
            <input name="itemWeight1" type="hidden" value="0">

            <!-- Dados do comprador (opcionais) -->
            <input name="senderName" type="hidden" value="<?=$_SESSION['login']['nome'];?>">
            <input name="senderEmail" type="hidden" value="<?=$_SESSION['login']['email'];?>">

            <!-- submit do form (obrigatório) -->
            <button type="submit" name="submit" class="btn btn-primary">Pagar com PagSeguro</button>

          </form>
        </div>
      </div>
<?php
  else:
?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>Obrigado por sua doação!</h1>
                    <div class="error-details">
                        A comunidade jessênia agradece.
                    </div>
                    <div class="error-actions">
                        <a href="/adm/sj/index.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-home"></span> Voltar para home </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
  endif;
?>