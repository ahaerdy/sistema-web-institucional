<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <?=$form->input('hidden', 'id', $ln["id"]);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Título</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'titulo', $ln["titulo"], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Descrição</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'descricao', $ln["descricao"], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <hr>
        <?=$form->input('submit', 'submit', 'Salvar', array('class'=>'btn btn-info'));?>
      </div>
    </div>
  </form>
</div>