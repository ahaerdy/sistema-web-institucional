<?php 
  require('../../../config.inc.php');
  Conectar();

  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_grupos_e_dependentes".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Grupos e Dependentes &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <th bgcolor="#a2a2a2" >#</td>
    <th bgcolor="#a2a2a2" >Grupo</td>
    <th bgcolor="#a2a2a2" >Descrição</td>
    <th bgcolor="#a2a2a2" >Diretório</td>
    <th bgcolor="#a2a2a2" >Artigos, Fotos, Vídeos, Livros</td>
    <th bgcolor="#a2a2a2" >Comunicados</td>
    <th bgcolor="#a2a2a2" >Eventos</td>
    <th bgcolor="#a2a2a2" >Data Cadastro</td>
  </tr>
  <? $sql1 = mysql_query("SELECT *, DATE_FORMAT('cadastro', '%d') as cadastro FROM grupos ORDER BY nome"); ?>
  <? while($rs = mysql_fetch_assoc($sql1)): ++$z;?>
      <tr>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($z);?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["nome"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["descricao"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["diretorio"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" >
        <? $sql2 = mysql_query("SELECT g.nome, gd.tipo FROM grupos g INNER JOIN grupos_dependente gd ON gd.dependentes_id = g.id WHERE gd.tipo = 'artigo' AND gd.grupos_id = '".$rs["id"]."' ORDER BY g.nome, gd.tipo"); 
          while($rs2 = mysql_fetch_assoc($sql2)):
            echo utf8_decode(++$i.") ".$rs2["nome"]."<br>");
          endwhile;
        ?>
        </td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" >
        <? $i=0; $sql2 = mysql_query("SELECT g.nome, gd.tipo FROM grupos g INNER JOIN grupos_dependente gd ON gd.dependentes_id = g.id WHERE gd.tipo = 'comunicado' AND gd.grupos_id = '".$rs["id"]."' ORDER BY g.nome, gd.tipo");
          while($rs2 = mysql_fetch_assoc($sql2)):
            echo utf8_decode(++$i.") ".$rs2["nome"]."<br>");
          endwhile;
        ?>
        </td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" >
        <? $i=0; $sql2 = mysql_query("SELECT g.nome, gd.tipo FROM grupos g INNER JOIN grupos_dependente gd ON gd.dependentes_id = g.id WHERE gd.tipo = 'evento' AND gd.grupos_id = '".$rs["id"]."' ORDER BY g.nome, gd.tipo"); 
          while($rs2 = mysql_fetch_assoc($sql2)):
            echo utf8_decode(++$i.") ".$rs2["nome"]."<br>");
          endwhile;
        ?>
        </td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($depend );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["cadastro"] );?></td>
      </tr>
  <? endwhile; ?>
</table> 
