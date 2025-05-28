<?php
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

  $qnt = QTD_ITEM_PAGINATOR;
  $paramsPaginator = getPaginatorCalc('pagina', $qnt);
  $currentPageNumber = $paramsPaginator['current_page_number'];
  $start = $paramsPaginator['start'];

  $orderParam = getOrderByParamUrl('ordem_categoria', 'categoria', 'A');
  $ordem_categoriaParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_assunto', 'assunto', 'A');
  $ordem_assuntoParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];
  $orderParam = getOrderByParamUrl('ordem_data', 'data', 'A');
  $ordem_dataParametro = $orderParam['order'];
  $ordemSQL[] = $orderParam['fieldSql'];

  $url = getUrlParams(array('ordem_categoria', 'ordem_assunto', 'ordem_data'));
  $urlCompleta = getUrl($url);
  $url = getUrlParams(array('pagina'));
  $urlPaginacao = getUrl($url);

  $ordem = getOrder($ordemSQL, 'data DESC');

  $isSearch = getParam('search');
?>

<div class="page-header title-article">
  <h2>Mensagens | <small>Caixa de saída</small></h2>
</div>
<div class="row">
  <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
      <? require 'menu_chat.php'; ?>
  </div>
  <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
    <div class="panel panel-default">
      <table class="table table-hover">
        <thead>
          <tr>
            <th nowrap="nowrap"><a href="<?="?${urlCompleta}&ordem_categoria=${ordem_categoriaParametro}";?>">Categoria</a> <?=getIcoOrder('ordem_categoria');?></th>
            <th nowrap="nowrap"><a href="<?="?${urlCompleta}&ordem_assunto=${ordem_assuntoParametro}";?>">Assunto</a> <?=getIcoOrder('ordem_assunto');?></th>
            <th nowrap="nowrap" width="150">De</th>
            <th nowrap="nowrap" width="150">Para</th>
            <th nowrap="nowrap" width="150"><a href="<?="?${urlCompleta}&ordem_data=${ordem_dataParametro}";?>">Data</a> <?=getIcoOrder('ordem_data');?></th>
            <th nowrap="nowrap" width="200"></th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(getIdUsuario() == $ln['destinatario_id'])
              $ln['destinatario_id'] = $ln['remetente_id'];
            $sql = "SELECT m.*, DATE_FORMAT(m.criado_em, '%d/%m/%Y ás %H:%i') as data, u1.nome as remetente_nome, u2.nome as destinatario_nome, c.categoria
                    FROM chats_mensagens m
                    INNER JOIN chats_categorias c ON m.chat_categoria_id = c.id
                    INNER JOIN usuarios u1 ON m.remetente_id = u1.id
                    INNER JOIN usuarios u2 ON m.destinatario_id = u2.id
                    WHERE m.visualizado = 'N' AND
                          m.enviado_por_id = ".getIdUsuario()." AND
                          m.remetente_id = ".getIdUsuario()." AND
                          m.visivel_remetente = 'S'";
            $res = mysql_query("${sql} ORDER BY ${ordem} LIMIT ${start}, ${qnt}") or die(mysql_error());
            if(!mysql_num_rows($res)):
          ?>
              <tr>
                <td colspan="4">Nenhuma mensagem encontrada.</td>
              </tr>
          <?php
            else:
              while($ln = mysql_fetch_assoc($res)):
          ?>
                <tr class="link link-message" data-id="<?=$ln['id']; ?>">
                  <td nowrap="nowrap"><?=$ln['categoria'];?></td>
                  <td><?=$ln['assunto'];?></td>
                  <td nowrap="nowrap"><?=$ln['remetente_nome'];?></td>
                  <td nowrap="nowrap"><?=$ln['destinatario_nome'];?></td>
                  <td nowrap="nowrap"><?=$ln['data'];?></td>
                  <td nowrap="nowrap">
                    <div class="btn-group">
                      <a href="index.php?op=visualiza_mensagem&op1=<?=$ln['id'];?>" class="btn btn-primary btn-sm">visualizar</a>
                      <a href="index.php?op=remover_mensagem&mensagem=<?=$ln['id'];?>&caixa-saida=1" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                  </td>
                </tr>
          <?php
              endwhile;
            endif;
          ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="6">
              <?php require('paginacao_sql.php'); ?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
