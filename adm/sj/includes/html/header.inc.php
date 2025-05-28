<?php if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; } ?>

<nav class="header-nav navbar navbar-default" role="navigation">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" title="Tela incial do sistema" href="/adm/sj/index.php">
      <b>Portal Saber Jessênio</b>
      <?php 
        // $todos_id=$_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_le'];
        // if(getIdUsuario() == 208) { echo "Todos id=".$todos_id; }
      ?>
      </a>
   </div>
   <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
         <li>
            <?php
               if($_SESSION['login']['iGrupo']):
                 echo '<a href="/adm/sj/index.php?grupo='.$_SESSION['login']['iGrupo'].'" title="Tela inicial do grupo">';
               else:
                 echo '<a href="/adm/sj/index.php?grupo='.$_SESSION['login']['usuario']['grupo_inicial'].'" title="Tela inicial do grupo">';
               endif;
                 echo '<span class="glyphicon glyphicon-home"></span>';
               echo '</a>';
               ?>
         </li>
      </ul>
      <? require "includes/home/recent_events.php"; ?>
      <? // require "includes/home/recent_comunications.php"; ?> 
      <? require "includes/home/conference.php"; ?>
      <? require "includes/home/mensagens.php"; ?>
      <? require "includes/home/contribuicoes.php"; ?>

      <?

        $res2 = mysql_query("SELECT escalonamentos.bloqueia_select_grupos
                            FROM usuarios 
                            LEFT JOIN escalonamentos 
                            ON usuarios.escalonamento_id=escalonamentos.id 
                            WHERE usuarios.id=".$_SESSION['login']['id']." 
                            AND usuarios.categoria_pagamento_id!='' 
                            GROUP BY usuarios.id;") or die(mysql_error());

        $result=mysql_fetch_assoc($res2);

      ?>

      <? if ($result['bloqueia_select_grupos']!="Sim") {  
            $total = $xCom + $xEve + $xConf + $xMen + $xContrib;
         } else { $total = $xCom + $xEve + $xMen + $xContrib; }
      ?>

      <? $badge = ($total)? "<span class=\"badge\" style=\"background: #CB0000;\">${total}</span>" : ''; ?>
      <? $badge1 = ($xConf)? "<span class=\"badge\" style=\"background: #CB0000;\">${xConf}</span>" : ''; ?>
      <ul class="nav navbar-nav navbar-right">
      
               
        <? 
            $_SESSION['login']['display_form_inline']='Sim'; 

            // Para reabilitar o link do fórum trocar 'Nulo' por 'Sim' (by Arthur em 13/07/2019)
            if ($_SESSION['login']['forum']=='Nulo') { ?>
              <li>
                  <!-- <a href="/adm/sj/index.php?op=mostra_forum" title="Fórum"><span class="glyphicon glyphicon-user"></span></a>  -->

                  <?

                    $res3=mysql_query("SELECT n.user_id,u.username,n.notification_read,count(n.notification_read) AS count FROM jesnet_forum.phpbb_notifications n LEFT JOIN jesnet_forum.phpbb_users u ON n.user_id=u.user_id WHERE u.username='".$_SESSION['login']['LOGIN']."' and n.notification_read=0")or die(mysql_error());
  
                    $result3=mysql_fetch_assoc($res3);

                    // Para link com botão (acrescentar): 
                    // class="btn btn-primary" style="text-align:left;border: 1px solid rgba(0,0,0,0.1); box-shadow: inset 0 1px 0 rgba(255,255,255,0.7)"


                    if($result3['count']!=0) { ?>
                        <a style="text-align:left" href="/adm/sj/index.php?op=mostra_forum" title="Fórum"><i class="fa fa-weixin fa-5" aria-hidden="false"></i><span > <b>Fórum <span class="badge" style="background: #CB0000;"><? echo $result3['count']; ?></span></b></span></a>
                    <? } else { ?>
                            <a style="text-align:left" href="/adm/sj/index.php?op=mostra_forum" title="Fórum"><i class="fa fa-weixin fa-5" aria-hidden="false"></i><span> <b>Fórum</b></span></a>
                         <? } ?>

              </li>
        <? } ?>

         <li>
            <a href="/adm/sj/index.php?op=mostra_calendario" title="Calendário"><span class="glyphicon glyphicon-calendar"></span></a>
         </li>
        

         <li class="dropdown">
            <a id="dLabel" data-toggle="dropdown" data-target="#" href="#">
            <?
                $string=$_SESSION['login']['nome'];
                $length=25;  
                $appendStr="...";

                $truncated_str = "";
                $useAppendStr = (strlen($string) > intval($length))? true:false;
                $truncated_str = substr($string,0,$length);
                $truncated_str .= ($useAppendStr)? $appendStr:"";

                $nome_=$truncated_str;
                //$nome_=$string;
                
                
            ?>
            
            <!-- Escreve o nome no canto superior direito -->
            <?=$nome_?> 
            <?=$badge;?> <b class="caret"></b>

            </a>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
               <?php
                  if(getTipoUsuario()!='admin'):
                    /* echo $badgeCom; */
                    /* echo $badgeEve; */
                    /* echo $badgeMen; */

               ?>

               <? if ($result['bloqueia_select_grupos']!="Sim") {  ?>
                  <li><a href="/adm/sj/index.php?op=atualizacoes">Atualizações</a></li>
               <? } ?>
               
               <?php if(getTipoUsuario() != 'admin') echo $badgeContrib; ?>
               <!-- <li><a href="/adm/sj/index.php?op=pagamentos">Contribuições</a></li> -->

               <? if ($_SESSION['login']['id']==208 OR $_SESSION['login']['id']==98      /* Luis Fernando */
                                                    OR $_SESSION['login']['id']==135     /* Gisele Perna  */
                                                    OR $_SESSION['login']['id']==163     /* Lorena        */ 
                                                    OR $_SESSION['login']['id']==141) {  /* Marley        */

                      $_SESSION['RF']["bloqueia_COAM"] = false;
                      $_SESSION['RF']["bloqueia_SIGNATURA"] = false;
                      $_SESSION['RF']["bloqueia_CEGME"] = false;
                      $_SESSION['RF']["bloqueia_AURORA"] = false;
                      $_SESSION['RF']["bloqueia_PLANTAS_MEDICINAIS"] = false;
                      $_SESSION['RF']["bloqueia_VIAGEM_A_ISRAEL"] = false;
                      $_SESSION['RF']["bloqueia_ESTUDOS_BIBLICOS"] = false;

               ?>  <li><a href="/adm/sj/index.php?op=fileman">Gerenciador de Arquivos</a></li> 
               <? } ?> 

               <? 

                  if ($_SESSION['login']['id']==208) $_SESSION['RF']["subfolder"] = 'user_98'; 
                  if ($_SESSION['login']['id']==98) $_SESSION['RF']["subfolder"] = 'user_98'; 
                  if ($_SESSION['login']['id']==135) $_SESSION['RF']["subfolder"] = 'user_135'; 
                  if ($_SESSION['login']['id']==141) $_SESSION['RF']["subfolder"] = 'user_141';
                  if ($_SESSION['login']['id']==163) $_SESSION['RF']["subfolder"] = 'user_163';

               ?>


               
               <? if(($badge1) AND ($result['bloqueia_select_grupos']!="Sim")): ?>
               <li class="dropdown-submenu">
                  <a tabindex="-1" href="#">Videoconferência <?=$badge1;?> </a>
                  <ul class="dropdown-menu">
                     <li><a tabindex="-1" href="#"><?php echo $badgeConf; ?></a></li>
                  </ul>
               </li>
               <li class="divider"></li>
               <? endif;?>
               <li><a href="/adm/sj/index.php?op=minha-conta">Minha conta</a></li>

               <li class="divider"></li>
               <?php
                  endif;
                  ?>
               <li><a href="sair_sistema.php">Sair</a></li>
            </ul>
         </li>
      </ul>
      <?
          $res2 = mysql_query("SELECT escalonamentos.bloqueia_select_grupos
                                      FROM usuarios 
                                      LEFT JOIN escalonamentos 
                                      ON usuarios.escalonamento_id=escalonamentos.id 
                                      WHERE usuarios.id=".$_SESSION['login']['id']." 
                                      AND usuarios.categoria_pagamento_id!='' 
                                      GROUP BY usuarios.id;") or die(mysql_error());

          $result=mysql_fetch_assoc($res2);
      ?>
      <?php if ((getTipoUsuario() != 'admin') AND ($result['bloqueia_select_grupos']!="Sim")) : ?>
  

          <form action="index.php" class="navbar-form navbar-right search-header" method="get" onsubmit="return validate()">
             <input type="hidden" name="op" value="bus_conteu"/>
             <input type="hidden" name="buscar" value="Buscar"/>
             <div class="form-group">
                <div class="input-group">
                  <input type="text"  id="pesquisa" name="b_palavra" value="<?=getParam('b_palavra');?>" placeholder="O que você quer pesquisar?" class="form-control" />
                  <span class="input-group-btn">
                    <input type="submit" class="btn btn-info" value="Pesquisar" /> 
                      <!-- <input type="submit" class="btn btn-info fa" value="&#xf002" style="font-size:20px; vertical-align: middle;"/> -->
                  </span>
                </div>
             </div>
          </form>
        

      <?php endif; ?>
   </div>
   <!-- /.navbar-collapse -->
</nav>

<script type="text/javascript">
function validate() {
    if (document.getElementById("pesquisa").value == "" && document.getElementById("pesquisa").value == "") {
         // alert("all fields are empty");
         return false;
    } else {
        return true;
    }
}
</script>

<script type="text/javascript">
    $('#monitor').html($(window).width());
    $(window).resize(function() {
        var viewportWidth = $(window).width();
        $('#monitor').html(viewportWidth);
    });
</script>