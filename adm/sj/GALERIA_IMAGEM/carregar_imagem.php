<?php if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>
<? $form = new formHelper(); ?>

<link rel="stylesheet" type="text/css" href="/adm/sj/js/uploadify/uploadify.css">

<div class="page-header">
  <h2>Carregando Fotos</h2>
</div>
<div class="well well-lg">
  <form action="#" class="form-horizontal" id="form-gallery">
    <div class="form-group">
      <label class="col-sm-2 control-label">Grupo:</label>
      <div class="col-sm-10">
        <? $params = array('class'=>"form-control search-topic-ajax", 'data-fill'=>"topico", 'data-grupoId'=>(int)getParam('grupo'));?>
        <? require('includes/html/select/select-group.php'); ?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tópico:</label>
      <div class="col-sm-10">
        <?=$form->select('topico', null, null, array('id'=>'topico', 'class'=>'form-control search-gallery-photos-ajax', 'data-fill'=>'galeria', 'data-topicoId'=>(int)getParam('topico')), '-');?>
      </div>
    </div>
		<div class="form-group">
			<label class="col-sm-2 control-label"> Galeria: </label>
  		<div class="col-sm-10">
        <?=$form->select('galeria', null, null, array('id'=>'galeria', 'class'=>'form-control get-gallery-photo-ajax', 'data-fill'=>'response-ajax', 'data-galeriaId'=>(int)getParam('galeria')), '-');?>
      </div>
    </div>
	</form>
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
      <div id="mult-upload">
      </div>
      <div id="response-ajax">
      </div>
    </div>
  </div>
</div>

<?php
  $scripts = array();
  $scripts[] = 'js/form_script/gallery-image-actions.js';
?>