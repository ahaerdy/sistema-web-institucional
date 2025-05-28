<?php
	if(isPost()):
		$res = cloneRegistro(getParam('artigo'), getParam('topico'), 'artigos', 'id_topico');
		if($res):
			copiaDiretorios();
			setFlashMessage('Artigo clonado com sucesso!', 'success');
		else:
			setFlashMessage('O artigo não pode ser clonado!', 'success');
		endif;
		echo redirect2('index.php?op=list_art');
		exit;
	else:
		$form = new formHelper();
?>
		<div class="page-header">
			<h2>Clonar Artigo</h2>
		</div>
		<div class="well well-lg">
			<form action="<?=$url;?>" method="post" class="form-horizontal" enctype='multipart/form-data'>
				<?=$form->input('hidden', 'artigo', getParam("op1"));?>
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
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<?=$form->input('submit', 'submit', 'Clonar', array('class'=>'btn btn-info'));?>
					</div>
				</div>
			</form>
		</div>
<?php
	endif;

?>