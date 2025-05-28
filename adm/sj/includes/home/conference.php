<?php

if (getIdUsuario() > '3'):
  $idLeituraTotal = $_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_le'];
  $f_cidade=$_SESSION['login']['cidade'];
  $query = mysql_query("SELECT s.*, DATE_FORMAT(data_inicio, '%H:%i') as data_ini 
                        FROM grupos gp INNER JOIN sala_conference s ON s.grupo_id = gp.id 
                        WHERE s.grupo_id IN (${idLeituraTotal}) AND s.filtro_cidade!='".$f_cidade."' AND (DATE(data_inicio) <= '".date('Y-m-d')."' AND data_final > NOW())");
  $badgeConf  = null;
  $xConf = mysql_num_rows($query);
  if($xConf):
    while($ln = mysql_fetch_assoc($query)):
      if ($_SESSION['login']['id']==98) {
        // $arr = get_defined_vars();
        // echo "<pre>";
        // print_r($arr[_SESSION]);
        // echo "</pre>";
        //echo "valor=".$_SESSION['login']['cidade'];
        // exit; 
      }
      
        $data_inicio = strtotime($ln['data_inicio']);
        $data_inicio_corrigida = strtotime($ln['data_inicio']) - (30*60);
        $data_final = strtotime($ln['data_final']);
        $data_hora_atual = strtotime(date('Y-m-d H:i:s'));
       /* echo "data_inicio=".$ln['data_inicio']."--->".$data_inicio."<br/>";
        echo "data_inicio_corrigida --->".$data_inicio_corrigida."<br/>";
        echo "data_final=".$ln['data_final']."--->".$data_final."<br/>";
        echo "data_hora_atual=".date('Y-m-d H:i:s')."--->".$data_hora_atual."<br/>";*/
        if (($data_inicio_corrigida < $data_hora_atual) AND ($data_final > $data_hora_atual)) {
          $badgeConf .= '<li><a href="?op=sala_conference&iGrupo='.$ln['grupo_id'].'" style="color: #3c763d; background-color: #dff0d8; font-style:normal;" onMouseOver="this.style.color=\'black\';this.style.textDecoration=\'underline\'" onMouseOut="this.style.color=\'#3c763d\';this.style.textDecoration=\'none\'" target="_blank" ><b>'.$ln['name'].'. Clique para assistir.</b></a></li>';
        }
        else $badgeConf .= '<li><a href="#">'.$ln['name'].' agendada para hoje, às '.$ln['data_ini'].' hs.</a></li>';
      
    endwhile;
    unset($ln);
  endif;
endif;
?>