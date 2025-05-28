jQuery('document').ready(function (){
  var b_assunto 	= $('select[name="b_assunto"]');
  var b_topico 		= $('select[name="b_topico"]');
  var b_sub_topico 	= $('select[name="b_sub_topico"]');

  if(isNaN(b_assunto.val()) == 0)
    b_assunto.trigger("change");
  if(isNaN(b_topico.val()) == 0)
    b_topico.trigger("change");

  if(b_sub_topico.attr('data-id'))
  {
		$.post(
		  '/adm/sj/includes/getSubTopico.php', {
		    'id': b_topico.attr('data-id'),
		    'selectedId': b_sub_topico.attr('data-id')
		  },
		  function (data) {
		    if (data.qtd != 0) {
		    	b_sub_topico.fadeIn();
		      b_sub_topico.html(data.op);
		    } else {
		      b_sub_topico.html('<option value="">Nenhum registro encontrado!</option>');
		    }
		  }, 'json'
		);
	}
 });