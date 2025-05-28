<?
require('../../../config.inc.php');
Conectar();

header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=relatorio_log_acessos_".date("YmdHi").".xls");
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Log Acesso &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <tr>
      <th bgcolor="#a2a2a2" >#</th>
      <th bgcolor="#a2a2a2" >Usuário</th>
      <th bgcolor="#a2a2a2" >Cidade</th>
      <th bgcolor="#a2a2a2" >Estado</th>
      <th bgcolor="#a2a2a2" >Data / Hora</th>
      <th bgcolor="#a2a2a2" >IP</th>
    </tr>
    <? $sql = mysql_query("SELECT 
                          o.*, DATE_FORMAT(o.timestamp, '%d/%m/%Y  %H:%i:%s') AS timestamp,
                          u.nome, u.cidade, u.estado
                        FROM 
                          online o INNER JOIN usuarios u ON u.id = o.usuarios_id") or die(mysql_error());?>
    <? while($row = mysql_fetch_assoc($sql)): ++$i;?>
    <tr>
      <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=$i;?></th>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($row['nome']);?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($row['cidade']);?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($row['estado']);?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($row['timestamp']);?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($row['ip']);?></td>
    </tr>
  <? endwhile; ?>
</table>
