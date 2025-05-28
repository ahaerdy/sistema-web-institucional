<?php
    $video = (!empty($_GET['video']) && (int)$_GET['video']) ? (int)$_GET['video'] : exit;
    /* AJAX QUANDO SELECIONA O GRUPO NA HOME */
    if(!isset($_SESSION))
    {
        session_start();
        chdir('../');
        require_once getcwd() . "/verifica.php";
        require_once getcwd() . "/includes/functions.php";
        require_once getcwd() . "/includes/header.php";
    }
    if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
?>

<div class="box">
  <div class="box-esp">
    <div class="tit-verde">VÍDEO</div>
    <div class="h20px"></div>
      <div class="box-content">
        <div style="float: right; width: 100%; min-height: 21em; overflow: hidden; margin: 0; padding: 0;">
          <div style="padding: 0 0 0 40em;">
            <div class="box right" style="float: left; width: 100%; margin: 0 0 0 -40em; background: red;">
              <?php
                        $sql = "SELECT 

                                    gr.diretorio as gp_diretorio,

                                    tp.diretorio as tp_diretorio,

                                    gl.diretorio as gl_diretorio,

                                    us.LOGIN as autor,

                                    vd.id,

                                    vd.foto,

                                    vd.video,

                                    vd.comentario,

                                    DATE_FORMAT(vd.cadastro,'%d/%m/%Y') as vd_cadastro

                              FROM 

                                    grupos      gr,

                                    topicos     tp, 

                                    galerias_video  gl, 

                                    videos        vd, 

                                    usuarios    us

                                WHERE

                                    vd.id       = $video

                                    AND

                        gl.id       = vd.galerias_id

                        AND

                                    gl.id_topico  = tp.id

                                    AND 

                                    gl.id_usuario   = us.id

                                    AND

                                    tp.id_grupo   in (".$_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'].")

                                    AND

                                    gr.id       = tp.id_grupo

                                    AND

                                    vd.galerias_id  = gl.id

                                ";

                    

                        $res = mysql_query($sql . ' LIMIT 1');

        

                      if(mysql_num_rows($res))

                      {

                    ?>



                          <div class="artigo-texto"><?=(mysql_result($res,0,'comentario'));?></div>

                          

                          <div class="clear h20px"></div>

                          

                          <b>Autor:</b> <?=(mysql_result($res,0,'autor'));?>

                      <br/>

                      <b>Criado:</b> <?=(mysql_result($res,0,'vd_cadastro'));?>

                          

                          <div class="clear h20px"></div>

        

                          <?php

                              $res = mysql_query($sql);

                              $ln  = mysql_fetch_assoc($res);

                            ?>

    

                            <!-- START OF THE PLAYER EMBEDDING TO COPY-PASTE -->

                          <div id="mediaplayer"></div>

                          

                          <script type="text/javascript" src="/adm/js/jwplayer.js"></script>

                          <script type="text/javascript">

                            jwplayer("mediaplayer").setup({

                              flashplayer: "/adm/js/player.swf",

                              file: "/<?=base64_encode(('/arquivo_site/' . $ln['gp_diretorio'] . '/topicos/' . $ln['tp_diretorio'] . '/videos/'. $ln['gl_diretorio'] . '/' . $ln['video'])) .  substr($ln['video'], -4);?>",

                              image: "/<?=base64_encode(('/arquivo_site/' . $ln['gp_diretorio'] . '/topicos/' . $ln['tp_diretorio'] . '/videos/'. $ln['gl_diretorio'] . '/' . $ln['foto'])) .  substr($ln['foto'], -4); ?>",

                              width: '50%',

                              heigth: '400',

                              title: 'teste',

                              description: '<?=addslashes($ln['comentario']);?>'

                            });

                          </script>

                          <!-- END OF THE PLAYER EMBEDDING -->

                <?php 

                        }

                    ?>



            <div class="clear h20px"></div>



        </div>



  </div>



</div>