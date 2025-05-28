<?php
if (empty ( $_SESSION ['login'] [$_SESSION ['login'] ['tipo']] ['todos_id_us'] )):
  echo 'Acesso negado!';
  exit;
endif;

$pagina = addslashes ( $_GET ['op'] );

if ($pagina == "" && $_SESSION ['login'] [$_SESSION ['login'] ['tipo']] ['id_usuarios'] > 3) 
  $pagina = "pagina_inicial";

switch ($pagina):
  
  /*
   * =====PAGINA INICIAL=====
   */
  
  case 'pagina_inicial' :
    if($_SESSION['login']['iGrupo'])
      $idGrupo = $_SESSION['login']['iGrupo'];
    else
      $idGrupo = $_SESSION['login']['usuario']['grupo_inicial'];

    $res = mysql_query('SELECT id FROM grupos WHERE capa = "N" AND id = ' . $idGrupo);

    if(mysql_num_rows($res))
      echo '<script type="text/javascript"> location.href="/adm/sj/index.php?op=exibe_topico&grupo=' . $idGrupo .'"</script>';
    else
      require_once ('INICIAL/pag_inicial.php');
    break;

  /*
   * =====USUARIO=====
   */
  case 'cad_usu' :
    require_once ('USUARIO/cadastro_usuario.php');
    break;
  case 'lis_usu' :
    require_once ('USUARIO/lista_usuarios.php');
    break;
  case 'alte_usua' :
    require_once ('USUARIO/editar_usuario.php');
    break;
  case 'exclui_usu' :
    require_once ('USUARIO/delete_usuario.php');
    break;
  case 'lis_comunic' :
    require_once ('USUARIO/listar_comunicados.php');
    break;
  case 'pg_mensalidade' :
    require_once ('USUARIO/pagar_mensalidade.php');
    break;
  case 'exclui_mensalidade' :
    require_once ('USUARIO/excluir_pagamento.php');
    break;
  case 'permissao_livro' :
    require_once ('USUARIO/permissao_livro.php');
    break;

  case 'validate' :
    require_once ('USUARIO/permissao_livro.php');
    break;

  /*
   * =====GRUPO=====
   */
  case 'cad_grup' :
    require_once ('GRUPO/cadastrar_grupos.php');
    break;
  case 'lis_grup' :
    require_once ('GRUPO/listar_grupos.php');
    break;
  case 'alte_grup' :
    require_once ('GRUPO/alterar_grupos.php');
    break;
  case 'exclui_grupo' :
    require_once ('GRUPO/delete_grupo.php');
    break;
  case 'permissao_livro_grupo' :
    require_once ('GRUPO/permissao_livro_grupo.php');
    break;
  case 'clonar_grupo' :
    require_once ('GRUPO/clonar_grupo.php');
    break;
  case 'room_conference' :
    require_once ('GRUPO/room_conference.php');
    break;
  case 'sala_conference' :
   	require_once ('GRUPO/sala_conference.php');
    break;

  /*
   * =====ARTIGO=====
   */
  case 'cad_art' :
    require_once ('ARTIGO/criar_artigos.php');
    break;
  case 'list_art' :
    require_once ('ARTIGO/lista_artigos.php');
    break;
  case 'alte_art' :
    require_once ('ARTIGO/alterar_artigos.php');
    break;
  case 'exclui_art' :
    require_once ('ARTIGO/delete_artigos.php');
    break;
  case 'list_submi' :
    require_once ('ARTIGO/listar_submissoes.php');
    break;
  case 'liber_submissao' :
    require_once ('ARTIGO/alterar_submissoes.php');
    break;
  case 'ver_artigos' :
    require_once ('ARTIGO/ver_artigos.php');
    break;

  case 'clonar_art' :
    require_once ('ARTIGO/clonar_artigo.php');
    break;
  /*
   * =====TOPICOS=====
   */
  
  case 'cad_top' :
    require_once ('TOPICO/criar_topico.php');
    break;
  case 'list_top' :
    require_once ('TOPICO/lista_topicos.php');
    break;
  case 'alte_topico' :
    require_once ('TOPICO/alterar_topico.php');
    break;
  case 'exclui_topico' :
    require_once ('TOPICO/excluir_topico.php');
    break;
  case 'clonar_topico' :
    require_once ('TOPICO/clonar_topico.php');
    break;

  /*
   * =====COMUNICADOS=====
   */
  
  case 'cad_comu' :
    require_once ('COMUNICADOS/criar_comunicados.php');
    break;
  case 'list_comu' :
    require_once ('COMUNICADOS/listar_comunicados.php');
    break;
  case 'alte_comu' :
    require_once ('COMUNICADOS/tela_altera_comunicados.php');
    break;
  case 'alte_comuni' :
    require_once ('COMUNICADOS/altera_comunicado.php');
    break;
  case 'exclui_comuni' :
    require_once ('COMUNICADOS/delete_comunicados.php');
    break;
  case 'mostra_comunicado' :
    require_once ('SELECT/mostra_comunicado.php');
    break;

  /*
   * =====EVENTOS=====
   */
  
  case 'cad_event' :
    require_once ('EVENTOS/criar_eventos.php');
    break;
  case 'list_event' :
    require_once ('EVENTOS/listar_eventos.php');
    break;
  case 'alte_event' :
    require_once ('EVENTOS/altera_eventos.php');
    break;
  case 'exclui_event' :
    require_once ('EVENTOS/deletar_eventos.php');
    break;
  case 'calendario_event' :
    require_once ('calendario/index.php');
    break;
  case 'mostra_evento' :
    require_once ('SELECT/mostra_evento.php');
    break;
  /*
   * =====IMAGEM=====
   */
  
  case 'cad_galer' :
    require_once ('GALERIA_IMAGEM/criar_galeria.php');
    break;
  case 'list_galer' :
    require_once ('GALERIA_IMAGEM/listar_galerias.php');
    break;
  case 'alte_galer' :
    require_once ('GALERIA_IMAGEM/alterar_galerias.php');
    break;
  case 'carr_img' :
    require_once ('GALERIA_IMAGEM/carregar_imagem.php');
    break;
  case 'exclui_galeria' :
    require_once ('GALERIA_IMAGEM/delete-gallery.php');
    break;
  case 'alte_foto' :
    require_once ('GALERIA_IMAGEM/alterar_foto.php');
    break;
  case 'clonar_galeria' :
    require_once ('GALERIA_IMAGEM/clonar_galeria.php');
    break;
  /*   * =====VIDEO=====
   */
  
  case 'cria_galeria_video' :
    require_once ('GALERIA_VIDEO/cria_galeria_video.php');
    break;
  case 'lista_galeria_video' :
    require_once ('GALERIA_VIDEO/lista_galeria_video.php');
    break;
  case 'altera_galeria_video' :
    require_once ('GALERIA_VIDEO/altera_galeria_video.php');
    break;
  case 'altera_video' :
    require_once ('GALERIA_VIDEO/altera_video.php');
    break;
  case 'ver_galeria_video' :
    require_once ('GALERIA_VIDEO/ver_galeria_video.php');
    break;
  case 'carrega_video' :
    require_once ('GALERIA_VIDEO/carrega_video.php');
    break;
  case 'delete_galeria_video' :
    require_once ('GALERIA_VIDEO/delete_galeria_video.php');
    break;
  case 'delete_video' :
    require_once ('GALERIA_VIDEO/delete_video.php');
    break;
  case 'clonar_galeria_video' :
    require_once ('GALERIA_VIDEO/clonar_galeria.php');
    break;
  /*
   * =====ACESSOS=====
   */
  
  case 'lib_acess' :
    require_once ('LIBERACAO_ACESSO/liberacao_acesso.php');
    break;
  case 'modu_acess' :
    require_once ('LIBERACAO_ACESSO/modulos_acesso.php');
    break;
  /*
   * =====DESBLOQUAR IP=====
   */
  
  case 'desbloqueio' :
    require_once ('LIBERACAO_ACESSO/desbloquear.php');
    break;
  case 'modu_acess' :
    require_once ('LIBERACAO_ACESSO/modulos_acesso.php');
    break;
  case 'deletar_acess' :
    require_once ('sair_sistema.php');
    break;
  /*
   * =====RELATORIOS=====
   */
  
  case 'relat_usuario' :
    require_once ('RELATORIO/USUARIO/tela_filtro_usuario.php');
    break;
  case 'relat_artigos' :
    require_once ('RELATORIO/ARTIGOS/tela_filtro_artigos.php');
    break;
  case 'relat_comunicado' :
    require_once ('RELATORIO/COMUNICADOS/tela_filtro_comunicados.php');
    break;
  case 'relat_eventos' :
    require_once ('RELATORIO/EVENTOS/tela_filtro_eventos.php');
    break;
  case 'relat_grupos' :
    require_once ('RELATORIO/GRUPOS/tela_filtro_grupos.php');
    break;
  case 'relat_acesso' :
    require_once ('RELATORIO/ACESSO/tela_filtro_acesso.php');
    break;
  case 'relat_topicos' :
    require_once ('RELATORIO/TOPICOS/tela_filtro_topico.php');
    break;
  case 'usuarios_online' :
    require_once ('RELATORIO/ONLINE/tela_usuarios_online.php');
    break;
  case 'controle_dados' :
    require_once ('RELATORIO/CONTROLE_DADOS/tela_controle_dados.php');
    break;
  case 'relat_video' :
    require_once ('RELATORIO/VIDEOS/tela_filtro_video.php');
    break;
  case 'relat_foto' :
    require_once ('RELATORIO/FOTOS/tela_filtro_foto.php');
    break;
  case 'relat_livro' :
    require_once ('RELATORIO/LIVROS/tela_filtro_livro.php');
    break;
  case 'relat_atividade' :
    require_once ('RELATORIO/ATIVIDADE/tela_filtro_atividades.php');
    break;
  case 'relat_atividade_consolidado' :
    require_once ('RELATORIO/ATIVIDADE/tela_filtro_atividades_consolidado.php');
    break;
  case 'relat_financeiro' :
    require_once ('RELATORIO/FINANCEIRO/tela_filtro_financeiro.php');
    break;
  /*
   * =====================BUSCA=========================
   */
  
  case 'busc_comu' :
    require_once ('mostra_busca.php');
    break;
  case 'bus_conteu' :
    require_once ('busca_conteudo.php');
    break;
  /*
   * =====================CONFERENCIA=========================
   */
  
  case 'conferencia' :
    require_once ('conferencia.php');
    break;
  /*
   * =====================EXIBE TOPICO========================
   */
  
  case 'exibe_topico' :
    require_once ('SELECT/exibe_topico.php');
    break;
  /*
   * =====================EXIBE ARTIGO========================
   */
  
  case 'mostra_artigo' :
    require_once ('SELECT/mostra_artigo.php');
    break;
  /*
   * =====================EXIBE FOTO==========================
   */
  
  case 'mostra_galeria_foto' :
    require_once ('SELECT/mostra_galeria_foto.php');
    break;
  /*
   * =====================EXIBE CALENDARIO==========================
   */
  
  case 'mostra_calendario' :
    require_once ('SELECT/mostra_calendario.php');
    break;
  /*
   * =====================EXIBE VIDEO=========================
   */
  
  case 'mostra_galeria_video' :
    require_once ('SELECT/mostra_galeria_video.php');
    break;
  /*
   * =====================EXIBE VIDEO=========================
   */
  
  case 'mostra_livro' :
    require_once ('SELECT/mostra_livro.php');
    break;
  /*
   * ===================== LIVROS =========================
   */
  
  case 'lista_livros' :
    require_once ('LIVRO/lista_livros.php');
    break;
  case 'cad_livro' :
    require_once ('LIVRO/cad_livro.php');
    break;
  case 'excluir_livro' :
    require_once ('LIVRO/excluir_livro.php');
    break;
  case 'mostra_prefacio' :
    require_once ('SELECT/mostra_prefacio.php');
    break;
  case 'mostra_indice' :
    require_once ('SELECT/mostra_indice.php');
    break;
  case 'clonar_livro' :
    require_once ('LIVRO/clonar_livro.php');
    break;
  /*
   * ===================== CATEGORIAS =========================
   */
  
  case 'lis_categorias' :
    require_once ('CATEGORIAS/lista_categorias.php');
    break;
  case 'cad_categorias' :
    require_once ('CATEGORIAS/cad_categorias.php');
    break;case 'alt_categorias' :
    require_once ('CATEGORIAS/alterar_categorias.php');
    break;
  case 'del_categorias' :
    require_once ('CATEGORIAS/delete_categorias.php');
    break;
  
  /*
   * ===================== ASSUNTOS =========================
   */
  
  case 'lista_assunto' :
    require_once ('ASSUNTO/lista_assunto.php');
    break;
  case 'cad_assunto' :
    require_once ('ASSUNTO/cad_assunto.php');
    break;
  case 'alt_assunto' :
    require_once ('ASSUNTO/alt_assunto.php');
    break;
  case 'excluir_assunto' :
    require_once ('ASSUNTO/excluir_assunto.php');
    break;
  case 'clonar_assunto' :
    require_once ('ASSUNTO/clonar_assunto.php');
    break;

  case 'frame_galleria':
      require_once('SELECT/partial/photo/gallery.php');
      break;
  case 'atualizacoes':
      require_once('SELECT/news.php');
      break;

  /*
   * ===================== CHAT =========================
   */

  case 'lista_chat':
      require_once('CHAT/lista_chat.php');
      break;

  case 'lista_chat_categoria':
      require_once('CHAT/categoria/lista_categoria.php');
      break;
  case 'cad_chat_categoria':
      require_once('CHAT/categoria/cad_categoria.php');
      break;
  case 'alt_chat_categoria':
      require_once('CHAT/categoria/alt_categoria.php');
      break;
  case 'del_chat_categoria':
      require_once('CHAT/categoria/del_categoria.php');
      break;

  case 'lista_chat_destinatario':
      require_once('CHAT/destinatario/lista_destinatario.php');
      break;
  case 'cad_chat_destinatario':
      require_once('CHAT/destinatario/cad_destinatario.php');
      break;
  case 'alt_chat_destinatario':
      require_once('CHAT/destinatario/alt_destinatario.php');
      break;
  case 'del_chat_destinatario':
      require_once('CHAT/destinatario/del_destinatario.php');
      break;

  case 'lista_chat_usuario':
      require_once('CHAT/lista_chat_usuario.php');
      break;
  case 'compor_mensagem':
      require_once('CHAT/compor_mensagem.php');
      break;
  case 'caixa_entrada':
      require_once('CHAT/caixa_entrada.php');
      break;
  case 'caixa_saida':
      require_once('CHAT/caixa_saida.php');
      break;
  case 'mensagem_enviada':
      require_once('CHAT/mensagem_enviada.php');
      break;
  case 'visualiza_mensagem':
      require_once('CHAT/visualiza_mensagem.php');
      break;
  case 'remover_mensagem':
      require_once('CHAT/remover_mensagem.php');
      break;

  /*
   * ===================== PAGAMENTOS =========================
   */

  case 'pagamentos':
      require_once('FINANCEIRO/lista_pagamentos.php');
      break;
  case 'contrib':
      require_once('includes/home/contribuicoes.php');
      break;
  case 'fazer_pagamento':
      require_once('FINANCEIRO/fazer_pagamento.php');
      break;
  case 'pagamentos-adm':
      require_once('FINANCEIRO/lista_pagamentos_adm.php');
      break;
  case 'pagamentos-negociacao-adm':
      require_once('FINANCEIRO/pagamentos_negociacao_adm.php');
      break;
  case 'pagamentos-doacao-adm':
      require_once('FINANCEIRO/pagamentos_doacao_adm.php');
      break;
  case 'cria_pagamentos':
      require_once('FINANCEIRO/cria_pagamentos.php');
      break;
  case 'processa-escalonamento':
      require_once('FINANCEIRO/processa-escalonamento.php');
      break;

  /* Teste (Arthur) */
  // case 'volta-escalonamento':
  //     require_once('FINANCEIRO/volta-escalonamento.php');
  //     break;

  case 'listar_categoria_pagamento':
      require_once('FINANCEIRO/categoria/listar_categoria_pagamento.php');
      break;
  case 'criar_categoria_pagamento':
      require_once('FINANCEIRO/categoria/criar_categoria_pagamento.php');
      break;
  case 'alterar_categoria_pagamento':
      require_once('FINANCEIRO/categoria/alterar_categoria_pagamento.php');
      break;
  case 'delete_categoria_pagamento':
      require_once('FINANCEIRO/categoria/delete_categoria_pagamento.php');
      break;

  case 'listar_cat_pagamento_valor':
      require_once('FINANCEIRO/valores/listar_categoria_pagamento_valor.php');
      break;
  case 'criar_cat_pagamento_valor':
      require_once('FINANCEIRO/valores/criar_categoria_pagamento_valor.php');
      break;
  case 'alterar_categoria_pagamento_valor':
      require_once('FINANCEIRO/valores/alterar_categoria_pagamento_valor.php');
      break;
  case 'delete_categoria_pagamento_valor':
      require_once('FINANCEIRO/valores/delete_categoria_pagamento_valor.php');
      break;



  case 'minha-conta':
      require_once('USUARIO/minha_conta.php');
      break;
  case 'campos-minha-conta':
      require_once('MINHA_CONTA/campos_minha_conta.php');
      break;

  /* Teste (Arthur) */
  case 'valida':
      require_once('MINHA_CONTA/validate.php');
      break;  

  /*case 'simula_retorno':
      $idPedido=6;
      $pedido = getUsuarioDoPedido($idPedido);
      require_once('FINANCEIRO/volta-escalonamento.php');
      break;  */

  case 'fileman':
      require_once('FILEMANAGER/fileman/fileman.php');
      break;  

  case 'mostra_forum':
      require_once('SELECT/mostra_forum.php');
      break;

  case 'mostra_forum_modal':
      // require_once('FORUM/forum.php');
      // require_once('FORUM/forum.php');

      ?>
        <!-- Impede recursividade no iframe -->
        <script>
        $(document).ready(function () {
            var doc = $(document);
            if (frames.length > 0) {
                doc = frames[0].document;
                $(doc).find('script').each(function () {
                    var script = document.createElement("script");
                    if ($(this).attr("type") != null) script.type = $(this).attr("type");
                    if ($(this).attr("src") != null) script.src = $(this).attr("src");
                    script.text = $(this).html();
                    $(doc).find('head')[0].appendChild(script);
                    $(this).remove();
                });
            }
        });
        </script>

        <script type="text/javascript">
          $(function () {
              $(document).on('click', 'button[data-dismiss]', function (e) {
               if($(this).attr('data-reload') == 'yes') window.open ('https://www.jessenios.net/adm/sj/index.php','_self',false)
               else $(this).parents('.modal').first().modal('hide');
              }); 
          });
        </script>

      <?  
    
      if(isset($_GET['f']) AND isset($_GET['t'])) { ?>
         <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-reload="yes"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%">
              </button>
              <div class="panel-body">
                <? $url_viewtopic = "\"FORUM/phpBB3/viewtopic.php?f=".$_GET['f']."&t=".$_GET['t']."\""; ?>
                <iframe src=<? echo $url_viewtopic; ?> style=" border-width:0 " width="100%" height="2000" frameborder="0" scrolling="yes"></iframe>

              </div>
            </div>
          </div>
        </div> 
      <? } 
      if(isset($_GET['f']) AND !isset($_GET['t'])) { ?>
        <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-reload="yes"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%">
              </button>
              <div class="panel-body">
                <? $url_viewforum = "\"FORUM/phpBB3/viewforum.php?f=".$_GET['f']."\""; ?>
                <iframe src=<? echo $url_viewforum; ?> style=" border-width:0 " width="100%" height="2000" frameborder="0" scrolling="yes"></iframe>
              </div>
            </div>
          </div>
        </div> 
      <? } 
      if(isset($_GET['p']) AND !isset($_GET['t']) AND !isset($_GET['f'])) { ?>
        <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-reload="yes"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%">
              </button>
              <div class="panel-body">
                <? $url_viewtopic = "\"FORUM/phpBB3/viewtopic.php?p=".$_GET['p']."&#".$_GET['p']."\""; ?>
                <iframe src=<? echo $url_viewtopic; ?> style=" border-width:0 " width="100%" height="2000" frameborder="0" scrolling="yes"></iframe>
              </div>
            </div>
          </div>
        </div> 
      <? }
      if(!isset($_GET['p']) AND !isset($_GET['t']) AND !isset($_GET['f'])) { ?>
        
        <div class="modal fade bs-example-modal-lg in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog" style="width:100%;">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-reload="yes"
                      style="position: absolute; margin: 0;  top: -15px;  right: -15px; opacity: 0.9;">
                <img src="http://expediaholiday.d.seven2.net/_images/modal_close.png" height="100%" width="100%">
              </button>
              <div class="panel-body scroll iframe-container" >
                <iframe src="FORUM/phpBB3/index.php" style="border-width:0" width="100%" height="560" frameborder="0" scrolling="yes"></iframe>   

            </div>
          </div>
        </div>
      <? }
      
      break;

  /*
   * =====ESCALONAMENTO=====
   */
  case 'cad_escalonamento_filho' :
    require_once ('ESCALONAMENTO/escalonamento_filho/cad_escalonamento.php');
    break;
  case 'lista_escalonamento_filho' :
    require_once ('ESCALONAMENTO/escalonamento_filho/lista_escalonamento.php');
    break;
  case 'alterar_escalonamento_filho' :
    require_once ('ESCALONAMENTO/escalonamento_filho/alterar_escalonamento.php');
    break;
  case 'delete_escalonamento_filho' :
    require_once ('ESCALONAMENTO/escalonamento_filho/delete_escalonamento.php');
    break;

  case 'cad_escalonamento_pai' :
    require_once ('ESCALONAMENTO/escalonamento_pai/cad_escalonamento.php');
    break;
  case 'lista_escalonamento_pai' :
    require_once ('ESCALONAMENTO/escalonamento_pai/lista_escalonamento.php');
    break;
  case 'alterar_escalonamento_pai' :
    require_once ('ESCALONAMENTO/escalonamento_pai/alterar_escalonamento.php');
    break;
  case 'delete_escalonamento_pai' :
    require_once ('ESCALONAMENTO/escalonamento_pai/delete_escalonamento.php');
    break;

  default :
    require_once ('INICIAL/pag_inicial.php');
    break;
endswitch;
?>
    