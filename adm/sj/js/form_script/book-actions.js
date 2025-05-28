jQuery('document').ready(function ($) {
  var v0 = $("#formBook").validate({
    submitHandler: function (form) {
      event.preventDefault();
      submitAjax(form, processJson0);
    }
  });
  var v1 = $("#formSections").validate({
    submitHandler: function (form) {
      event.preventDefault();
      submitAjax(form, processJson1);
    }
  });
  var v2 = $("#formPage").validate({
    submitHandler: function (form) {
      event.preventDefault();
      $('form#formPage textarea[name=texto]').val(CKEDITOR.instances.texto.getData());
      submitAjax(form, processJson2);
    }
  });
  $("#section1").change(function () {
    var el = $(this);
    var form = el.closest('form');
    if (el.val() == "") {
      clearForm(form);
      activeForm(form);
      hideButtonDestroySection(form);
      //clearEditor();
    } else {
      form.find('.label-danger').show();
      $.post(
        '/adm/sj/LIVRO/get_capitulo.php', {
          'id': el.val(),
          'ac': el.data('ac'),
          'id_livro': $("input[name='id_livro']").val()
        },
        function (data) {
          if (data.erro == 0) {
            for (var index in data.data) {
              if(index != 'paginado')
                $("form#formSections input[name='" + index + "']").val(data.data[index]);
              else
                $("form#formSections select[name='" + index + "']").find('option[value="'+data.data[index]+'"]').attr("selected", "selected");

            };
            activeForm(form);
          } else {
            setMenssageData(data);
          }
        },
        'json'
      );
    }
  });
  $("#section2").change(function () {
    var el = $(this);
    var form = el.closest('form');
    activeForm(form);
    if (el.val() == "") {
      clearForm(form);
      clearEditor();
      destroyEditor();
    } else {
      form.find('.label-danger').show();
      $.post("/adm/sj/LIVRO/get_pagina.php", {
          'ac': 2,
          'id_capitulo': el.val()
        },
        function (data) {
          setSession();
          if (data.erro == 1) {
            blockFormPage(form);
          } else {
            createEditor();
            form.find("select#page").html(data.data);
          }
        },
        'json'
      );
    }
  });
  $("select#page").change(function () {
    var el = $(this);
    var form = el.closest('form');
    var id_capitulo = form.find('select#section2').val();
    $('form#formPage input[type="text"], textarea').val('');
    if (el.val() == "") {
      clearEditor();
    } else {
      $.post("/adm/sj/LIVRO/get_pagina.php", {
          'ac': 1,
          'id': el.val(),
          'id_capitulo': id_capitulo
        },
        function (data) {
          if (data.erro == 1) {
            setMenssageData(data);
          } else {
            setSession();
            for (var index in data.data) {
              $("form#formPage input[name='" + index + "']").val(data.data[index]);
            };
            CKEDITOR.instances['texto'].setData(data.data['texto']);
          }
        },
        'json'
      );
    }
  });
  $("#addSection").click(function () {
    var form = $(this).closest('form');
    clearForm(form);
    activeForm(form);
    hideButtonDestroySection(form);
  });
  $("#removeSection").click(function () {
    var ele = $('select#section1');
    var id = ele.val();
    var form = ele.closest('form');
    if (id) {
      if (confirm('Deseja excluir essa seção?')) {
        $.post(
          '/adm/sj/LIVRO/remove_capitulo.php', {
            'id': id
          },
          function (data) {
            if (data.erro == 0) {
              clearForm(form);
              getSelectCapitulo();
            }
            setMenssageData(data);
          },
          'json'
        );
      }
    }
  });
  $("#removePage").click(function () {
    var ele = $(this);
    var form = ele.closest('form');
    var id = form.find('select[name="id_pagina"]').val();
    if (id) {
      if (confirm('Deseja realmente excluir essa página?')) {
        $.post(
          '/adm/sj/LIVRO/remove_pagina.php', {
            'id': id
          },
          function (data) {
            if (data.erro == 0) {
              getSelectPagina();
              clearForm(form);
            }
            setMenssageData(data);
          },
          'json'
        );
      }
    }
  });

  var selectGrupo = jQuery('select[name="grupo"]');
  var selectTopico = jQuery('select[name="topico"]');
  if(selectGrupo.val())
    myFunctions.execute('getSelectFormOfTopicByGroupId', selectGrupo, selectTopico);
});


function processJson0(data) {
  $("input[name='id_livro']").val(data.id_livro);
  if(data.foto){
    $('#content-foto').show();
    $("input[name='foto']").val('');
    $("input[name='fotoat']").val(data.foto);
    $('img#foto').attr('src', $("input[name='diretorio']").val()+data.foto);
  } else {
    $('#content-foto').hide();
  }
  setMenssageData(data);
}

function processJson1(data) {
  if (data.erro == 0 && data.id_capitulo > 0) {
    getSelectCapitulo();
    clearForm('form#formSections');
  }
  setMenssageData(data);
}

function processJson2(data) {
  if (data.erro == 0 && data.id_pagina > 0) {
    getSelectPagina();
    clearForm('form#formPage');
    clearEditor();
  }
  setMenssageData(data);
}

function setMenssageData(data) {
  myFunctions.execute('message', data.message, null);
  myFunctions.execute('destroyMessage', 250, 1000);
}

function activeFormPage() {
  getSelectCapitulo();
  activeForm('#formPage');
}

function submitAjax(form, callback) {
  $(form).ajaxSubmit({
    dataType: 'json',
    success: callback
  });
}

function clearForm(form) {
  var form = $(form);
  form[0].reset();
}

function showButtonDestroySection(form) {
  form.find('.label-danger').show();
}

function hideButtonDestroySection(form) {
  form.find('.label-danger').hide();
}

function setSession() {
  var id = $('form#formBook select[name="topico"]').val();
  if(id){
    $.post('LIVRO/set_session.php', {
      'id': id
    });
  }
}

function getSelectPagina() {
  var sel = $('form#formPage select#section2');
  var sel2 = $('form#formPage select#page');
  $.post(
    '/adm/sj/LIVRO/get_pagina.php', {
      'ac': 2,
      'id_capitulo': sel.val()
    },
    function (data) {
      sel2.html(data.data);
    },
    'json'
  );
}

function getSelectCapitulo() {
  $.post(
    '/adm/sj/LIVRO/get_capitulo.php', {
      'ac': 2,
      'id_livro': $('form#formSections input[name="id_livro"]').val()
    },
    function (data) {
      $("#section1").html(data.option);
      $("#section2").html(data.option);
    },
    'json'
  );
}

function blockFormPage(form) {
  form.find('input').attr('disabled', 'disabled');
}

function activeForm(form) {
  form.find('input').removeAttr('disabled');
  form.find('select').removeAttr('disabled');
  form.find('textarea').removeAttr('disabled');
}

function createEditor() {
  var name = 'texto';
  var editor = CKEDITOR.instances[name];
  if (!editor)
    CKEDITOR.replace(name);
  else
    clearEditor();
}

function destroyEditor() {
  var editor = CKEDITOR.instances["texto"];
  if (editor)
    editor.destroy(true);
}

function clearEditor() {
  var editor = CKEDITOR.instances["texto"];
  if (editor)
    editor.setData('');
}

$('#myTab a:first').tab('show');