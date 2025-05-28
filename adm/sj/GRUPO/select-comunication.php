<div class="col-lg-4">
  <div class="panel panel-default" id="dv-group2">
    <div class="panel-heading">COMUNICADOS</div>
    <div class="panel-body">
      <div class="input-group">
        <?
          mysql_data_seek($resGrupo,0);
          $rows = getDataFormSelect($resGrupo);
          echo $form->select('grupos_cadastrados_com[]', '', $rows, array('class'=>'form-control'), '-');
        ?>
        <span class="input-group-addon">
          <a href="#" class="add" data-item="2">
            <span class="label label-success">
              <span class="glyphicon glyphicon-plus"></span>
            </span>
          </a>
        </span>
      </div>

      <?php
        if(!empty($id_grupo)):
          $res = mysql_query("SELECT * FROM grupos_dependente WHERE grupos_id = ${id_grupo} AND tipo = 'comunicado'");
          while ($ln = mysql_fetch_assoc($res)):
      ?>
            <div class="group">
              <div class="input-group">
                <select name='grupos_cadastrados_com[]' class="form-control" id="group2">
                  <option value=""></option>
                  <?php
                    $res1 = mysql_query("SELECT * FROM grupos WHERE id > 2 AND id <> ${id_grupo} ORDER BY nome");
                    while ($lns = mysql_fetch_assoc($res1)):
                      if($ln["dependentes_id"] == $lns["id"])
                        echo '<option value="'.$lns["id"].'" selected="selected">'.$lns["nome"].'</option>';
                      else
                        echo '<option value="'.$lns["id"].'">'.$lns["nome"].'</option>';
                    endwhile;
                  ?>
                </select>
                <span class="input-group-addon">
                  <a href="#" class="remove">
                    <span class="label label-danger">
                      <span class="glyphicon glyphicon-remove"></span>
                    </span>
                  </a>
                </span>
              </div>
            </div>
      <?php
          endwhile;
        endif;
      ?>
    </div>
  </div>
</div>
