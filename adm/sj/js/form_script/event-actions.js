jQuery('document').ready(function(){
  $('select[name="id_grupo"]').change(function(){
    var id = $(this).val();
    setSession(id);
  });
  var id = $('select[name="id_grupo"]').val();
  if(id){
    setSession(id);
  }
});

function createEditor() 
{
  var name = 'texto';
  var editor = CKEDITOR.instances[name];
  if (!editor)
    CKEDITOR.replace(name);
  else
    clearEditor();
}

function setSession(id)
{
  if(id){
    $.post('EVENTOS/set_session.php', {
      'id': id
    }, function(data){
      if(!data.erro)
        createEditor();
    }, 'json');
  }else{
    destroyEditor();
  }
}

function destroyEditor() {
  CKEDITOR.instances['texto'].destroy(true);
}

function clearEditor() {
  CKEDITOR.instances['texto'].setData('');
}