<div class="well well-lg">
  <form action="/adm/sj/LIVRO/save-livro.php" method="post" id="formBook" class="form-horizontal" enctype="multipart/form-data">
    <?=$form->input('hidden', 'id_livro', $ln['id']);?>
    <?=$form->input('hidden', 'fotoat', $ln['capa']);?>
    <?=$form->input('hidden', 'diretorio', $ln['diretorio']);?>
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
      <label class="col-sm-2 control-label">Categoria:</label>
      <div class="col-sm-10">
        <?php
          $res = mysql_query("SELECT * FROM categorias ORDER BY descricao ASC");
          $rows = getDataFormSelect($res, array('id', 'descricao'));
          echo $form->select('categoria', $ln['id_categoria'], $rows, array('class'=>'required form-control'),  '- Selecione a categoria -' );
        ?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Título:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'titulo', $ln['titulo'], array('class'=>'required form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Autor:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'autor', $ln['autor'], array('class'=>'form-control'));?>
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

      <label class="col-sm-2 control-label">Revisão:</label>

      <div class="col-sm-10">

        <?=$form->input('text', 'revisao', $ln['revisao'], array('class'=>'form-control'));?>

      </div>

    </div>

    <div class="form-group">

      <label class="col-sm-2 control-label">ISBN:</label>

      <div class="col-sm-10">

        <?=$form->input('text', 'isbn', $ln['isbn'], array('class'=>'form-control'));?>

      </div>

    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Descrição:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'descricao', $ln['descricao'], array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Url (Comprar Livro):</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'url_loja', ($ln['url_loja'] != 'http://www') ? $ln['url_loja'] : 'http://www', array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Permissão:</label>
      <div class="col-sm-10">
        <select name="permissao" class="form-control">
          <option <?= ($ln['permissao'] == '') ? 'selected="selected"' : ''; ?> value="">- Trecho -</option>
          <option <?= ($ln['permissao'] == 'P') ? 'selected="selected"' : ''; ?> value="P">- Parcial -</option>
          <option <?= ($ln['permissao'] == 'T') ? 'selected="selected"' : ''; ?> value="T">- Total -</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Foto:</label>
      <div class="col-sm-10">
        <?=$form->input('file', 'foto', array('class'=>'form-control'));?>
      </div>
    </div>
    <? if(!empty($ln['foto'])): ?>
      <div class="form-group" id="content-foto">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
          <img src="<?=getPhoto('/'.base64_encode($ln['foto']).'.'.substr($ln['foto'], -4), $ln['capa']);?>" class="img-rounded" id="foto" height="40px">
          <div class="checkbox">
            <label>
              <input name="excluir-foto" value="S" type="checkbox"> Excluir Imagem?
            </label>
          </div>
        </div>
      </div>
    <? endif; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <input type="submit" id="sub-livro" value="Salvar" class="btn btn-info" />
      </div>
    </div>
  </form>
</div>
