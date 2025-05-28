<?php 
  require('../../../config.inc.php');
  Conectar();

  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_artigos".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Artigos &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <th bgcolor="#a2a2a2" >#</th>
    <th bgcolor="#a2a2a2" >Grupo</th>
    <th bgcolor="#a2a2a2" >Tópico</th>
    <th bgcolor="#a2a2a2" >Título</th>
    <th bgcolor="#a2a2a2" >Autor</th>
    <th bgcolor="#a2a2a2" >Data</th>
  </tr>
  <? $sql = mysql_query("SELECT  
                            gp.nome as grupo,
                            tp.nome as topico, 
                            at.*, 
                            DATE_FORMAT(at.cadastro, '%d/%m/%Y - %H:%i') as cadastro,
                            us.nome as autor
                          FROM 
                            grupos  gp 
                            INNER JOIN topicos tp  ON gp.id = tp.id_grupo
                            INNER JOIN artigos at  ON tp.id = at.id_topico
                            INNER JOIN usuarios us ON us.id  =at.usuarios_id
                          ORDER BY gp.nome ASC, tp.nome ASC, at.titulo ASC, at.cadastro DESC");?>
  <? while ($rs = mysql_fetch_array($sql)): ?>
  <? ++$i;?>
    <tr>
      <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=$i;?></th>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($rs["grupo"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($rs["topico"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($rs["titulo"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($rs["autor"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=utf8_decode($rs["cadastro"]); ?></td>
    </tr>
  <? endwhile; ?>
</table> 
