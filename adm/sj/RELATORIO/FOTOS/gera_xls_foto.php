<?php 
  require('../../../config.inc.php');
  Conectar();

  header('Content-Type: text/html; charset=ISO8859-1');
  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_galeiria_fotos_".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");

  function status($status)
  {
    if($status == 'S')
      echo 'Sim';
    else
      echo 'Não';
  }
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Galeria de Fotos &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <th bgcolor="#a2a2a2" >#</th>
    <th bgcolor="#a2a2a2" >Grupo (Principal)</th>
    <th bgcolor="#a2a2a2" >Assunto / Tópico / Sub-Tópico</th>
    <th bgcolor="#a2a2a2" >Título</th>
    <th bgcolor="#a2a2a2" >Descrição</th>
    <th bgcolor="#a2a2a2" >Fotos Incoporado</th>

    <th bgcolor="#a2a2a2" >Cadastro</th>
    <th bgcolor="#a2a2a2" >Diretório</th>
    <th bgcolor="#a2a2a2" >Compartilhado</th>
    <th bgcolor="#a2a2a2" >Visivel na Home</th>
    <th bgcolor="#a2a2a2" >Ativo</th>
  </tr>
  <? $query = mysql_query("SELECT 
                            gp.nome as grupo,
                            tp.nome as topico,
                            concat('/',gp.diretorio,'/',tp.diretorio,'/',gl.diretorio) as diretorio,
                            gl.id,
                            gl.titulo,
                            gl.descricao,
                            DATE_FORMAT(gl.cadastro, '%d/%m/%Y - %H:%i') as cadastro,
                            gl.compartilhado,
                            gl.home,
                            gl.ativo
                          FROM
                            grupos gp
                            INNER JOIN topicos tp ON gp.id = tp.id_grupo
                            INNER JOIN galerias gl ON tp.id = gl.id_topico") or die(mysql_error());?>
  <? while ($rs = mysql_fetch_assoc($query)): ?>
    <?$i++?>
    <tr>
      <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= $i?></th>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= ($rs["grupo"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= ($rs["topico"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= ($rs["titulo"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= ($rs["descricao"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" >
        <? $query1 = mysql_query("SELECT 
                                  *,
                                  DATE_FORMAT(cadastro, '%d/%m/%Y - %H:%i') as cadastro
                                FROM
                                  fotos 
                                WHERE
                                  galerias_id = ".$rs["id"]) or die(mysql_error());
          while ($rs1 = mysql_fetch_assoc($query1)):
            echo 'Arquivo: ' . ($rs1['foto'])."<br>";
            echo 'Comentário: ' . ($rs1['comentario'])."<br>";
            echo 'Cadastro: ' . ($rs1['cadastro'])."<br>";
            echo 'Foto: ' . ($rs1['foto'])."<br>";
            echo 'Ordem: ' . ($rs1['ordem'])."<br>";
            echo 'Compartilhado: ' . ($rs1['compartilhado'])."<br>";
          endwhile;?>
      </td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= ($rs["cadastro"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= ($rs["diretorio"]); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= (status($rs["compartilhado"])); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= (status($rs["home"])); ?></td>
      <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= (status($rs["ativo"])); ?></td>
    </tr>
  <? endwhile; ?>
</table>
