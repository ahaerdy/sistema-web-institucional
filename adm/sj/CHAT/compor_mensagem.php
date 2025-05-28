<?php 
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  if(isPost()):
    $usuario_id = getIdUsuario();
    $categoria = (int)getParam('categoria');
    $destinatario = (int)getParam('destinatario');
    $assunto = getParam('assunto');
    $mensagem = getParam('mensagem');
    $audio = getParam('audio');

    if(!empty($audio)):
      list($type, $audio) = explode(';', $audio);
      list(, $audio)      = explode(',', $audio);
      $audio = base64_decode($audio);
      $path = realpath(getcwd().'/../../../arquivo_site/').'/chat/';
      if(!file_exists($path))
        mkdir($path);
      $arquivoNome = 'chat_mensagem_'.time().'.mp3';
      $res = file_put_contents($path.'/'.$arquivoNome, $audio);
    endif;

    $ins = mysql_query("INSERT INTO chats_mensagens (chat_mensagen_id, chat_categoria_id, remetente_id, destinatario_id, enviado_por_id, assunto, texto, arquivo, visualizado, criado_em, atualizado_em) 
                        VALUES (null, ${categoria}, ${usuario_id}, ${destinatario}, '$usuario_id', '$assunto', '${mensagem}', '${arquivoNome}', 'N', NOW(), NOW())") or die(mysql_error());
    if($ins):
      $res = mysql_query("SELECT u1.id as remetente_id, u1.nome as remetente_nome, 
                                 u2.id as destinatario_id, u2.nome as destinatario_nome, u2.email
                          FROM usuarios u1 INNER JOIN usuarios u2
                          WHERE u2.email != '' AND u1.id = ${usuario_id} AND u2.id = ${destinatario}") or die(mysql_error());
      if(mysql_num_rows($res)):
        $ln = mysql_fetch_assoc($res);
        $mensagens = obterMensagem();
        $mensagem = $mensagens['chat']['notificar_remetente'];
        $mensagem = str_replace(array('#{nome}','#{nome_destinatario}','#{link}'), array($ln['remetente_nome'], $ln['destinatario_nome'], mysql_insert_id()), $mensagem);
        eviarEmail('Nova mensagem de '.$ln['remetente_nome']." - Assunto: ${assunto}", $mensagem, $ln['email']);
      endif;
      setFlashMessage('Mensagem enviada!', 'success');
    else:
      setFlashMessage('Não foi possivel enviar a mensagem.', 'warning');
    endif;
    echo redirect2('index.php?op=caixa_entrada');
    exit;
  else:
    $scripts[] = "/adm/sj/js/message_audio.js";
    $scripts[] = "/adm/sj/js/recordmp3.js";
    $scripts[] = '/adm/sj/js/form_script/chat-actions.js';

    $mId = (int)getParam('mensagem');
    if($mId):
      $res = mysql_query("SELECT m.*, DATE_FORMAT(m.criado_em, '%d/%m/%Y ás %H:%i') as data, u1.nome as remetente_nome, u2.nome as destinatario_nome, c.id as categoria_id, c.categoria 
                          FROM chats_mensagens m
                          INNER JOIN chats_categorias c ON m.chat_categoria_id = c.id
                          INNER JOIN usuarios u1 ON m.remetente_id = u1.id
                          INNER JOIN usuarios u2 ON m.destinatario_id = u2.id
                          WHERE m.id = ${mId} AND (m.remetente_id = ".getIdUsuario()." OR m.destinatario_id = ".getIdUsuario().")") or die(mysql_error());
      $ln = mysql_fetch_assoc($res);

      if(getIdUsuario() == $ln['destinatario_id'])
        $ln['destinatario_id'] = $ln['remetente_id'];
      if($ln['visualizado'] == 'N' && $ln['destinatario_id'] != getIdUsuario()):
        mysql_query("UPDATE chats_mensagens SET visualizado = 'S' WHERE id = ${mId}");
      endif;
    endif;

?>
    <div class="page-header title-article">
      <h2>Mensagens</h2>
    </div>
    <div class="row">
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <? require 'menu_chat.php'; ?>
      </div>
      <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <form action="index.php?op=compor_mensagem" method="post" accept-charset="utf-8" id="form-chat">
          <input type="hidden" name="audio" id="audio">
          <div class="panel panel-success">
            <div class="panel-heading">
              Compor Mensagem
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="">Categoria</label>
                    <?php
                      $categoria = 'categoria'; 
                      $params = array('class'=>"form-control required search-recipient-ajax", 'data-fill'=>"destinatario");
                      require('includes/html/select/select-category-chat.php'); 
                    ?>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="">Destintário</label>
                    <select name="destinatario" id="destinatario" required="required" class="form-control" data-destinararioId="<?=$ln['destinatario_id'];?>">
                      <option value="">-</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Assunto</label>
                <? $label = (getParam('encaminhar'))?'ENC:':'RE:';?>
                <input type="text" name="assunto" value="<?=(!empty($ln['assunto']))?$label.$ln['assunto']:'';?>" class="form-control" required="required" placeholder="Digite um assunto">
              </div>
              <div class="form-group">
                <label for="">Mensagem</label>
                <textarea name="mensagem" class="form-control" rows="25"  placeholder="Digite sua mensagem aqui ..."><?=(!empty($ln['texto']))?preparaMensagemMail($ln['texto'], $ln['data'], $ln['destinatario_nome']):'';?></textarea>
              </div>
            </div>
            <div class="panel-footer">
              <div class="btn-group">
                <button class="btn btn-success" id="btn-chat" onclick="sendMenssage();">
                  <span class="glyphicon glyphicon-send"></span>
                  Enviar
                </button>
                <button class="btn btn-danger" id="btn-rec" style="display: none;" onclick="startRecording(this);">
                  <span class="glyphicon glyphicon-record"></span>
                  Gravar Voz
                </button>
                <button class="btn btn-primary" id="btn-stop" style="display: none;" onclick="stopRecording(this);" disabled>
                  <span class="glyphicon glyphicon-stop"></span>
                  Parar de Gravar
                </button>
              </div>
              <div id="response"></div>
              <ul id="recordingslist" class="list-group"></ul>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php
  endif;
?>