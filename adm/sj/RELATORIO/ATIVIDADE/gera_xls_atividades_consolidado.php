<?php 
  require('../../includes/functions/functions.php');
  require('../../../config.inc.php');
  Conectar();

  header("Content-type: application/vnd.ms-excel");
  header("Content-type: application/force-download");
  header("Content-Disposition: attachment; filename=relatorio_atividades_consolidado".date("Y-m-d-H-i-s").".xls");
  header("Pragma: no-cache");
     $query = mysql_query('SELECT id FROM usuarios');
     while ($ln = mysql_fetch_assoc($query)):
       $sql = mysql_query("SELECT u.nome as usuario, 
                                  gr.id as grupo_id,
                                  gr.nome as grupo,
                                  a.id as artigo_id, 
                                  a.titulo as artigo, 
                                  g.id as galeria_foto_id, 
                                  g.titulo as galeria_foto, 
                                  v.id as galeria_video_id, 
                                  v.titulo as galeria_video, 
                                  l.palavra,
                                  DAY(l.criado_em) as dia,
                                  MONTH(l.criado_em) as mes,
                                  YEAR(l.criado_em) as ano,
                                  DATE_FORMAT(l.criado_em, '%H:%i') as hora
                          FROM 
                          `log_atividades` as l 
                          INNER JOIN usuarios as u ON l.usuario_id = u.id
                          LEFT JOIN artigos as a ON l.artigo_id = a.id 
                          LEFT JOIN galerias as g ON l.galeria_foto_id = g.id
                          LEFT JOIN galerias_video as v ON l.galeria_video_id = v.id
                          LEFT JOIN topicos as tp ON (a.id_topico = tp.id OR g.id_topico = tp.id OR v.id_topico = tp.id)
                          LEFT JOIN grupos as gr ON tp.id_grupo = gr.id
                          WHERE l.usuario_id = ".$ln['id']);

      while ($row = mysql_fetch_assoc($sql)):
        ++$i;
        $itemName = ' - ';
        $itemId = ' - ';
        $tipo = 'Busca';
        if($row['artigo'] || $row['galeria_foto'] || $row['galeria_video']):
          if(!empty($row['artigo'])):
            $itemName = $row['artigo'];
            $itemId = $row['artigo_id'];
            $tipo = 'Artigo';
          elseif(!empty($row['galeria_foto'])):
            $itemName = $row['galeria_foto'];
            $itemId = $row['galeria_foto_id'];
            $tipo = 'Foto';
          elseif(!empty($row['galeria_video'])):
            $itemName = $row['galeria_video'];
            $itemId = $row['galeria_video_id'];
            $tipo = 'Vídeo';
          endif;
        endif;
    ?>
    <? if($i == 1): ?>
      <table width="100%" border="1" cellpadding="5" cellspacing="5">
        <tr>
          <td colspan="9">
            <h1><?=utf8_decode('Relatório de Atividades &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;');?> <?=date("d/m/Y H:i"); ?></h1>
            <p><?=utf8_decode('Usuário:');?> <?=utf8_decode($row['usuario']); ?></p>
            <p><?=utf8_decode('Mês:');?> <?= utf8_decode($row['mes']); ?></p>
            <p>Ano: <?= $row['ano']; ?></p>
          </td>
        </tr>
        <tr>
          <th>Dia</th>
          <th>Hora</th>
          <th>Tipo</th>
          <th>Atividade</th>
          <th>Nr.Grupo</th>
          <th>Nome Grupo</th>
          <th>Nr. Item</th>
          <th>Nome Item</th>
          <th>Busca</th>
        </tr>
      <? endif; ?>
        <tr>
          <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= $row['dia']; ?></th>
          <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= $row['hora']; ?></th>
          <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= $tipo; ?></th>
          <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= $i?></th>
          <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["grupo_id"]); ?></td>
          <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["grupo"]); ?></td>
          <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($itemId); ?></td>
          <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($itemName); ?></td>
          <td bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($row["palavra"]); ?></td>
        </tr>
      <? endwhile; ?>
    <? if(mysql_num_rows($sql) > 1): ?>
      </table> 
    <? endif; ?>
  <? $i=0; endwhile; ?>