<?php 
  require('../../../config.inc.php');
  Conectar();

  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_livros".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");

  function status($status)
  {
    if($status == 'S')
      echo 'Sim';
    else
      echo 'Não';
  }
  function permissao($permissao)
  {
    if($permissao == 'T')
      echo 'Total';
    elseif($permissao == 'P')
      echo 'Parcial';
    elseif($permissao == '')
      echo 'Não definido';
    else
      echo 'Trecho';
  }
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Livros &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <th bgcolor="#a2a2a2" >#</td>
    <th bgcolor="#a2a2a2" >Grupo</td>
    <th bgcolor="#a2a2a2" >Tópico</td>
    <th bgcolor="#a2a2a2" >Titulo</td>
    <th bgcolor="#a2a2a2" >Descrição</td>
    <th bgcolor="#a2a2a2" >Autor</td>
    <th bgcolor="#a2a2a2" >Revisao</td>
    <th bgcolor="#a2a2a2" >ISBN</td>
    <th bgcolor="#a2a2a2" >URL Loja</td>
    <th bgcolor="#a2a2a2" >Compartilhado</td>
    <th bgcolor="#a2a2a2" >Permissão</td>
    <th bgcolor="#a2a2a2" >Ativo</td>
    <th bgcolor="#a2a2a2" >Data Cadastro</td>
  </tr>
  <? $sql1 = mysql_query("SELECT
                            gp.nome as grupo,
                            tp.nome as topico,
                            lv.*, 
                            date_format(lv.cadastrado, '%d/%m/%Y - %h:%i') as cadastro
                          FROM 
                            grupos gp,
                            topicos tp,
                            livros lv
                          WHERE
                            tp.id_grupo = gp.id AND 
                            tp.id = lv.id_topico"); ?>
  <? while($rs = mysql_fetch_assoc($sql1)): ?>
  <? ++$z?>
      <tr>
        <th bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($z);?></th>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["grupo"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["topico"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["titulo"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["descricao"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["autor"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["revisao"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["isbn"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["url_loja"] );?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode(status($rs["compartilhado"] ));?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode(permissao($rs["permissao"] ));?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode(status($rs["ativo"] ));?></td>
        <td bgcolor="<?=($z%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["cadastro"] );?></td>
      </tr>
  <? endwhile; ?>
</table> 
