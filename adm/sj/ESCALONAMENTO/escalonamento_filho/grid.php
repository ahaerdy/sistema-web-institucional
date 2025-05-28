<tr>
  <td><?=$row['id']; ?></td>
  <td><?=($row['grupo'])?'(Cód.'.$row['grupo_id'].') ' . $row['grupo']:''; ?></td>
  <td><?=$row['titulo'];?></td>
  <td><?=$row['ordem'];?></td>
  <td>
    <div class="btn-group">
      <a href="?op=<?=($pai)?'alterar_escalonamento_pai':'alterar_escalonamento_filho';?>&op1=<?=$row['id'];?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
      <a href="?op=<?=($pai)?'delete_escalonamento_pai':'delete_escalonamento_filho';?>&op1=<?=$row['id'];?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
  </td>
  <td>
    <?php
      switch($row['ativo']):
        case 'S':
          echo '<img src="img/aprovado.png"  alt="" style="margin-bottom: -3px;" name="ativar" data-url="TOPICO/acao.php" data-tipo="at" data-id="'.$row['id'].'" data-ac="N" data-tp="1"/>';
          break;
        case 'N':
          echo '<img src="img/bloqueado.png" alt="" style="margin-bottom: -3px;" name="ativar" data-url="TOPICO/acao.php" data-tipo="at" data-id="'.$row['id'].'" data-ac="S" data-tp="1"/>';
          break;
      endswitch;
    ?>
  </td>
</tr>