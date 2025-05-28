jQuery('document').ready(function(){
	var selectCategoria = jQuery('select[name="categoria"]');
	var selectDestinatario = jQuery('select[name="destinatario"]');
	if(selectCategoria.val())
		myFunctions.execute('getSelectFormOfRecipientByCategoryId', selectCategoria, selectDestinatario);
});