<div class="well well-lg">
  <form action="/adm/sj/LIVRO/save-pagina.php" method="post" id="formPage" class="form-horizontal">
    <?=$form->input('hidden', 'id_livro', $ln['id']);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Seção:</label>
      <div class="col-sm-10">
        <?php
          if(!empty($ln['id'])):
            $res = mysql_query("SELECT id, numero FROM capitulos WHERE id_livro = '".$ln['id']."' ORDER BY ordem ASC");
            $rows = getDataFormSelect($res, array('id', 'numero'));
          else:
            $rows = array();
          endif;
          echo $form->select('id_capitulo', $ln['id'], $rows, array('id'=>'section2', 'data-ac'=>'2', 'data-idLivro'=>$ln['id'], 'class'=>'form-control'), '-- Seção --');
        ?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Página:</label>
      <div class="col-sm-10">
        <div class="input-group">
          <?=$form->select('id_pagina', null, null, array('id'=>'page', 'class'=>'form-control', 'disabled'=>'disabled'), '-- Nova Página --');?>
          <span class="input-group-addon">
            <span class="label label-danger">
              <span class="glyphicon glyphicon-remove" id="removePage"></span>
            </span>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Numero da Página:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'numero', null, array('id'=>'numero', 'class'=>'form-control bfh-number', 'disabled'=>'disabled', 'data-min'=>1));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Texto:</label>
      <div class="col-sm-10">
        <?=$form->textarea('texto', null, array('class'=>'form-control', 'id'=>'texto', 'disabled'=>'disabled'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <?=$form->input('submit', 'submit', 'Salvar', array('id'=>'sub-pagina', 'class'=>'btn btn-info', 'disabled'=>'disabled'));?>
      </div>
    </div>
  </form>
</div>