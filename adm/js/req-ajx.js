  if (sel.val()) {
    var el = 'select[name="' + sel.data('popula') + '"]';
    $(el).html('<option>Carregando...</option>');
    $.post(
      '/adm/sj/' + sel.data('url'),
      {
        'id' : sel.val()
      },
      function(data) {
        if (data.qtd > 0){
          if(sel.data('visivel') != undefined){
            $('select[name="' + sel.data('visivel') + '"]').fadeIn(500);
          }
          $(el).html(data.op);
          $(el + ' option[value="'+selectItem+'"]').attr({ selected : 'selected' });
        }else {
          $(el).html('<option value="">Nenhum registro encontrado!</option>');
        }
      }
    , 'json');
  }
