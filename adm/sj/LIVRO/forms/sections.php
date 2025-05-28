<div class="well well-lg">
  <form action="/adm/sj/LIVRO/save-capitulo.php" method="post" id="formSections" class="form-horizontal">
    <?=$form->input('hidden', 'id_livro', $ln['id']);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Seção:</label>
      <div class="col-sm-10">
        <div class="input-group">
          <?php
            if(!empty($ln['id'])):
              $res = mysql_query("SELECT id, numero FROM capitulos WHERE id_livro = '".$ln['id']."' ORDER BY ordem ASC");
              $rows = getDataFormSelect($res, array('id', 'numero'));
            else:
              $rows = array();
            endif;
            echo $form->select('id_capitulo', $ln['id'], $rows, array('id'=>'section1', 'data-ac'=>'1', 'data-idLivro'=>$ln['id'], 'class'=>'form-control', 'data-min'=>1), '-- Seção --');
          ?>
          <span class="input-group-addon">
            <span class="label label-success">
              <span class="glyphicon glyphicon-plus" id="addSection"></span>
            </span>

            <span class="label label-danger" style="display: none;  margin-left: 10px;">
              <span class="glyphicon glyphicon-remove" id="removeSection"></span>
            </span>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nome da Seção:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'numero', null, array('class'=>'required form-control', 'disabled'=>'disabled'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Descrição:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'descricao', null, array('class'=>'form-control', 'disabled'=>'disabled'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Ordem da Seção:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'ordem', null, array('class'=>'required form-control bfh-number', 'disabled'=>'disabled'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Seção será Paginada?</label>
      <div class="col-sm-10">
        <?=$form->select('paginado', null, array('SIM'=>'Sim', 'NAO'=>'Não'), array('id'=>'paginado', 'class'=>'required form-control', 'disabled'=>'disabled'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <?=$form->input('submit', 'submit', 'Salvar', array('id'=>'sub-capitulo', 'class'=>'required descricao btn btn-info', 'disabled'=>'disabled'));?>
      </div>
    </div>
  </form>
</div>