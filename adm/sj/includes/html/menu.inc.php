<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>

<div class="btn-group-vertical" style="display:block;">
	<a href="index.php" class="btn btn-info" style="text-align:left; padding-left:10px;"><span class="glyphicon glyphicon-home"></span> Início</a>
  
  <?php
    if(getIdUsuario() == 1):
      $res = mysql_query("SELECT * FROM menu ORDER BY ordem ASC");
    elseif(getIdUsuario() == 2):
      $res = mysql_query("SELECT * FROM menu WHERE id = 1");
    elseif(getIdUsuario() == 3):
      $res = mysql_query("SELECT * FROM menu WHERE id IN (23, 18)");
    endif;

    while ($ln = mysql_fetch_assoc($res)):
      $id_menu	     = $ln['id'];	
      $res_descricao	 = $ln['descricao'];
      
      if(getIdUsuario() == 3 && $id_menu == 18):
        $where = 'AND id = 89';
        $res1 = mysql_query("SELECT * FROM sub_menu WHERE id_menu = '$id_menu' AND bloquiado != '0' $where ORDER BY descricao ASC");
      else:
        $res1 = mysql_query("SELECT * FROM sub_menu WHERE id_menu = '$id_menu' AND bloquiado != '0' ORDER BY descricao ASC");
      endif;

      if(mysql_num_rows($res1)):
  ?>
        <div class="btn-group">
          <button id="btnGroupVerticalDrop1" type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown" style="text-align:left; padding-left:10px;">
            <?=$res_descricao;?>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="btnGroupVerticalDrop1">
            <?php while ($rowsubmenu  = mysql_fetch_assoc($res1)): ?>
              <li><a href="<?=$rowsubmenu['link'];?>"><?=$rowsubmenu['descricao'];?></a></li>
            <?php endwhile; ?>
          </ul>
        </div>
  <?php
      endif;
    endwhile;
  ?>	
  <a href="sair_sistema.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Sair</a>
</div>

<br>

<ul class="list-group">
  <li class="list-group-item">PL - Permissão de livro no grupo.</li>
  <li class="list-group-item">EV - Exibir eventos na home.</li>
  <li class="list-group-item">CM - Exibir comunicado na home.</li>
  <li class="list-group-item">CP - Exibir capa do grupo na home.</li>
  <li class="list-group-item">AT - Ativar registro.</li>
</ul>