<div class="well well-lg">
  <form action="#" method="post" class="form-horizontal">
    <input type="hidden" name="id" value="<?=$ln['id'];?>" />
    <div class="form-group">
      <label class="col-sm-2 control-label">Nome</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'name', $ln['name'], array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Sala ID</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'room_id', $ln['room_id'], array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Senha</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'room_password', $ln['room_password'], array('class'=>'form-control'));?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Data Inicial</label>
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-6">
            <div class="input-group bfh-datepicker" data-format="d/m/y" data-date="<?=($ln["data_inicio"])?$ln["data_inicio"]:'today';?>" data-name="data_inicio">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'data_inicio', '', array('class'=>'required form-control'));?>
              <span class="input-group-addon"> ás </span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-group bfh-timepicker" <?=($ln["hora_inicio"])?'data-time="'.$ln["hora_inicio"].'"':'';?> data-name="hora_inicio">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'hora_inicio', '', array('class'=>'required form-control'));?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Data Final</label>
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-6">
            <div class="input-group bfh-datepicker" data-format="d/m/y" data-date="<?=($ln["data_final"])?$ln["data_final"]:'today';?>" data-name="data_final">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'data_final', '', array('class'=>'required form-control'));?>
              <span class="input-group-addon"> ás </span>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="input-group bfh-timepicker" <?=($ln["hora_final"])?'data-time="'.$ln["hora_final"].'"':'';?> data-name="hora_final">
              <span class="input-group-addon"></span>
              <?=$form->input('text', 'hora_final', '', array('class'=>'required form-control'));?>
            </div>
          </div>
        </div>
      </div>
    </div>

      
    <div class="form-group">
      <label class="col-sm-2 control-label">Filtro Cidade</label>
      <div class="col-sm-10">
          <select name="filtro_cidade" class="form-control" id="filtro_cidade">
            <?
              echo '<option value="VAZIO">- Selecione uma cidade -</option>';
              
              $res_cidade=mysql_query ('SELECT DISTINCT cidade FROM usuarios WHERE cidade not LIKE "" AND cidade not LIKE "NULL" ORDER by cidade ASC');
              while ($ln_cidade  = mysql_fetch_assoc($res_cidade)) {
                  if ($ln_cidade["cidade"]==$ln["filtro_cidade"]) {
                    echo '<option value="'.$ln_cidade["cidade"].'" selected>'.$ln_cidade["cidade"].'</option>';
                  } else { echo '<option value="'.$ln_cidade["cidade"].'">'.$ln_cidade["cidade"].'</option>'; }
                }
            ?> 
          </select>
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