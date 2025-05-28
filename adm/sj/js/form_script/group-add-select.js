$('document').ready(function(){
  $('.group .panel-body').on('click', 'a.add', function(){
    event.preventDefault();
    var item = $(this);
    var container = item.closest('.input-group').clone();
        container.find('span > a')
        .attr('data-item', item.attr('data-item'))
        .removeClass("add")
        .addClass("remove")
        .find('span')
        .removeClass("label-success")
        .addClass("label-danger")
        .find('span')
        .removeClass("glyphicon-plus")
        .addClass("glyphicon-remove");
      container.find('select').find('option[selected]').removeAttr("selected");
      item.closest('.group .panel-body').append(container);
    processSelect(container.find('select'));
  });
  $('.group .panel-body').on('click', 'a.remove', function(){
    event.preventDefault();
    if(confirm("Deseja apagar esse grupo?")){
      $(this).closest('.input-group').remove();
      $(this).closest('.input-group').find('select').each(function(){
        processSelect($(this));
      });
    }
  });
  $(".group .panel-body").on('change', 'select', function(){
    processSelect(this);
  });
  $('.group .panel-body').find('select:first').each(function(){
    processSelect(this);
  });
  function processSelect(ele){
    var name = $(ele).attr('name');
    var sel = $('select[name="'+name+'"]');
        sel.find('option').removeAttr('disabled');
        sel.find('option:selected').each(function(){
          sel.find('option:not(:selected)[value="'+$(this).val()+'"]').attr({disabled:"disabled"});
        });
  }
});