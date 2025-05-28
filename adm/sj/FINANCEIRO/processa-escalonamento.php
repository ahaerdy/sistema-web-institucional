<?php

ini_set('default_charset','UTF-8');
$conn=mysql_connect('localhost','JESNET_USUARIO','JESNET_SENHA') or die('Erro na conexão com o usuário do banco de dados!');
$db=mysql_select_db('JESNET_ADMINISTRADOR',$conn) or die('Erro na conexão com o banco de Dados!');
mysql_set_charset('utf8');

$DEBUG=false;

function ListaUsuarios($a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9,$bordercolor) {
  
   /* DEBUG - Abre  tabela com cabeçalho para 1 usuário */
    echo "<table border=\"2\" bordercolor=\"$bordercolor\">"; 
    echo "<tr style=\"font-weight:bold\">";
    echo "<td align=\"center\" width=\"50\">"."id"."</td>";
    echo "<td width=\"200\">&nbsp"."nome"."</td>";
    echo "<td align=\"center\" width=\"90\">"."grupos_id"."</td>";
    echo "<td align=\"center\" width=\"90\">"."grupo_home"."</td>";
    echo "<td align=\"center\" width=\"50\">"."ps_id"."</td>";
    echo "<td align=\"center\" width=\"70\">"."count_id"."</td>";
    echo "<td align=\"center\" width=\"50\">"."e_id"."</td>";
    echo "<td align=\"center\" width=\"100\">"."ordem_atual"."</td>";
    echo "<td align=\"center\" width=\"50\">"."pai"."</td>";
    echo "</tr>";
    
    /* DEBUG - Linhas da Tabela */
    echo "<tr>";
        echo "<td align=\"center\" width=\"50\">".$a1."</td>";
        echo "<td width=\"200\">&nbsp".$a2."</td>";
        echo "<td align=\"center\" width=\"90\">".$a3."</td>";
        echo "<td align=\"center\" width=\"90\">".$a4."</td>";
        echo "<td align=\"center\" width=\"50\">".$a5."</td>";
        echo "<td align=\"center\" width=\"70\">".$a6."</td>";
        echo "<td align=\"center\" width=\"50\">".$a7."</td>";
        echo "<td align=\"center\" width=\"100\">".$a8."</td>";
        echo "<td align=\"center\" width=\"50\">".$a9."</td>";
    echo "</tr>";

    echo "</table><br/>"; /* Fecha tabela de 1 usuário */

}

if ($DEBUG) {
      echo "<h2 style=\"color:#870022\"><b><u>Processa-Escalonamento</u></b>:</h2>";
}

/* Nonta tabela de usuários:
---> NÂO ISENSTOS de pagamento  
---> com pagamentos nos seguintes status: (2) "Em Aberto", (4) "Aguardando Pagamento", (5) "Em Análise", (6) "Disponível", (7) "Em Disputa" e (10) "Em Aberto" (Negociação). Quando o sistema receber os status (3) "Cancelado" ou (8) "Devolvido" pela rotina retorno_pagseguro.php automaticamente gerará nova cobrança com status "Em Aberto". */
$res = mysql_query("SELECT  usuarios.id, 
                            usuarios.nome,
                            usuarios.grupos_id,
                            usuarios.grupo_home,
                            pagamentos.pagamento_status_id AS ps_id,
                            count(usuarios.id),
                            usuarios.escalonamento_id,
                            escalonamentos.ordem AS ordem_atual,
                            escalonamentos.escalonamento_id AS Pai
                    FROM usuarios
                    LEFT JOIN pagamentos ON usuarios.id=pagamentos.usuario_id
                    LEFT JOIN escalonamentos ON usuarios.escalonamento_id=escalonamentos.id
                    WHERE pagamentos.pagamento_status_id in (2,4,5,6,7,10)
                          AND usuarios.categoria_pagamento_id!=''
                    GROUP BY usuarios.id;") or die(mysql_error());
/*Verifica se a query encontrou algum resultado */
if(mysql_num_rows($res)):
  /* Em caso positivo processa cada usuário da tabela uma vez */

  while($ln = mysql_fetch_assoc($res)):
    
    $id=$ln['id'];
    $nome=$ln['nome'];
    $grupos_id=$ln['grupos_id'];
    $grupo_home=$ln['grupo_home'];
    $ps_id=$ln['ps_id'];
    $count_id=$ln['count(usuarios.id)'];
    $e_id=$ln['escalonamento_id'];
    $ordem_atual=$ln['ordem_atual'];
    $pai=$ln['Pai'];

    if ($DEBUG) ListaUsuarios ($id,$nome,$grupos_id,$grupo_home,$ps_id,$count_id,$e_id,$ordem_atual,$pai,"black");
    
    /* Monta tabela do Pai com seus filhos e a ordem ref. ao usuário acima */
    $res_pai = mysql_query("SELECT escalonamento_id,
                                    id,
                                    grupo_id,
                                    ordem
                            FROM escalonamentos
                            WHERE escalonamento_id=".$pai." ORDER BY ordem ASC;") or die(mysql_error());

    if ($DEBUG) {
      /* Monta tabela com cabeçalho do Pai com seus filhos */
      echo "<table border=\"1\">"; 
      echo "<tr style=\"font-weight:bold\">";
      echo "<td align=\"center\" width=\"200\">"."pai_e_id"."</td>";
      echo "<td align=\"center\" width=\"50\">"."pai_id"."</td>";
      echo "<td align=\"center\" width=\"70\">"."grupo_id"."</td>";
      echo "<td align=\"center\" width=\"80\">"."pai_ordem"."</td>";
      echo "<td align=\"center\" width=\"80\">"."e_id"."</td>";
      echo "</tr>";
    }
    /* Examina uma linha por vez*/
    
    $prox_ordem_atual=$ordem_atual;
    $prox_e_id=$e_id;
    $prox_grupo_id=$grupos_id;
    $lock_incremento_ordem=0;

    while($ln_pai = mysql_fetch_assoc($res_pai)):

      $pai_e_id=$ln_pai['escalonamento_id'];
      $pai_id=$ln_pai['id'];
      $pai_grupo_id=$ln_pai['grupo_id'];
      $pai_ordem=$ln_pai['ordem'];

      if ($pai_ordem>$ordem_atual AND $lock_incremento_ordem==0) { 
        $prox_ordem_atual=$pai_ordem;
        $prox_e_id=$pai_id;
        $prox_grupo_id=$pai_grupo_id;
        $lock_incremento_ordem=1;
      }

      if ($DEBUG) {
        /* Linhas da Tabela */
        echo "<tr>";
        echo "<td align=\"center\" width=\"200\">".$pai_e_id."</td>";
        echo "<td align=\"center\" width=\"50\">".$pai_id."</td>";
        echo "<td align=\"center\" width=\"70\">".$pai_grupo_id."</td>";
        echo "<td align=\"center\" width=\"80\">".$pai_ordem."</td>";
        echo "<td align=\"center\" width=\"80\">".$e_id."</td>";
        echo "</tr>";
      }

    endwhile;

    $ordem_maxima=$pai_ordem;
    
    if ($DEBUG) {
      echo "</table><br/>"; /* Fecha a tabela. */
      echo "<b>ordem_atual=".$ordem_atual."</b> onde ";
      echo "<b>e_id=".$e_id."</b> e <b>grupo_id=".$grupos_id."</b><br/>";
      echo "<b>ordem_maxima=".$ordem_maxima."</b></br/>";
    }

    if ($ordem_atual < $ordem_maxima) {
      if ($DEBUG) echo "Incrementando ordem atual: ";

      $prox_ordem_atual = $ordem_atual+1;

      if ($DEBUG) {
        echo "<b>prox_ordem_atual=".$prox_ordem_atual."</b> onde ";
        echo "<b>prox_e_id=".$prox_e_id."</b> e <b>prox_grupo_id=".$prox_grupo_id."</b><br/><br/>";
        echo "<b><u>Atualizando tabelas</u>:</b><br/><br/>";
        echo "==> <b>UPDATE</b> usuarios <b>SET</b> grupos_id=".$prox_grupo_id.",grupo_home=".$prox_grupo_id.",escalonamento_id=".$prox_e_id." <b>WHERE</b> id=".$id."<br/>";
        echo "==> <b>DELETE FROM</b> grupos_usuarios <b>WHERE</b> id_usuario=".$id." <b>AND</b> escalonamento=1"."<br/>";
        echo "==> <b>INSERT INTO</b> grupos_usuarios (id_usuario, id_grupo, escalonamento) <b>VALUES</b> (".$id.", ".$prox_grupo_id.", 1)"."<br/><br/>";
      }

      /* Atualizando as tabelas */
      
      mysql_query("UPDATE usuarios SET grupos_id=".$prox_grupo_id.",grupo_home=".$prox_grupo_id.",escalonamento_id=".$prox_e_id." WHERE id=".$id) or die(mysql_error());
      mysql_query("DELETE FROM grupos_usuarios WHERE id_usuario=".$id." AND escalonamento=1") or die(mysql_error());
      mysql_query("INSERT INTO grupos_usuarios (id_usuario, id_grupo, escalonamento) VALUES (".$id.", ".$prox_grupo_id.", 1)") or die(mysql_error());

      if ($DEBUG) ListaUsuarios($id,$nome,$prox_grupo_id,$prox_grupo_id,$ps_id,$count_id,$prox_e_id,$prox_ordem_atual,$pai,"red");
      
    
    } else { 
              if ($DEBUG) { 
                echo "Ordem atual permanece: "."<b>prox_ordem_atual=".$prox_ordem_atual."</b> onde ";       
                echo "<b>prox_e_id=".$prox_e_id."</b> e <b>prox_grupo_id=".$prox_grupo_id."</b><br/>"; }
            }
    if ($DEBUG) echo "-------------------------------------------------------------------------------------------<br/><br/>";
  endwhile;

  $boolarray = Array(false => 'false', true => 'true');
  echo "<u>DEBUG=<b>".$boolarray[$DEBUG]."</b></u> ===> Escalonamentos processados com sucesso!";
  exit;
endif;
?>

