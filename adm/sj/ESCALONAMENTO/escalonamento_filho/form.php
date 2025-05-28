<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <?=$form->input('hidden', 'id', $ln["id"]);?>
    <?=$form->input('hidden', 'grupo_ant_id', $ln["grupo_id"]);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Grupo</label>
      <div class="col-sm-10">
        <? $params = array('class'=>"form-control required"); $field = 'grupo'; $value = $ln['grupo_id']; ?>
        <? require('includes/html/select/select-group.php'); ?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Escalonamento Pai</label>
      <div class="col-sm-10">
        <?php
          $id = (empty($ln['id']))?0:$ln['id'];
          $res = mysql_query("SELECT id, titulo as nome FROM escalonamentos WHERE escalonamento_id IS NULL AND id != ${id} ORDER BY ordem ASC, titulo ASC");
          $rows = getDataFormSelect($res);
          echo $form->select('escalonamento_id', $ln['escalonamento_id'], $rows, array('class'=>'required form-control'), '-');
        ?>
      </div>
    </div>
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
      <label class="col-sm-2 control-label">Ordem</label>
      <div class="col-sm-10">
        <?=$form->input('number', 'ordem', $ln["ordem"], array('class'=>'required number form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Bloqueia select grupos</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'bloqueia_select', $ln["bloqueia_select_grupos"], array('class'=>'required form-control'));?>
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