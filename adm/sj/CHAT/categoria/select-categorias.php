<?php
  $form = new formHelper();
  $res = mysql_query("SELECT id, categoria FROM chats_categorias ORDER BY categoria ASC");
?>

<div class="panel panel-default" id="dv-group1">
  <div class="panel-heading">Categoria(s) que o usuário recebe mensagem.</div>
  <div class="panel-body">
    <div class="input-group">
      <?php
        $rows = getDataFormSelect($res, array('id','categoria'));
        echo $form->select('categoria[]', '', $rows, array('class'=>'form-control'), '-');
      ?>
      <span class="input-group-addon">
        <a href="#" class="add" data-item="1">
          <span class="label label-success">
            <span class="glyphicon glyphicon-plus"></span>
          </span>
        </a>
      </span>
    </div>

    <?php
      if(!empty($usuarioId)):
        $res2 = mysql_query("SELECT c.* 
                  FROM chats_categorias c 
                  INNER JOIN chats_categorias_x_usuarios x  ON x.chat_categoria_id = c.id
                  WHERE x.usuario_id = ${usuarioId}");
        while ($ln = mysql_fetch_assoc($res2)):
    ?>
          <div>
            <div class="input-group">
              <select name='categoria[]' class="form-control" id="group1">
                <option value="">- </option>
                <?php
                  mysql_data_seek($res, 0);
                  while ($lns = mysql_fetch_assoc($res)):
                    if($ln["id"] == $lns["id"])
                      echo '<option value="'.$lns["id"].'" selected="selected">'.$lns["categoria"].'</option>';
                    else
                      echo '<option value="'.$lns["id"].'">'.$lns["categoria"].'</option>';
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
