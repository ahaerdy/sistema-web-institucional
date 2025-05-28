jQuery('document').ready(function(){
  $('select[name="grupo_id"]').change(function(){
    var id = $(this).val();
    if(id){
      setSession(id);
    }else{
      destroyEditor();
    }
  });
  var id = $('select[name="grupo_id"]').val();
  if(id){
    setSession(id);
  }
});

function setSession(id)
{
  $.post('COMUNICADOS/set_session.php', {
    'id': id
  }, function(data){
    if(!data.erro)
      createEditor();
  }, 'json');
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
  CKEDITOR.instances['texto'].destroy(true);
}

function clearEditor() {
  CKEDITOR.instances['texto'].setData('');
}

