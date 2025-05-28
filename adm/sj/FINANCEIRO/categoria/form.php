<div class="well well-lg">
  <form action="#" method="post" id="form" class="form-horizontal" role="form">
    <?=$form->input('hidden', 'id', $ln['id']);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nome:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'nome', $ln['nome'], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <?=$form->input('submit', 'submit', 'Salvar', array('class'=>'btn btn-info'));?>
      </div>
    </div>
  </form>
</div>