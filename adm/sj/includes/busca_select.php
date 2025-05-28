<?php
  $idGrupo        = (int)addslashes(strip_tags(getParam('b_grupo')));
  $idAssunto    = (int)addslashes(strip_tags(getParam('b_assunto')));
  $idTopico       = (int)addslashes(strip_tags(getParam('b_topico')));
  $idSubtopico  = (int)addslashes(strip_tags(getParam('b_sub-topico')));
  $categoria      = addslashes(strip_tags(getParam('b_categoria')));
  $tipo               = addslashes(strip_tags(getParam('b_tipo')));
  $form             = new formHelper();
?>
<div class="row">
  <form action="<?=$_SERVER['PHP_SELF'];?>" method="get" role="form" class='form-advanced-search' onsubmit="return validate_a()">
    <?=$form->input('hidden', 'op', getParam('op'));?>
    <?=$form->input('hidden', 'buscar', 'Buscar');?>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="input-group">
        <?=$form->input('text', 'b_palavra', getParam('b_palavra'), array('class'=>'form-control', 'placeholder'=>'Palavra ou Expressão'),'pesquisa_a');?>
        <span class="input-group-btn">
          <input type="submit" class="btn btn-info" value="Pesquisar" />
        </span>
      </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <?
        $res = mysql_query("SELECT id, nome FROM grupos WHERE id > '2' AND id IN (".$_SESSION['login']['usuario']['todos_id_us'].") AND ativo = 'S' ORDER BY nome");
        $rows = getDataFormSelect($res);
        echo $form->select('b_grupo', getParam('b_grupo'), $rows, array('class'=>'getAjax form-control', 'data-popula'=>'b_assunto', 'data-url'=>'/includes/getTopicoUsuario.php'), ' - Selecione o Grupo - ');
      ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <?
        if($idGrupo):
          $res = mysql_query("SELECT tp.id, tp.nome FROM  grupos gp INNER JOIN topicos tp ON tp.id_grupo = gp.id WHERE (( gp.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR ( gp.id IN (".$_SESSION['login']['usuario']['todos_id_us'].") AND gp.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND tp.compartilhado = 'S' )) AND (tp.id_topico IS NULL OR tp.id_topico = 0) AND gp.id = ${idGrupo} ORDER BY tp.nome ASC");
          $rows = getDataFormSelect($res);
        else:
          $rows = array();
        endif;
        echo $form->select('b_assunto', getParam('b_assunto'), $rows, array('class'=>'getAjax form-control','data-popula'=>'b_topico','data-visivel'=>'b_topico','data-url'=>'/includes/getTopicoUsuario.php'),' - Selecione o Assunto - ');
      ?>
    </div>
    
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <?=$form->select('b_topico', '', array(), array('data-id'=>getParam('b_topico'),'class'=>'getAjax form-control','data-popula'=>'b_sub_topico','data-visivel'=>'b_sub_topico','data-url'=>'/includes/getTopicoUsuario.php', 'style'=>'display: none;'),' - Selecione o Tópico - ');?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <?=$form->select('b_sub_topico', '', array(), array('data-id'=>getParam('b_sub_topico'), 'class'=>'form-control', 'style'=>'display: none;'),' - Selecione o Sub-Tópico - ');?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <?
        $cat = array();
        $cat['T'] = 'Todas Categorias';
        $cat['A'] = 'Artigos';
        $cat['V'] = 'Vídeos';
        $cat['F'] = 'Fotos';
        $cat['L'] = 'Livros';
        echo $form->select('b_categoria', getParam('b_categoria'), $cat, array('class'=>'form-control'));
      ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
      <?
        $type = array();
        $type['P'] = 'Contenha alguma palavra';
        $type['I'] = 'Contenha todas palavras no texto';
        $type['F'] = 'Contenha essa expressão';
        echo $form->select('b_tipo', getParam('b_tipo'), $type, array('class'=>'form-control'));
      ?>
    </div>
  </form>
</div>

<?php
  $scripts[] = 'js/form_script/search.js'
?>

<script type="text/javascript">
function validate_a() {
    if (document.getElementById("pesquisa_a").value == "" && document.getElementById("pesquisa_a").value == "") {
         // alert("all fields are empty");
         return false;
    } else {
        return true;
    }
}
</script>