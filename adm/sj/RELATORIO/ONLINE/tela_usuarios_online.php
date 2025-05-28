<?php
  $limitar = (int)getParam('limitar');
  if(!empty($limitar)):
    $res = mysql_query("SELECT (max(id)-200) as id FROM online");
    $n = mysql_fetch_assoc($res);
    if($n['id'] > 0):
      if(mysql_query("DELETE FROM online WHERE id <= ".$n['id']))
        setFlashMessage('Limitação realizada com sucesso!', 'success');
      else
        setFlashMessage('Não foi possivel limitar o ip, entre em contato com administrador.', 'danger');
    else:
      setFlashMessage('A quantide de registro(s) existente não é maior que 200 registros.', 'warning');
    endif;
    echo redirect2('index.php?op=usuarios_online');
    exit;
  endif;
?>
<div class="panel panel-default">

  <div class="panel-heading"> Usuários Online </div>

  <div class="panel-body">

    <a href="RELATORIO/ONLINE/gera_xls_online.php" target="_blank" class="btn btn-success pull-right">

      <img src="/adm/img/excel.png" class="pull-left" width="20px" style="margin-right: 15px;"/>

      Clique no ícone para gerar o relatório completo em Excel.

    </a>

    <a href="/adm/sj/index.php?op=usuarios_online&limitar=1" onclick="return confirm('Confirma a exclusão?')" class="btn btn-danger">
      Limitar a 200 útimos registros
    </a>

    <div class="clearfix"></div>

  </div>

  <table class="table table-striped">

    <thead>

      <tr>

        <th>Usuário</th>

        <th>Cidade / Estado</th>

        <th>Data / Hora</th>

        <th>IP</th>

      </tr>

    </thead>

    <? $sql = mysql_query("SELECT 

                            o.*, DATE_FORMAT(o.timestamp, '%d/%m/%Y  %H:%i:%s') AS timestamp,

                            u.nome, u.cidade, u.estado

                          FROM 

                            online o INNER JOIN usuarios u ON u.id = o.usuarios_id ORDER BY o.timestamp DESC") or die(mysql_error());?>

      <? while($row = mysql_fetch_assoc($sql)): ?>

      <tr>

        <td><?=$row['nome'];?></td>

        <td><?=$row['cidade'];?> - <?=$row['estado'];?></td>

        <td><?=$row['timestamp'];?></td>

        <td><?=$row['ip'];?></td>

      </tr>

    <? endwhile; ?>

  </table>

</div>