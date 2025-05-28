<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <?=$form->input('hidden', 'assunto', $ln["id"]);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Grupo</label>
      <div class="col-sm-10">
        <?php
          $res = mysql_query("SELECT id, CONCAT ('(cod. ', id, ') ', nome) AS nome FROM grupos WHERE id > 2 ORDER BY nome ASC");
          $rows = getDataFormSelect($res);
          echo $form->select('grupo', (getParam('grupo'))?getParam('grupo'):$ln['id_grupo'], $rows, array('class'=>'required form-control'), '- Selecione o grupo -');
        ?>
      </div>
    </div>
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
      <div class="col-sm-10">
        <hr>
        <?=$form->input('submit', 'submit', 'Salvar', array('class'=>'btn btn-info'));?>
      </div>
    </div>
  </form>
</div>