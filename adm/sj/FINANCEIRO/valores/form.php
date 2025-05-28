<div class="well well-lg">
  <form action="#" method="post" id="form" class="form-horizontal" role="form">
    <?=$form->input('hidden', 'id', $ln['id']);?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Categoria:</label>
      <div class="col-sm-10">
        <? $query = mysql_query('SELECT * FROM categorias_pagamentos ORDER BY nome ASC'); ?>
        <select id="category_id" name="category_id" class="form-control value-donation" required>
          <option value="">Selecione</option>
          <?php
            while ($row = mysql_fetch_assoc($query)) {
              $select = ($ln['categoria_pagamento_id']==$row['id'])?'selected="selected"':'';
              echo '<option value="'.$row['id'].'" '.$select.'>'.$row['nome'].'</option>';
            }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Valor:</label>
      <div class="col-sm-10">
        <?=$form->input('text', 'valor', number_format($ln['valor'], 2, ',', '.'), array('class'=>'required form-control'));?>
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