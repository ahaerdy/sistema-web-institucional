<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <?=$form->input('hidden', 'topico', $ln["id"]);?>
    <? if(empty($ln["id"])): ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Grupo</label>
        <div class="col-sm-10">
          <? $params = array('class'=>"form-control required search-topic-ajax", 'data-fill'=>"topico");?>
          <? require('includes/html/select/select-group.php'); ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Assunto / Tópico / Sub-Tópico</label>
        <div class="col-sm-10">
          <?=$form->select('id_topico_pai', null, null, array('id'=>'topico', 'class'=>'form-control required', 'data-topicoId'=>($ln['id_topico'])?$ln['id_topico']:getParam('topico')), '-');?>
        </div>
      </div>
    <? else: ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Grupo</label>
        <div class="col-sm-10">
          <p class="form-control-static"><?=$ln['grupo'];?></p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Assunto / Tópico / Sub-Tópico</label>
        <div class="col-sm-10">
          <p class="form-control-static"><?=$ln['topico'];?></p>
        </div>
      </div>
    <? endif; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Título</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'titulo', $ln["nome"], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Criado</label>
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
            <div class="input-group bfh-timepicker" <?=($ln["hora"])?'data-time="'.$ln["hora"].'"':'now';?> data-name="hora">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'hora', '', array('class'=>'required form-control'));?>
            </div>
          </div>
        </div>
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
<?php
  $scripts = array();
  $scripts[] = '/adm/sj/js/form_script/topic-actions.js';
?>