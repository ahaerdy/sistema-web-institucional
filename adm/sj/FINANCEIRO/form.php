<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <input type="hidden" name="grupo" value="<?=$id_grupo;?>" />
    <div class="form-group">
      <label class="col-sm-2 control-label">Usuário</label>
      <div class="col-sm-10">
        <? $params = array('class'=>"form-control search-topic-ajax", 'data-fill'=>"topico");?>
        <? require('includes/html/select/select-user.php'); ?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Descrição</label>
      <div class="col-sm-10">
        <?=$form->textarea('descricao', $ln['descricao'], array('class'=>'required form-control', 'rows'=>'2', 'cols'=>'71'));?>
      </div>
    </div>

    <!-- <div class="form-group">
      <label class="col-sm-2 control-label">Valor</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'valor', $ln['valor'], array('class'=>'form-control'));?>
      </div>
    </div> -->
    
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <hr>
        <input type="submit" value="Salvar" class="btn btn-success" />
      </div>
    </div>
  </form>
</div>