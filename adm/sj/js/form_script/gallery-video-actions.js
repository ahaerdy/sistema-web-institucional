jQuery('document').ready(function ($) {
  var selectGrupo = $('select[name="grupo"]');
  var selectTopico = $('select[name="topico"]');
  var selectGaleria = $('select[name="galeria"]');
  if(selectGrupo.val())
    myFunctions.execute('getSelectFormOfTopicByGroupId', selectGrupo, selectTopico);
  if(selectTopico.attr('data-topicoId') > 0)
  {
    myFunctions.execute('getSelectFormOfGalleryMoviesByTopicId', selectTopico, $("select#"+selectTopico.attr('data-fill')));
    myFunctions.execute('createMultUploadMovie', selectGaleria.attr('data-galeriaId'), selectGaleria);
    myFunctions.execute('getGalleryMovies', selectGaleria, jQuery("#"+selectGaleria.attr('data-fill')));
  }
});