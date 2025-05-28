<?php 
  require('../../../config.inc.php');
  Conectar();

  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_eventos".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Eventos &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <th bgcolor="#a2a2a2" >#</th>
    <th>Titulo</th>
    <th>Descrição</th>
    <th>Data</th>
    <th>Local</th>
    <th>Conteúdo</th>
    <th>Autor</th>
    <th>Grupo</th>
    <th>Data Cadastro</th>
  </tr>
  <?
    $sql = mysql_query("SELECT  
                      gp.nome as grupo,
                      us.nome as autor,
                      ev.*
                    FROM 
                      grupos gp
                    INNER JOIN eventos ev   ON gp.id = ev.id_grupo
                    INNER JOIN usuarios us  ON us.id = ev.id_usuario
                    ORDER BY ev.dia DESC") or die(mysql_error());
  ?>
  <? while ($row = mysql_fetch_assoc($sql)): ?>
  <? ++$i;?>
    <tr>
      <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= $i?></th>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["titulo"]) ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["descricao"]) ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["dia"]) ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["local_2"]) ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= strip_tags(utf8_decode($row['texto']), '<(.*?)>'); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["autor"]) ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["grupo"]) ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["cadastro"]) ?></td>
    </tr>
  <? endwhile; ?>
</table> 
