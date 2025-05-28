<?php mysql_data_seek($res, 0); ?>
<div class="row">
	<div class="col-lg-12">
		<div class="page-header title-photo">
		<h2><?=mysql_result($res, 0, 'gl_titulo');?></h2>
		</div>
		<small class="pull-right"><?=mysql_result($res, 0, 'gl_cadastro');?></small>
		<div class="spacing"></div>
		<p class="galleria-texto" style="text-align:justify"><?=stripslashes(nl2br(mysql_result($res, 0, 'gl_descricao')));?></p>
		<div class="spacing"></div>
	</div>
</div>