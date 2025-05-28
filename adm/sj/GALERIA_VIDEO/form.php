<div class="well well-lg">
  <form action="#" method="post" id="form" class="form-horizontal">
    <?=$form->input('hidden', 'id', $ln['id'], array('class'=>'required form-control'));?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Título:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'titulo', $ln['titulo'], array('class'=>'required form-control'));?>
      </div>
    </div>
    <? if(empty($ln['id'])): ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Grupo:</label>
        <div class="col-sm-10">
          <? $params = array('class'=>"form-control search-topic-ajax", 'data-fill'=>"topico");?>
          <? require('includes/html/select/select-group.php'); ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">Tópico:</label>
        <div class="col-sm-10">
          <?=$form->select('topico', null, null, array('id'=>'topico', 'class'=>'form-control'), '-');?>
        </div>
      </div>
    <? else: ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Tópico:</label>
        <div class="col-sm-10">
          <?
            $res = mysql_query("SELECT gp.nome as grupo, tp.nome as topico FROM grupos gp INNER JOIN topicos tp ON gp.id = tp.id_grupo WHERE tp.id = ".$ln['id_topico']); 
            if(mysql_num_rows($res))
              echo '<b>Grupo:</b> ' . mysql_result($res, 0, 'grupo') .' | <b>Tópico:</b> '.mysql_result($res, 0, 'topico');
          ?>
        </div>
      </div>
    <? endif; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Comentário:</label>
      <div class="col-sm-10">
        <?=$form->textarea('descricao', $ln['descricao'], array('class'=>'required form-control', 'rows'=>'10', 'cols'=>'71'));?>
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
            <div class="input-group bfh-timepicker" <?=($ln["hora"])?'data-time="'.$ln["hora"].'"':'';?> data-name="hora">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'hora', '', array('class'=>'required form-control'));?>
            </div>
          </div>
        </div>
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
  </form>
</div>