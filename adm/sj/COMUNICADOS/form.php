<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <?=$form->input('hidden', 'iCom', $ln["id"]);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Grupo:</label>
      <div class="col-sm-10">
        <? $params = array('class'=>"form-control required"); $field = 'grupo_id'; $value = $ln['grupos_id'];?>
        <? require('includes/html/select/select-group.php'); ?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Título:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'titulo', $ln["titulo"], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Data</label>
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-6">
            <div class="input-group bfh-datepicker" data-format="d/m/y" data-date="<?=($ln["data"])?$ln["data"]:'today';?>" data-name="data">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'data', '', array('class'=>'required form-control'));?>
              <span class="input-group-addon"> ás </span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-group bfh-timepicker" <?=($ln["hora"])?'data-time="'.$ln["hora"].'"':'';?> data-name="hora">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'hora', '', array('class'=>'required form-control'));?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Resumo:</label>
      <div class="col-sm-10">
        <?=$form->textarea('descricao', $ln["descricao"], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Descrição:</label>
      <div class="col-sm-10">
        <?=$form->textarea('texto', $ln["texto"], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-1">
        <?=$form->input('submit', 'submit', 'Salvar', array('class'=>'btn btn-info'));?>
      </div>
      <div class="col-sm-9">
        <div class="checkbox pull-right" style="margin-right: 15px;">
          <label>
            <?=$form->input('checkbox', 'notificacao', 'S',  array('class'=>'btn btn-info'));?> Enviar noticação
          </label>
        </div>
      </div>
     </div>
    </div>
  </div>
 </div>
</form>

<?php
  	$scripts = array();
	$scripts[] = '/adm/sj/js/plugins/ckeditor/ckeditor.js';
	$scripts[] = '/adm/sj/js/form_script/communication-actions.js';
?>