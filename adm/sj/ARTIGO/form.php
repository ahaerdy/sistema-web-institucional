<?php
  if(!$ln['id'])
    $url = '/adm/sj/index.php?op=cad_art';
  else
    $url = '/adm/sj/index.php?op=alte_art';
?>

<div class="well well-lg">
  <form action="<?=$url;?>" method="post" class="form-horizontal" enctype='multipart/form-data'>
    <?=$form->input('hidden', 'artigo', $ln["id"]);?>
    <?=$form->input('hidden', 'topico', $ln["id_topico"]);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Grupo:</label>
      <div class="col-sm-10">
        <? $params = array('class'=>"form-control required search-topic-ajax", 'data-fill'=>"topico");?>
        <? require('includes/html/select/select-group.php'); ?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tópico:</label>
      <div class="col-sm-10">
        <?=$form->select('topico', null, null, array('id'=>'topico', 'class'=>'form-control required', 'data-topicoId'=>$ln['id_topico']), '-');?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Título:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'titulo', $ln["titulo"], array('class'=>'required form-control'));?>
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
      <label class="col-sm-2 control-label">Capa:</label>
      <div class="col-sm-10">
        <?=$form->input('file', 'capa', '', array('class'=>'form-control'));?>
        <span class="label-block">Tamanho máximo 4MB</span>
      </div>
    </div>
    <? if(!empty($ln['foto'])): ?>
      <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
          <img src="<?=getPhoto('/'.base64_encode($ln['foto']).'.'.substr($ln['foto'], -4), $ln['capa']);?>" class="img-rounded" height="40px">
          <div class="checkbox">
            <label>
              <input name="excluir-foto" value="S" type="checkbox"> Excluir Imagem?
            </label>
          </div>
        </div>
      </div>
    <? endif; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Texto:</label>
      <div class="col-sm-10">
        <?=$form->textarea('texto', $ln['texto'], array('class'=>'form-control', 'id'=>'texto', 'disabled'=>'disabled'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-1">
        <?=$form->input('submit', 'submit', 'Salvar', array('class'=>'btn btn-info'));?>
      </div>
      <div class="col-sm-9">
        <div class="checkbox pull-right">
          <label>
            <?=$form->input('checkbox', 'edit', 'S',  array('class'=>'btn btn-info', 'checked'=>'checked'));?> Salvar e continuar editando
          </label>
        </div>
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
	$scripts[] = '/adm/sj/js/form_script/article-actions.js';
?>
