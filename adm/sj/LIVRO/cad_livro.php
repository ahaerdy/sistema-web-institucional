<?php
  if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $grupoId  = (int) getParam('grupo');
  $topicoId = (int) getParam('topico');
  $livroId  = (int) getParam('id');
  if(!empty($livroId)):
    $res = mysql_query("SELECT 
                          lv.*, 
                          lv.foto as capa,
                          DATE_FORMAT(lv.cadastrado, '%d/%m/%Y') AS data, 
                          DATE_FORMAT(lv.cadastrado, '%H:%i') AS hora,
                          CONCAT('/arquivo_site/',gp.diretorio,'/topicos/',tp.diretorio,'/livros/') as diretorio,
                          CONCAT('/arquivo_site/',gp.diretorio,'/topicos/',tp.diretorio,'/livros/',lv.foto) as foto
                          FROM grupos gp
                          INNER JOIN topicos tp ON gp.id = tp.id_grupo
                          INNER JOIN livros lv ON tp.id = lv.id_topico
                          WHERE lv.id = ${livroId} LIMIT 1");
    $ln = mysql_fetch_assoc($res);
  endif;
  $form = new formHelper();
?>

<ul class="nav nav-tabs" id="myTab">
  <li><a href="#tab1" data-toggle="tab">Dados do Livro</a></li>
  <li><a href="#tab2" data-toggle="tab">Dados da Seção</a></li>
  <li><a href="#tab3" data-toggle="tab">Páginas</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active"  id="tab1"><?php require 'LIVRO/forms/book.php';?></div>
  <div class="tab-pane"         id="tab2"><?php require 'LIVRO/forms/sections.php';?></div>
  <div class="tab-pane"         id="tab3"><?php require 'LIVRO/forms/pages.php'; ?></div>
</div>
<style>
.well {
  border-top: 0;
  border-radius: 0;
}
</style>
<?php
	$scripts = array();
	$scripts[] = '/adm/sj/js/plugins/ckeditor/ckeditor.js';
	$scripts[] = '/adm/sj/js/form_script/book-actions.js';
?>