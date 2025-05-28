<?php 
    if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
?>
<div class="page-header title-article">
  <h2>Mensagens | <small>Visualizar mensagem</small></h2>
</div>
<div class="row">
  <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    <ul class="list-group">
      <li class="list-group-item">
        <a href="/adm/sj/index.php?op=compor_mensagem">Compor mensagem</a>
      </li>
      <li class="list-group-item">
        <a href="/adm/sj/index.php?op=caixa_entrada">Caixa de Entrada</a>
      </li>
      <li class="list-group-item">
        <a href="/adm/sj/index.php?op=caixa_saida">Caixa de Saida</a>
      </li>
      <li class="list-group-item">
        <a href="/adm/sj/index.php?op=mensagem_enviada">Mensagens enviadas</a>
      </li>
    </ul>
  </div>
  <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <?php
          $menId = (int)getParam('op1');
          $res = mysql_query("SELECT m.*, DATE_FORMAT(m.criado_em, '%d/%m/%Y ás %H:%i') as data, u1.nome as remetente_nome, u2.nome as destinatario_nome, c.categoria 
                              FROM chats_mensagens m
                              INNER JOIN chats_categorias c ON m.chat_categoria_id = c.id
                              INNER JOIN usuarios u1 ON m.remetente_id = u1.id
                              INNER JOIN usuarios u2 ON m.destinatario_id = u2.id
                              WHERE m.id = ${menId} AND 
                                    ((m.remetente_id = ".getIdUsuario()." OR m.destinatario_id = ".getIdUsuario().") AND 
                                    (m.enviado_por_id = ".getIdUsuario()." AND m.visivel_remetente = 'S') OR (destinatario_id = ".getIdUsuario()." AND visivel_destinatario = 'S'))");
          if(!mysql_num_rows($res)):
        ?>
            <div class="text-center">Mensagem não encontrada.</div>
        <?php
          else:
            $ln = mysql_fetch_assoc($res);
            if(getIdUsuario() == $ln['destinatario_id'])
              $ln['destinatario_id'] = $ln['remetente_id'];
            if($ln['visualizado'] == 'N' && $ln['destinatario_id'] != getIdUsuario()):
              mysql_query("UPDATE chats_mensagens SET visualizado = 'S' WHERE id = ${menId}");
            endif;
            $path = '/arquivo_site/chat';

            echo '<div class="panel panel-default">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                          <div class="pull-left">
                            <h3>'.$ln['assunto'].'</h3>
                            <p>De: '.$ln['remetente_nome'].'</p>
                            <p>Para: '.$ln['destinatario_nome'].'</p>
                            <p>Data: '.$ln['data'].'</p>';

                            if(!empty($ln['arquivo'])):
                              echo '<audio controls>
                                      <source src="'.$path.'/'.$ln['arquivo'].'" type="audio/mpeg">
                                      Your browser does not support the audio element.
                                    </audio>';
                            endif;
            echo '
                          </div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                          <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              Ações <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="index.php?op=compor_mensagem">Nova mensagem</a></li>
                              <li><a href="index.php?op=compor_mensagem&mensagem='.$ln['id'].'">Responder Mensagem</a></li>
                            </ul>
                          </div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-body">
                      '.nl2br($ln['texto']).'
                    </div>
                  </div>';
            
          endif;
        ?>
  </div>
</div>
