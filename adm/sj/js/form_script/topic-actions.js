var selectGrupo = jQuery('select[name="grupo"]');
var selectTopico = jQuery('select[name="id_topico_pai"]');
if(selectGrupo.val())
	myFunctions.execute('getSelectFormOfTopicByGroupId', selectGrupo, selectTopico);