<?php 
  require('../../../config.inc.php');
  Conectar();

  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_comunicados".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Comunicados &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <th bgcolor="#a2a2a2" >#</th>
    <th bgcolor="#a2a2a2" >Titulo</th>
    <th bgcolor="#a2a2a2" >Descrição</th>
    <th bgcolor="#a2a2a2" >Data Comunicado</th>
    <th bgcolor="#a2a2a2" >Comunicado</th>
    <th bgcolor="#a2a2a2" >Autor</th>
    <th bgcolor="#a2a2a2" >Grupo</th>
    <th bgcolor="#a2a2a2" >Data Cadastro</th>
  </tr>
  <? $sql = mysql_query("SELECT 
                      gp.nome as grupo,
                      cm.*, 
                      DATE_FORMAT(cm.data_2, '%d/%m/%Y - %H:%i') as data_2,
                      us.nome as autor
                    FROM 
                      grupos gp
                      INNER JOIN comunicados cm ON gp.id = cm.grupos_id
                      INNER JOIN usuarios us    ON us.id = cm.id_usuario
                    ORDER BY cm.data_2 DESC"); ?>
  <? while ($row = mysql_fetch_assoc($sql)): ?>
  <? ++$i;?>
    <tr>
      <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= $i?></th>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["titulo"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["descricao"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["data_2"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row['texto']); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["autor"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["grupo"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["cadastro"]); ?></td>
    </tr>
  <? endwhile; ?>
</table> 
