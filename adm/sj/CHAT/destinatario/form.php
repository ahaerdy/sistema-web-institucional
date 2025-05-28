<div class="well well-lg">
  <form action="#" method="post" id="form" class="form-horizontal" role="form">
    <?=$form->input('hidden', 'id', $ln['id']);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Categoria:</label>
      <div class="col-sm-10">
        <? $query = mysql_query('SELECT * FROM chats_categorias ORDER BY categoria ASC'); ?>
        <select id="category_id" name="category_id" class="form-control value-donation" required>
          <option value="">Selecione</option>
          <?php
            while ($row = mysql_fetch_assoc($query)) {
              $select = ($ln['chat_categoria_id']==$row['id'])?'selected="selected"':'';
              echo '<option value="'.$row['id'].'" '.$select.'>'.$row['categoria'].'</option>';
            }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Destinatário:</label>
      <div class="col-sm-10">        
        <? $query = mysql_query('SELECT id, nome FROM usuarios WHERE id > 2 ORDER BY nome ASC'); ?>
        <select id="usuario_id" name="usuario_id" class="form-control value-donation" required>
          <option value="">Selecione</option>
          <?php
            while ($row = mysql_fetch_assoc($query)) {
              $select = ($ln['usuario_id']==$row['id'])?'selected="selected"':'';
              echo '<option value="'.$row['id'].'" '.$select.'>'.$row['id'].' - '.$row['nome'].'</option>';
            }
          ?>
        </select>      
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-10">
        <?=$form->input('submit', 'submit', 'Salvar', array('class'=>'btn btn-info'));?>
      </div>
    </div>
  </form>
</div>