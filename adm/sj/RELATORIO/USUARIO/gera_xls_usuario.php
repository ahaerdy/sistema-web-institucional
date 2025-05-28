<?php 
  require('../../../config.inc.php');
  Conectar();

   header("Content-type: application/vnd.ms-excel");
   header("Content-type: application/force-download");
   header("Content-Disposition: attachment; filename=relatorio_usuarios_".date("Y-m-d-H-i-s").".xls");
   header("Pragma: no-cache");
?>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="100"><h1>Relatório de Usuários &nbsp; &nbsp; &nbsp; &nbsp; <?=date("d/m/Y H:i"); ?></h1></td>
  </tr>
  <tr>
    <th bgcolor="#a2a2a2" >#</th>
    <th bgcolor="#a2a2a2" >Grupo (Principal)</th>
    <th bgcolor="#a2a2a2" >Grupo (Secundário)</th>
    <th bgcolor="#a2a2a2" >Escalonamento</th>
    <th bgcolor="#a2a2a2" >Escalonamento Filhos</th>
    <th bgcolor="#a2a2a2" >Matricula</th>
    <th bgcolor="#a2a2a2" >Nome</th>
    <th bgcolor="#a2a2a2" >Nome de Ibnato</th>
    <th bgcolor="#a2a2a2" >RG</th>
    <th bgcolor="#a2a2a2" >CPF</th>
    <th bgcolor="#a2a2a2" >Sexo</th>
    <th bgcolor="#a2a2a2" >Data Nascimento</th>
    <th bgcolor="#a2a2a2" >Endereço</td> 
    <th bgcolor="#a2a2a2" >Complemento</th>
    <th bgcolor="#a2a2a2" >Bairro</th>
    <th bgcolor="#a2a2a2" >Cidade</th>
    <th bgcolor="#a2a2a2" >Estado</th>
    <th bgcolor="#a2a2a2" >Pais</th>
    <th bgcolor="#a2a2a2" >CEP</th>
    <th bgcolor="#a2a2a2" >Telefone Residencial</th>
    <th bgcolor="#a2a2a2" >Telefone Comercial</th>
    <th bgcolor="#a2a2a2" >Telefone Celular</th>
    <th bgcolor="#a2a2a2" >E-Mail</th>
    <th bgcolor="#a2a2a2" >Familia</th>
    <th bgcolor="#a2a2a2" >Discipulado</th>
    <th bgcolor="#a2a2a2" >Selamentos</th>
    <th bgcolor="#a2a2a2" >Serviço Abraxico</th>
    <th bgcolor="#a2a2a2" >Pré-Mynian</th>
    <th bgcolor="#a2a2a2" >Mynian</th>
    <th bgcolor="#a2a2a2" >Távola</th>
    <th bgcolor="#a2a2a2" >Voluntário</th>
    <th bgcolor="#a2a2a2" >Estado / Dicipulado</th>
    <th bgcolor="#a2a2a2" >Motivo</th>
    <th bgcolor="#a2a2a2" >Regimento Assinado</th>
    <th bgcolor="#a2a2a2" >Doador de Imagem</th>
    <th bgcolor="#a2a2a2" >Historico</th>
    <th bgcolor="#a2a2a2" >Login</th>
    <th bgcolor="#a2a2a2" >Senha</th>
    <th bgcolor="#a2a2a2" >Bloqueado?</th>		<th bgcolor="#a2a2a2" >Menu</th>
    <th bgcolor="#a2a2a2" >Data Ingresso</th>
  </tr>
  <? $query = mysql_query("SELECT u.*, g.id as grupo_id, g.nome as grupo, 
                                  DATE_FORMAT(u.data_nascimento, '%d/%m/%Y') as data_nascimento,
                                  DATE_FORMAT(u.data_ingresso, '%d/%m/%Y - %H:%i:%s') as data_ingresso
                           FROM usuarios u 
                           LEFT JOIN grupos g ON u.grupos_id = g.id 
                           ORDER BY u.nome"); ?> 
  <? while ($rs = mysql_fetch_assoc($query)): ?>
    <?$i++?>
    <tr>
      <th bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?=$rs['id']?></th>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode('(Cód: '.$rs["grupo_id"].') '.$rs["grupo"]); ?></td>
      
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" >
        <?php 
          $res = mysql_query('SELECT 
                                  g1.id,
                                  g1.nome
                              FROM usuarios u
                              INNER JOIN grupos_usuarios gu ON gu.id_usuario = u.id  AND (gu.escalonamento != 1 OR gu.escalonamento IS NULL)
                              INNER JOIN grupos g1 ON gu.id_grupo = g1.id
                              WHERE u.id = '.$rs['id'].'
                              ORDER BY g1.nome');
          while ($rs1 = mysql_fetch_assoc($res)) {
            echo '(Cód: '.$rs1['id'].') '.$rs1['nome'].'<br>';
          }
        ?>
      </td>

      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>">
        <?php 
          $res = mysql_query('SELECT e2.titulo
                              FROM usuarios AS u
                              INNER JOIN escalonamentos AS e ON u.escalonamento_id = e.id
                              INNER JOIN escalonamentos AS e2 ON e.escalonamento_id = e2.id
                              WHERE u.id = '.$rs['id']);
          while ($rs2 = mysql_fetch_assoc($res)) {
            echo $rs2['titulo'];
          }
        ?>
      </td>

      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>">
        <?php 
          $res = mysql_query('SELECT e2.id, e2.titulo, e2.ordem
                              FROM usuarios AS u
                              INNER JOIN escalonamentos AS e ON u.escalonamento_id = e.id
                              INNER JOIN escalonamentos AS e2 ON e.escalonamento_id = e2.escalonamento_id
                              WHERE u.id = '.$rs['id'].' ORDER BY e2.ordem ASC');
          while ($rs3 = mysql_fetch_assoc($res)) {
            if($rs['escalonamento_id'] == $rs1['id']){
              echo $rs3['ordem'].') '.$rs3['titulo'] . '(*) <br>';
            }else {
              echo $rs3['ordem'].') '.$rs3['titulo'] . '() <br>';
            }
          }
        ?>
      </td>

      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["matricula"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["nome"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["nome_ibnato"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["rg"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["cpf"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["sexo"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["data_nascimento"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["endereco"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["bairro"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["complemento"]);?></td>    
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["cidade"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["estado"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["pais"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["cep"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["telefone_res"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["telefone_com"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["telefone_cel"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["email"]); ?></td>    
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["familia"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["discipulado"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["selamentos"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["servico_abraxico"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["pre_mynian"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["mynian"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["tavola"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["voluntario"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["estado_discipular"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["motivo"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["regime_assinado"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["doador_imagem"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= substr(utf8_decode($rs["historico"]),0,15); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["LOGIN"] );?></td> 
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["SENHA"]); ?></td>
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["bloqueado"]); ?></td>    	  	  
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["menu"]); ?></td>    
      <td nowrap="nowrap" bgcolor="<?=($i%2)?'#f2f2f2':'#ffffff';?>" ><?= utf8_decode($rs["data_ingresso"]); ?></td>
    </tr>
  <? endwhile; ?>
</table> 
