<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <input type="hidden" name="grupo" value="<?=$id_grupo;?>" />
    <div class="form-group">
      <label class="col-sm-2 control-label">Nome Interno</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'nome_principal', $ln['nome_principal'], array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nome</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'titulo', $ln['nome'], array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Descrição</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'descricao', $ln['descricao'], array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-10">
        <h3>Quais dos Grupos abaixo o Grupo <?=$ln['nome'];?> tera permissão de leitura?</h3>
        <hr>
        <div class="row group">
          <? 
            if(!empty($id_grupo))
              $sql = "SELECT * FROM grupos WHERE id > 2 AND id <> ${id_grupo} ORDER BY nome";
            else
              $sql = "SELECT * FROM grupos WHERE id > 2 ORDER BY nome";
            $resGrupo = mysql_query($sql) or die(mysql_error());
          ?>
          <? require 'GRUPO/select-article.php'; ?>
          <? require 'GRUPO/select-comunication.php'; ?>
          <? require 'GRUPO/select-event.php'; ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <hr>
        <input type="submit" value="Salvar" class="btn btn-success" />
      </div>
    </div>
  </form>
</div>

<script src="/adm/sj/js/form_script/group-add-select.js"></script>