<?php
  require('../../../config.inc.php');
  Conectar();
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
    <td colspan="100"><h1>Relatório de Assunto / Tópico / Sub-Tópico &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>  
    <th bgcolor="#a2a2a2" >#</th>
    <th bgcolor="#a2a2a2" >Grupo</th>
    <th bgcolor="#a2a2a2" >Assunto / Tópico / Sub-Tópico</th>
    <th bgcolor="#a2a2a2" >Cadastrado</th>
    <th bgcolor="#a2a2a2" >AT</th>
    <th bgcolor="#a2a2a2" >CP</th>
  </tr>
  <?php
    function getTable($pai = 0, $nivel = '', $nivelCor = 0, $count=0)
    {
      $nivel = '&raquo; ' . $nivel;
      $cor = array('', '#CACACA','#DADADA','#EAEAEA', '#FAFAFA', '#FFFFFF');

      $nivelCor++;

      $query = mysql_query("SELECT 
                            g.nome as grupo,
                            t.id,
                            t.nome,
                            t.ativo,
                            t.compartilhado,
                            DATE_FORMAT(t.cadastro, '%d/%m/%Y') AS cadastro
                          FROM 
                            grupos g INNER JOIN topicos t ON t.id_grupo = g.id
                          WHERE 
                            t.id_topico = ${pai}
                          ORDER BY 
                            g.nome ASC, t.nome ASC") or die(mysql_error());
      while($ln = mysql_fetch_assoc($query)):
  ?>
        <tr>
          <td bgcolor="<?=$cor[$nivelCor];?>"><?= $count;?></td>
          <td bgcolor="<?=$cor[$nivelCor];?>"><?= utf8_decode($ln['grupo']);?></td>
          <?php
            if($ln['id_topico'] == 0)
              echo "<td bgcolor='".$cor[$nivelCor]."'><b>${nivel} ".utf8_decode($ln['nome'])."</b></td>";
            else
              echo "<td bgcolor='".$cor[$nivelCor]."'>${nivel} ".utf8_decode($ln['nome'])."</td>";
          ?>
          <td bgcolor="<?=$cor[$nivelCor];?>"><?=utf8_decode($ln['cadastro']); ?></td>
          <td bgcolor="<?=$cor[$nivelCor];?>"><?=status($ln['compartilhado']); ?></td>
          <td bgcolor="<?=$cor[$nivelCor];?>"><?=status($ln['ativo']); ?></td>
        </tr>
  <?php 
        echo getTable($ln['id'], $nivel, $nivelCor, $count);
        $nivelCor=0;
        $nivel='';
      endwhile;
    }
    echo getTable();
  ?>
</table>