// URLS
var tr_url_article = "/adm/sj/index.php?op=mostra_artigo&artigo=";
var tr_url_photo = "/adm/sj/index.php?op=mostra_galeria_foto&galeria=";
var tr_url_movie = "/adm/sj/index.php?op=mostra_galeria_video&galeria=";
var tr_url_book = "/adm/sj/index.php?op=mostra_livro&livro=";
var tr_url_message = "/adm/sj/index.php?op=visualiza_mensagem&op1=";
var tr_url_subTopico = "/adm/sj/index.php?op=exibe_topico";
var search_url_group = "/adm/sj/index.php";
var get_topic_select_form = '';

var url_status_pagamento = "/adm/sj/FINANCEIRO/pagamentos-status.php";

jQuery('document').ready(function (){
  jQuery('tr.link-artigo').on('click', function (){
    myFunctions.execute('createTableUrlLink', tr_url_article, this);
  });
  jQuery('tr.link-foto').on('click', function (){
    myFunctions.execute('createTableUrlLink', tr_url_photo, this);
  });
  jQuery('tr.link-video').on('click', function (){
    myFunctions.execute('createTableUrlLink', tr_url_movie, this);
  });
  jQuery('tr.link-livro').on('click', function (){
    myFunctions.execute('createTableUrlLinkBook', tr_url_book, this);
  });
  jQuery('tr.link-subTopico').on('click', function (){
    myFunctions.execute('createTableUrlLinkTopico', tr_url_subTopico, this);
  });
  jQuery('tr.link-message').on('click', function (){
    myFunctions.execute('createTableUrlLinkMessage', tr_url_message, this);
  });
  jQuery('button.status-pagamento').on('click', function (){
    myFunctions.execute('alterarStatusPagamento', url_status_pagamento, this);
  });

  jQuery('select#sel-grupo, select#sel-assunto, select#sel-topico').on('change', function (){
    myFunctions.execute('createUrlSelectGroup', search_url_group, this);
  });
  jQuery('input[name="pesquisar"]').on('click', function (){
    event.preventDefault();
    myFunctions.execute('createUrlSelectGroup', search_url_group, this);
  });
  jQuery('select.search-topic-ajax').change(function (){
    myFunctions.execute('getSelectFormOfTopicByGroupId', jQuery(this), jQuery("select#"+jQuery(this).attr('data-fill')));
  });
  jQuery('select.search-recipient-ajax').change(function (){
    myFunctions.execute('getSelectFormOfRecipientByCategoryId', jQuery(this), jQuery("select#"+jQuery(this).attr('data-fill')));
  });

  jQuery('select.search-subject-ajax').change(function (){
    myFunctions.execute('getSelectFormOfSubjectByGroupId', jQuery(this), jQuery("select#"+jQuery(this).attr('data-fill')));
  });

  jQuery('select.search-gallery-photos-ajax').change(function (){
    myFunctions.execute('getSelectFormOfGalleryPhotosByTopicId', jQuery(this), jQuery("select#"+jQuery(this).attr('data-fill')));
  });
  jQuery('select.search-gallery-movies-ajax').change(function (){
    myFunctions.execute('getSelectFormOfGalleryMoviesByTopicId', jQuery(this), jQuery("select#"+jQuery(this).attr('data-fill')));
  });

  jQuery('select.get-gallery-photo-ajax').change(function (){
    myFunctions.execute('createMultUploadPhoto', jQuery(this).val(), jQuery(this));
    myFunctions.execute('getGalleryPhotos', jQuery(this), jQuery("#"+jQuery(this).attr('data-fill')));
  });
  jQuery('select.get-gallery-movie-ajax').change(function (){
    myFunctions.execute('createMultUploadMovie', jQuery(this).val(), jQuery(this));
    myFunctions.execute('getGalleryMovies', jQuery(this), jQuery("#"+jQuery(this).attr('data-fill')));
  });

  jQuery('select.search-escalation-ajax').change(function (){
    myFunctions.execute('getSelectFormOfEscalationByEscalationFather', jQuery(this), jQuery("select#"+jQuery(this).attr('data-fill')));
  });

  jQuery('select.value-donation').change(function (){
    myFunctions.execute('alterValueBottonPayment', jQuery(this));
  });

  jQuery('#response-ajax').on('click', 'button.remove-photo-gallery', function (){
    if(confirm('Deseja realmente excluir essa foto?'))
      myFunctions.execute('removePhotoGallery', jQuery(this).closest('.thumbnail'), null);
  });
  jQuery('#response-ajax').on('click', 'button.remove-movie-gallery', function (){
    if(confirm('Deseja realmente excluir esse vídeo?'))
      myFunctions.execute('removeMovieGallery', jQuery(this).closest('.thumbnail'), null);
  });

  jQuery('#response-ajax').on('click', 'button.save-comentary-photo-gallery', function (){
    myFunctions.execute('saveCometaryPhotoGallery', jQuery(this).closest('.thumbnail'), null);
  });
    jQuery('#response-ajax').on('click', 'button.save-comentary-movie-gallery', function (){
    myFunctions.execute('saveCometaryMovieGallery', jQuery(this).closest('.thumbnail'), null);
  });

  jQuery('#response-ajax').on('click', 'span.shared-photo-gallery', function (){
    myFunctions.execute('saveSharedPhotoGallery', jQuery(this).closest('.thumbnail'), jQuery(this));
  });
  jQuery('#response-ajax').on('click', 'span.shared-movie-gallery', function (){
    myFunctions.execute('saveSharedMovieGallery', jQuery(this).closest('.thumbnail'), jQuery(this));
  });

  jQuery('img[name="ativar"]').click(function (){
      myFunctions.execute('actions', jQuery(this), null);
  });

  // TABS (AUTO SHOW)
  jQuery('.tabs > li > a:first').tab('show');

  // TOOLTIPS (AUTO CREATE)
  jQuery('.tooltips').tooltip();
  jQuery(".accordion").collapse();

  $("#toggle-advance-search, #toggle-toolbar").on('click', function(){
    var element = jQuery(this).attr('data-element');
    $(element).slideToggle('fast', toggleIcoProcess(this));
  });

  $('.getAjax').change(function () {
    getDataForAjax($(this));
  });
});

var myFunctions = {
  execute : function(funcao, valor1, valor2){
    if(typeof this[funcao] == 'function')
      this[funcao](valor1, valor2);
  },
  message : function(data, element){
    var msg = '<div class="alert alert-'+data[1]+'">';
        msg += data[0];
        msg += '</div>';
    jQuery('.alert').remove();
    jQuery('#message-modal .modal-body').html(msg);
    jQuery('#message-modal').modal('show');
  },
  statusRegister : function(data, element){
    var ele = jQuery(element);
    this.message(data);
    this.destroyMessage(500, 4000);
    if(data[1] == 'success'){
      if(data[2]=='S'){
        ele.removeClass('glyphicon glyphicon-minus-sign red-ico');
        ele.addClass('glyphicon glyphicon-ok-sign green-ico');
        ele.attr('data-ac', 'N');
      }else{
        ele.removeClass('glyphicon glyphicon-ok-sign');
        ele.addClass('glyphicon glyphicon-minus-sign');
        ele.attr('data-ac', 'S');
      }
    }
  },
  deleteRegister : function(data, element){
    this.message(data);
    this.destroyMessage(500, 4000);
    if(data[1] == 'success')
      this.destroyElement(jQuery(element).parent('td').parent('tr'), 500);
  },
  orderRegister : function(data, element){
    jQuery('tbody#ord').html(data);
  },
  destroyMessage : function (timeFade, timeExecute){
    var t = setTimeout(function(){
      jQuery('.alert').fadeOut(timeFade)
      myFunctions.execute('removeLoadingMessage', null, '#message-modal');
    },timeExecute);
  },
  destroyElement : function (element, timeFade){
    jQuery(element).fadeOut(timeFade);
  },
  createLoadingMessage : function (data, element){
    var mHeader = jQuery(element + ' .modal-header');
    var mBody = jQuery(element + ' .modal-body')
    var img = jQuery('<img>');
    mHeader.remove();
    mBody.attr('style', 'text-align:center');
    img.attr('src', data);
    img.appendTo(mBody);
    jQuery(element).modal('show');
  },
  removeLoadingMessage : function (data, element){
    var mHeader = jQuery(element + ' .modal-header');
    var mBody = jQuery(element + ' .modal-body')
    mHeader.remove();
    mBody.empty();
    jQuery(element).modal('hide');
  },
  createTableUrlLink: function(data_url, element){
    var url  = '';
    var element = jQuery(element);
    var id   = element.data('id');
    var word = element.data('palavra');
    var type = element.data('btipo');
    if (word != undefined)
      url += '&b_palavra=' + word;
    if (tipo != undefined)
      url += '&b_tipo=' + type;
    url = data_url + id + url;
    myFunctions.execute('redirect', url, '');
  },
  createTableUrlLinkBook: function(data_url, element){
    var url  = '';
    var element   = jQuery(element);
    var id        = element.data('id');
    var capitulo  = element.data('capitulo');
    var pagina    = element.data('pagina');
    var palavra   = element.data('palavra');
    if (capitulo > 0)
      url += '&capitulo=' + capitulo;
    if (pagina > 0)
      url += '&pagina=' + pagina;
    if (palavra != undefined)
      url += '&b_palavra=' + palavra;
    url = data_url + id + url;
    myFunctions.execute('redirect', url, '');
  },
  createTableUrlLinkTopico: function(data_url, element){
    var url = '';
    var element = jQuery(element);
    if (isNumber(element.data('grupo')))
      url = '&grupo=' + element.data('grupo');
    if (isNumber(element.data('assunto')))
      url = '&assunto=' + element.data('assunto');
    if (isNumber(element.data('topico')))
      url = '&topico=' + element.data('topico');
    if (isNumber(element.data('subtopico')))
      url = '&sub-topico=' + element.data('subtopico');
    url = data_url + url;
    myFunctions.execute('redirect', url, '');
  },
  createTableUrlLinkMessage: function(data_url, element){
    var url = '';
    var element = jQuery(element);
    if (isNumber(element.data('id')))
      url = element.data('id');
    url = data_url + url;
    myFunctions.execute('redirect', url, '');
  },
  alterarStatusPagamento: function(data_url, element){
    if(confirm('Deseja realmente alterar o status?')){
      jQuery.post(
        data_url,
        { 'pagamento_id': jQuery(element).data('id'),
          'status' : jQuery(element).data('status') },
        function (data){
          var message = [];
          if(data.erro==1){
            message[0] = 'Não foi possivel alterar o status.';
            message[1] = 'danger';
          }else{
            message[0] = 'Status alterado com sucesso';
            message[1] = 'success';
          }
          myFunctions.execute('message', message, null);
          myFunctions.execute('destroyMessage',500, 4000);
        });
      setTimeout(redireciona, 4000);
    }
  },
  createUrlSelectGroup: function(data_url, element){
    var url = '';
    var grupo = jQuery('#sel-grupo');
    var assunto = jQuery('#sel-assunto');
    var topico = jQuery('#sel-topico');
    var eName = jQuery(element).attr('id');
    if(eName == 'sel-grupo'){
      assunto.prop('selectedIndex',0);
      topico.prop('selectedIndex',0);
    }else if(eName == 'sel-assunto'){
      topico.prop('selectedIndex',0);
    }
    if (isNumber(grupo.val()) && (isNumber(assunto.val()) || isNumber(topico.val())))
      url += '?op=exibe_topico&grupo=' + grupo.val();
    else
      url += '?grupo=' + grupo.val();
    if (isNumber(assunto.val()))
      url += '&assunto=' + assunto.val();
    if (isNumber(topico.val()))
      url += '&topico=' + topico.val();
    url = data_url + url;
    myFunctions.execute('redirect', url, '');
  },
  redirect: function(url){
    location.href = url;
  },
  getSelectFormOfTopicByGroupId: function(elementGroup, elementTopic){
    elementTopic.html('<option value="">Carregando...</option>');
    jQuery.post(
      '/adm/sj/includes/getTopico.php',
      { 'groupId': elementGroup.val(), 'selectedId' : elementTopic.attr('data-topicoId') },
      function (data){
        if (data.qtd != ""){
          elementTopic.removeAttr('data-topicoId');
          elementTopic.html(data.op);
        } else {
          elementTopic.html('<option value="">Nenhum registro encontrado!</option>');
        }
      }, 'json');
  },
  getSelectFormOfEscalationByEscalationFather: function(elementEscalationFather, elementEscalationChild){
    elementEscalationChild.html('<option value="">Carregando...</option>');
    jQuery.post(
      '/adm/sj/includes/getEscalation.php',
      { 'escalationId': elementEscalationFather.val(), 'selectedId' : elementEscalationChild.attr('data-escalationId') },
      function (data){
        if (data.qtd != ""){
          elementEscalationChild.removeAttr('data-escalationId');
          elementEscalationChild.html(data.op);
        } else {
          elementEscalationChild.html('<option value="">Nenhum registro encontrado!</option>');
        }
      }, 'json');
  },
  getSelectFormOfRecipientByCategoryId: function(elementGroup, elementRecipient){
    elementRecipient.html('<option value="">Carregando...</option>');
    jQuery.post(
      '/adm/sj/includes/getDestinatario.php',
      { 'categoryId': elementGroup.val(), 'selectedId' : elementRecipient.attr('data-destinararioId') },
      function (data){
        if (data.qtd != ""){
          elementRecipient.removeAttr('data-destinararioId');
          elementRecipient.html(data.op);
        } else {
          elementRecipient.html('<option value="">Nenhum destinatário encontrado!</option>');
        }
      }, 'json');
  },
  getSelectFormOfSubjectByGroupId: function(elementGroup, elementTopic){
    elementTopic.html('<option value="">Carregando...</option>');
    if(elementGroup.val() != 0){
      jQuery.post(
        '/adm/sj/includes/getAssunto.php',
        { 'groupId': elementGroup.val(), 'selectedId' : elementTopic.attr('data-topicoId') },
        function (data){
          if (data.qtd != ""){
            elementTopic.removeAttr('data-topicoId');
            elementTopic.html(data.op);
          } else {
            elementTopic.html('<option value="">Nenhum registro encontrado!</option>');
          }
        }, 'json');
    }
  },
  getSelectFormOfGalleryPhotosByTopicId: function(elementTopic, elementGallery){
    var idTopic = 0;
    elementGallery.html('<option value="">Carregando...</option>');
    if(elementTopic.val())
      var idTopic = elementTopic.val();
    else
      var idTopic = elementTopic.attr('data-topicoId');
    jQuery.post(
      '/adm/sj/includes/getGaleriaFoto.php',
      { 'topicId': idTopic, 'selectedId' : elementGallery.attr('data-galeriaId') },
      function (data){
        if (data.qtd != "")
          elementGallery.html(data.op);
        else
          elementGallery.html('<option value="">Nenhum registro encontrado!</option>');
      }, 'json');
  },
  getSelectFormOfGalleryMoviesByTopicId: function(elementTopic, elementGallery){
    var idTopic = 0;
    elementGallery.html('<option value="">Carregando...</option>');
    if(elementTopic.val())
      var idTopic = elementTopic.val();
    else
      var idTopic = elementTopic.attr('data-topicoId');
    jQuery.post(
      '/adm/sj/includes/getGaleriaVideo.php',
      { 'topicId': idTopic, 'selectedId' : elementGallery.attr('data-galeriaId') },
      function (data){
        if (data.qtd != "")
          elementGallery.html(data.op);
        else
          elementGallery.html('<option value="">Nenhum registro encontrado!</option>');
      }, 'json');
  },
  getGalleryPhotos: function(select, div){
    div.html("<h4>Aguarde carregando...</h4>");
    var idGallery = 0;
    if(select.val())
      idGallery = select.val();
    else
      idGallery = select.attr('data-galeriaId');
    jQuery.post("GALERIA_IMAGEM/getAllGallery.php",
    {'id' : idGallery},
    function(data){
      div.html(data);
    });
  },
  getGalleryMovies: function(select, div){
    div.html("<h4>Aguarde carregando...</h4>");
    var idGallery = 0;
    if(select.val())
      idGallery = select.val();
    else
      idGallery = select.attr('data-galeriaId');
    jQuery.post("GALERIA_VIDEO/getAllGallery.php",
    {'id' : idGallery},
    function(data){
      div.html(data);
    });
  },
  alterValueBottonPayment: function(select){
    jQuery('.form-group.buttons').show();
    var value = jQuery(select).val();
    if(value != ''){
      jQuery('input[name="itemAmount1"]').val(value);
      jQuery('input[name="amount"]').val(value);
    }else{
      jQuery('.form-group.buttons').hide();
    }
  },
  createMultUploadPhoto: function(id, select){
    if(!jQuery('#mult-upload > form').length){
      var form = jQuery('#mult-upload').append('<form>');
          form.append(jQuery('<div>').addClass('queue'));
          form.append(jQuery('<input>').attr({name:'file_upload', id:'file_upload', type: 'file', multiple: true}));
    }
    jQuery('#file_upload').uploadify({
      'width'    : '100%',
      'height'   : 40,
      'fileTypeDesc' : 'Image Files',
      'fileTypeExts' : '*.gif; *.jpg; *.png',
      'buttonText' : 'Selecionar fotos',
      'formData': { 'galeriaId':id },
      'swf': '/adm/sj/js/uploadify/uploadify.swf',
      'uploader': '/adm/sj/GALERIA_IMAGEM/upload.php',
      onQueueComplete: function(){
        myFunctions.execute('getGalleryPhotos', jQuery(select), jQuery("#"+jQuery(select).attr('data-fill')));
      }
    });
  },
  createMultUploadMovie: function(id, select){
    if(!jQuery('#mult-upload > form').length){
      var form = jQuery('#mult-upload').append('<form>');
          form.append(jQuery('<div>').addClass('queue'));
          form.append(jQuery('<input>').attr({name:'file_upload', id:'file_upload', type: 'file', multiple: true}));
    }
    // jQuery('#file_upload').uploadify({
    //   'width'    : '100%',
    //   'height'   : 40,
    //   'fileTypeDesc' : 'Movie Files',
    //   'fileTypeExts' : '*.mp4; *.webm',
    //   'buttonText' : 'Selecionar vídeos',
    //   'formData': { 'galeriaId':id },
    //   'swf': '/adm/sj/js/uploadify/uploadify.swf',
    //   'uploader': '/adm/sj/GALERIA_VIDEO/upload.php',
    //   onQueueComplete: function(){
    //     myFunctions.execute('getGalleryMovies', jQuery(select), jQuery("#"+jQuery(select).attr('data-fill')));
    //   }
    // });
  },
  removePhotoGallery: function(container){
    jQuery.post("GALERIA_IMAGEM/delete-photo.php",{
      'fotoId' : container.attr('data-id'),
      'directory' : container.attr('data-directory')
    },
    function(data){
      if(data.error == 0)
       container.closest('div[class^="col-"]').remove();
      myFunctions.execute('message', data.message, null);
      myFunctions.execute('destroyMessage',1000, 4000);
      myFunctions.execute('orderSortable', "GALERIA_IMAGEM/order.php", jQuery('.sortable'));
    },
    'json');
  },
  removeMovieGallery: function(container){
    jQuery.post("GALERIA_VIDEO/delete-video.php",{
      'fotoId' : container.attr('data-id'),
      'directory' : container.attr('data-directory')
    },
    function(data){
      if(data.error == 0)
       container.closest('div[class^="col-"]').remove();
      myFunctions.execute('message', data.message, null);
      myFunctions.execute('destroyMessage',1000, 4000);
      myFunctions.execute('orderSortable', "GALERIA_VIDEO/order.php", jQuery('.sortable'));
    },
    'json');
  },
  saveCometaryPhotoGallery: function(container){
    var textarea = container.find('textarea');
        textarea.attr('disabled', 'disabled');
    jQuery.post("GALERIA_IMAGEM/cometary.php",{
      'fotoId' : container.attr('data-id'),
      'text' : textarea.val()
    },
    function(data){
      myFunctions.execute('message', data.message, null);
      myFunctions.execute('destroyMessage',500, 4000);
      textarea.removeAttr('disabled');
    },
    'json');
  },
  saveCometaryMovieGallery: function(container){
    var textarea = container.find('textarea');
        textarea.attr('disabled', 'disabled');
    jQuery.post("GALERIA_VIDEO/cometary.php",{
      'fotoId' : container.attr('data-id'),
      'text' : textarea.val()
    },
    function(data){
      myFunctions.execute('message', data.message, null);
      myFunctions.execute('destroyMessage',500, 4000);
      textarea.removeAttr('disabled');
    },
    'json');
  },
  saveSharedPhotoGallery: function(container, element){
    jQuery.post("GALERIA_IMAGEM/shared.php",{
      'fotoId' : container.attr('data-id'),
      'action' : element.attr('data-ac')
    },
    function(data){
      myFunctions.execute('statusRegister', data.message, element);
    },
    'json');
  },
  saveSharedMovieGallery: function(container, element){
    jQuery.post("GALERIA_VIDEO/shared.php",{
      'fotoId' : container.attr('data-id'),
      'action' : element.attr('data-ac')
    },
    function(data){
      myFunctions.execute('statusRegister', data.message, element);
    },
    'json');
  },
  actions: function(element){
    jQuery.post(element.attr('data-url'),{
      'id' : element.attr('data-id'),
      'tp' : element.attr('data-tipo'),
      'ac' : element.attr('data-ac')
    },
    function(data){
      if(data.erro == 0){
        if(element.attr('data-ac') == 'S'){
          element.attr('src', "img/aprovado.png");
          element.attr('data-ac', 'N');
        }else{
          element.attr('src', "img/bloqueado.png");
          element.attr('data-ac', 'S');
        }
      }
    },
    'json');
  },
  orderSortable: function(url, element)
  {
    msg = new Array();
    msg[0] = '<img src="/adm/sj/img/loading.gif"> Aguarde processando a ordem...';
    msg[1] = 'info';
    myFunctions.execute('message', msg, null);
    var obj = jQuery(element).find('div[draggable="true"]');
    var ids = new Array();
    $.each(obj, function( key, value ) {
      var cont = jQuery(value).children('.thumbnail');
      var contId = cont.attr('data-id');
      ids[key] = cont.attr('data-id');
      cont.find('.badge').text(++key);
    });
    jQuery.post(url,
      {'order':ids},
      function(){
        myFunctions.execute('destroyMessage',500,1000);
    });
  }
};
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

jQuery.validator.setDefaults({
  errorElement: "p",
  errorClass: "help-block",
  highlight: function(element)
  {
    jQuery(element)
    .closest('.form-group')
    .removeClass('has-success')
    .addClass('has-error');
  },
  success: function(element)
  {
    jQuery('#'+element.attr('for'))
    .addClass('valid')
    .tooltip('destroy')
    .closest('.form-group')
    .removeClass('has-error')
    .addClass('has-success');
  },
  errorPlacement: function(error, element)
  {
    jQuery(element)
    .tooltip('destroy')
    .attr('data-animation','false')
    .attr('data-placement','bottom')
    .attr('data-trigger','manual')
    .attr('title',error.html())
    .tooltip('show');
  }
});

function toggleIcoProcess(e){
  var btn = jQuery(e);
  if(btn.children('span').hasClass('glyphicon-chevron-up')){
    btn.children('span').removeClass( "glyphicon-chevron-up" ).addClass( "glyphicon-chevron-down" );
  }else{
    btn.children('span').removeClass( "glyphicon-chevron-down" ).addClass( "glyphicon-chevron-up" );
  }
}
function escondeCampoBusca() {
  $('select[name="b_topico"], select[name="b_sub_topico"]').fadeOut(500);
}
function getDataForAjax(sel){
  if (sel.data('visivel') == undefined) {
    escondeCampoBusca();
  }
  if (sel.val()) {
    var el = $('select[name="' + sel.data('popula') + '"]');
    var id = el.attr('data-id');
    el.html('<option>Carregando...</option>');
    $.post(
      '/adm/sj/' + sel.data('url'), {
        'id': sel.val(),
        'selectedId': id
      },
      function (data) {
        if (data.qtd != 0) {
          if (sel.data('visivel') != undefined)
            $('select[name="' + sel.data('visivel') + '"]').fadeIn(500);
            el.html(data.op);
        } else {
          el.html('<option value="">Nenhum registro encontrado!</option>');
        }
      }, 'json');
  }
}
function redireciona() {
  location.reload();
}