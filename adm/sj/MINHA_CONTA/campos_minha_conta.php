<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } 
  $form = new formHelper();
?>
  <div class="panel panel-default">
    <div class="panel-heading">Permissões de Exibição</div>
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Campo</th>
            <th width="100">Editavel</th>
            <th width="100">Exibir</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $query = mysql_query("SELECT * FROM campos") or die(mysql_error());
          while($ln = mysql_fetch_array($query)):
        ?>
            <tr>
              <td><?=$ln['label'];?></td>
              <td>
                <?php
                  switch($ln['ativo']):
                      case 'S':
                          echo '<img src="img/aprovado.png"  alt="" name="ativar" data-url="MINHA_CONTA/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="N"/>';
                          break;
                      case ($ln['ativo'] == 'N') || ($ln['ativo'] = ''):
                          echo '<img src="img/bloqueado.png" alt="" name="ativar" data-url="MINHA_CONTA/acao.php" data-tipo="at" data-id="'.$ln['id'].'" data-ac="S"/>';
                          break;
                  endswitch;
                ?>
              </td>
              <td>
                <?php
                  switch($ln['visualizar']):
                      case 'S':
                          echo '<img src="img/aprovado.png"  alt="" name="ativar" data-url="MINHA_CONTA/acao.php" data-tipo="vs" data-id="'.$ln['id'].'" data-ac="N"/>';
                          break;
                      case ($ln['visualizar'] == 'N') || ($ln['visualizar'] = ''):
                          echo '<img src="img/bloqueado.png" alt="" name="ativar" data-url="MINHA_CONTA/acao.php" data-tipo="vs" data-id="'.$ln['id'].'" data-ac="S"/>';
                          break;
                  endswitch;
                ?>
              </td>
            </tr>
        <?php 
          endwhile; 
        ?>
      </tbody>
    </table>
  </div>
</div>