$('document')
  .ready(
    function () {
      // GALERIA DE IMAGEM NA HOME
      $('#slide-foto-home').cycle({
        fx: 'scrollLeft',
        timeout: 5000,
        next: '#next',
        prev: '#prev'
      });
      // ---------------------------------------------------------------------
      /* GRUPOS */
      $('#sel-grupo').on('change', function () {
        var grupo = $('#sel-grupo');
        if (grupo.val() != "") {
          location.href = "index.php?grupo=" + grupo.val();
        }
      });
      // ---------------------------------------------------------------------
      /* ASSUNTO */
      $('#sel-assunto')
        .on(
          'change',
          function () {
            var grupo = $('#sel-grupo');
            var assunto = $('#sel-assunto');
            if (assunto.val() != "") {
              location.href = "index.php?op=exibe_topico&grupo=" + grupo.val() + "&assunto=" + assunto.val();
            }
          });
      // ---------------------------------------------------------------------
      /* TOPICO */
      $('#sel-topico')
        .on(
          'change',
          function () {
            var grupo = $('#sel-grupo');
            var assunto = $('#sel-assunto');
            var topico = $('#sel-topico');
            if (topico.val() != "") {
              location.href = "index.php?op=exibe_topico&grupo=" + grupo.val() + "&assunto=" + assunto.val() + "&topico=" + topico.val();
            }
          });
      // ---------------------------------------------------------------------
      /* PESQUISAR ARTIGO OU GRUPO */
      $('input[name="pesquisar"]')
        .click(
          function () {
            var grupo = $('#sel-grupo');
            var assunto = $('#sel-assunto');
            var topico = $('#sel-topico');
            var url = '';
            if (!isNaN(grupo.val()) && assunto.val() == '') {
              location.href = "index.php?grupo=" + grupo.val();
            }
            else {
              if ((parseFloat(grupo.val()) == parseInt(grupo
                .val())) && !isNaN(grupo.val())) {
                url = url + '&grupo=' + grupo.val();
              }
              if ((parseFloat(assunto.val()) == parseInt(assunto
                .val())) && !isNaN(assunto.val())) {
                url = url + '&assunto=' + assunto.val();
              }
              if ((parseFloat(topico.val()) == parseInt(topico
                .val())) && !isNaN(topico.val())) {
                url = url + '&topico=' + topico.val();
              }
              location.href = "index.php?op=exibe_topico" + url;
            }
            return false;
          });
      // ---------------------------------------------------------------------
      /* Retorna Topico */
      $('.getAjax').change(
        function () {
          var sel = $(this);
          if (sel.data('visivel') == undefined) {
            escondeCampoBusca();
          }
          if (sel.val()) {
            mostraModal();
            var el = 'select[name="' + sel.data('popula') + '"]';
            $(el).html('<option>Carregando...</option>');
            $.post(
              '/adm/sj/' + sel.data('url'), {
                'id': sel.val()
              },
              function (data) {
                if (data.qtd != 0) {
                  if (sel.data('visivel') != undefined) {
                    $('select[name="' + sel.data('visivel') + '"]').fadeIn(500);
                  }
                  $(el).html(data.op);
                }
                else {
                  $(el).html('<option value="">Nenhum registro encontrado!</option>');
                }
                escondeModal();
              }, 'json');
          }
        }
      );

      function escondeCampoBusca() {
        $('select[name="b_topico"], select[name="b_sub_topico"]').fadeOut(500);
      }
      /* Retorna Topico */
      $('.getComentario').live('click', function () {
        event.preventDefault();
        mostraModal();
        $.get('/adm/sj/GALERIA_IMAGEM/comentario.php', {
          'id': $(this).parent('td').attr('id')
        }, function (data) {
          $('#dialog').html(data);
        });
      });
      $('.getComentarioVideo').live('click', function () {
        event.preventDefault();
        mostraModal();
        $.get('/adm/sj/GALERIA_VIDEO/comentario.php', {
          'id': $(this).parent('td').attr('id')
        }, function (data) {
          $('#dialog').html(data);
        });
      });
      // ---------------------------------------------------------------------
      $('table.listagem tbody tr:odd').addClass('tr-linha1');
      $('table.listagem tbody tr:even').addClass('tr-linha2');
      // ---------------------------------------------------------------------
      $('img[name="ativar"]').click(function () {
        mostraModal();
        var el = $(this);
        $.post(el.data('url'), {
          'id': el.data('id'),
          'tp': el.data('tp'),
          'ac': el.data('ac')
        }, function (data) {
          if (data == 'ok') {
            if (el.data('ac') == 'S') {
              $(el).attr('src', 'images/aprovado.png');
              $(el).data('ac', 'N');
            }
            else {
              $(el).attr('src', 'images/bloqueado.png');
              $(el).data('ac', 'S');
            }
          }
          escondeModal();
        });
      });
      $('.pesquisa').keyup(function () {
        var input = $(this);
        $.post(input.data('url'), {
          'palavra': input.val()
        }, function (data) {
          if (data.erro == 0) {
            if (el.data('ac') == 'S') {
              $(el).attr('src', 'images/aprovado.png');
              $(el).data('ac', 'N');
            }
            else {
              $(el).attr('src', 'images/bloqueado.png');
              $(el).data('ac', 'S');
            }
          }
        }, 'json');
      });
      // ---------------------------------------------------------------------
      $('.close').live('click', function (event) {
        event.preventDefault();
        jQuery('#mask').hide();
        jQuery('.window').hide();
      });
      $('form[id=comentario]')
        .live(
          'submit',
          function (event) {
            event.preventDefault();
            $('#dialog')
              .html(
                '<center><img src="/images/aguarde.gif" alt=""/></center>');
            $
              .post(
                '/adm/sj/GALERIA_IMAGEM/detalhes.php', {
                  'id': $(this)
                    .find(
                      'input[type="hidden"]')
                    .val(),
                  'texto': $(this)
                    .find(
                      'textarea')
                    .val()
                },
                function (data) {
                  if (data.erro == 1) {
                    $('#dialog')
                      .html(
                        '<div align="center" class="vermelho"><b>' + data.msg + '</b></div><div class="h20px"></div>');
                    $
                      .get(
                        '/adm/sj/GALERIA_IMAGEM/detalhes.php',
                        function (
                          data) {
                          $(
                            '#dialog')
                            .append(
                              data);
                        });
                  }
                  else {
                    $('#dialog')
                      .html(
                        '<div align="center" class="verde"><b>' + data.msg + '</b></div><div class="h20px"></div>');
                    jQuery('#mask')
                      .delay(
                        2000)
                      .fadeOut(
                        400);
                    jQuery(
                      '.window')
                      .delay(
                        2000)
                      .fadeOut(
                        400);
                  }
                }, 'json');
          });
      $('form[id=comentarioVideo]')
        .live(
          'submit',
          function (event) {
            event.preventDefault();
            $('#dialog')
              .html(
                '<center><img src="/images/aguarde.gif" alt=""/></center>');
            $
              .post(
                '/adm/sj/GALERIA_VIDEO/detalhes.php', {
                  'id': $(this)
                    .find(
                      'input[type="hidden"]')
                    .val(),
                  'texto': $(this)
                    .find(
                      'textarea')
                    .val()
                },
                function (data) {
                  if (data.erro == 1) {
                    $('#dialog')
                      .html(
                        '<div align="center" class="vermelho"><b>' + data.msg + '</b></div><div class="h20px"></div>');
                    $
                      .get(
                        '/adm/sj/GALERIA_IMAGEM/detalhes.php',
                        function (
                          data) {
                          $(
                            '#dialog')
                            .append(
                              data);
                        });
                  }
                  else {
                    $('#dialog')
                      .html(
                        '<div align="center" class="verde"><b>' + data.msg + '</b></div><div class="h20px"></div>');
                    jQuery('#mask')
                      .delay(
                        2000)
                      .fadeOut(
                        400);
                    jQuery(
                      '.window')
                      .delay(
                        2000)
                      .fadeOut(
                        400);
                  }
                }, 'json');
          });
      $('.numero').keypress(
        function (event) {
          var tecla = (window.event) ? event.keyCode : event.which;
          if ((tecla > 47 && tecla < 58))
            return true;
          else {
            if (tecla != 8)
              return false;
            else
              return true;
          }
        });
    });

function mostraModal() {
  var id = '#dialog';
  var maskHeight = jQuery(document).height();
  var maskWidth = jQuery(window).width();
  jQuery('#mask').css({
    'width': maskWidth,
    'height': maskHeight
  });
  jQuery('#mask').show();
  // Get the window height and width
  var winH = jQuery(window).height();
  var winW = jQuery(window).width();
  jQuery(id).css('top',
    winH / 2 - jQuery(id).height() / 2);
  jQuery(id).css('left',
    winW / 2 - jQuery(id).width() / 2);
  jQuery(id).show();
}

function escondeModal() {
  jQuery('#mask').hide();
  jQuery('.window').hide();
}