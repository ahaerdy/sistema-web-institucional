var selectGrupo = jQuery('select[name="grupo"]');
var selectTopico = jQuery('select[name="topico"]');
if(selectGrupo.val()){
	myFunctions.execute('getSelectFormOfTopicByGroupId', selectGrupo, selectTopico);
}

jQuery('select[name="topico"]').change(function(){
	var id = $(this).val();
	if(id != ''){
		setSession(id);
	}
});
jQuery('document').ready(function(){
	var id = $('input[type="hidden"][name="topico"]').val();
	if(id != ''){
		setSession(id);
	}
});

function createEditor()
{
	$('textarea[name="texto"]').removeAttr('disabled');
	CKEDITOR.replace('texto');
}

function setSession(id)
{
	if(id){
		$.post('ARTIGO/set_session.php', {
			'id': id
		}, function(data){
			if(!data.erro)
				createEditor();
		}, 'json');
	}
}