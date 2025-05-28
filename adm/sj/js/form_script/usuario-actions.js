jQuery('document').ready(function ($) {
  var selectEscalonamentoPai = $('select[name="escalonamento_pai_id"]');
  var selectEscalonamentoFilho = $('select[name="escalonamento_id"]');
  if(selectEscalonamentoPai.val())
    myFunctions.execute('getSelectFormOfEscalationByEscalationFather', selectEscalonamentoPai, selectEscalonamentoFilho);
});