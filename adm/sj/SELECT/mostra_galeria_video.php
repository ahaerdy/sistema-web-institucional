<?
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $iGaleria = (int) getParam('galeria');
  if(empty($iGaleria)):
    setFlashMessage('Galeria de vídeo inválida', 'warning');
    echo redirect2('/adm/sj/index.php');
    exit;
  endif;

                $videoId = (int) getParam('video');
                if($videoId)
                  $w = "AND vd.id = ${videoId}";
                $sql = "SELECT 
                          gr.diretorio as gp_diretorio,
                          tp.diretorio as tp_diretorio,
                          gl.titulo    as gl_titulo,
                          gl.descricao as gl_descricao,
                          DATE_FORMAT(gl.cadastro,'%d/%m/%Y') as gl_cadastro,
                          gl.diretorio as gl_diretorio,
                          vd.id,
                          vd.foto,
                          vd.ordem,
                          vd.video,
                          vd.comentario,
                          DATE_FORMAT(vd.cadastro,'%d/%m/%Y') as vd_cadastro
                        FROM 
                          grupos   gr
                          INNER JOIN topicos        tp ON  tp.id_grupo = gr.id
                          INNER JOIN galerias_video gl ON  gl.id_topico = tp.id
                          INNER JOIN videos         vd ON  vd.galerias_id = gl.id
                        WHERE
                          ((gr.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR 
                          ( gr.id IN (".$_SESSION['login']['usuario']['todos_id_dep_a'].") AND gr.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND gl.compartilhado = 'S' )) AND 
                          gl.id = ${iGaleria} AND 
                          gr.ativo = 'S' AND 
                          tp.ativo = 'S' AND 
                          gl.ativo = 'S'
                        ";

                $res = mysql_query("${sql} ${w} ORDER BY vd.ordem ASC LIMIT 1") or die(mysql_error());

                if( mysql_num_rows($res) ):
                  $ln = mysql_fetch_assoc($res);
                  $params['usuario_id'] = getIdUsuario();
                  $params['galeria_video_id'] = getParam('galeria');
                  setLogAtividade($params);
              ?>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="page-header title-movie"><h2><?=($ln['gl_titulo']);?></h2></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-lg-6">
                      <!-- <video  class="afterglow" id="myvideo" width="1280" height="720" data-autoresize="fit" poster="/arquivo_site/<?=$ln['gp_diretorio']?>/topicos/<?=$ln['tp_diretorio']?>/videos/<?=$ln['gl_diretorio']?>/<?=$ln['foto']?>" >

                        <source src="/arquivo_site/<?=$ln['gp_diretorio'];?>/topicos/<?=$ln['tp_diretorio'];?>/videos/<?=$ln['gl_diretorio'];?>/<?=str_replace('flv', 'mp4', $ln['video']);?>" type="video/mp4">


                        Your browser does not support the video tag.
                      </video> -->

                      <video  width="100%" height="320" poster="/arquivo_site/<?=$ln['gp_diretorio']?>/topicos/<?=$ln['tp_diretorio']?>/videos/<?=$ln['gl_diretorio']?>/<?=$ln['foto']?>" controls controlsList="nodownload">

                        <source src="/arquivo_site/<?=$ln['gp_diretorio'];?>/topicos/<?=$ln['tp_diretorio'];?>/videos/<?=$ln['gl_diretorio'];?>/<?=str_replace('flv', 'mp4', $ln['video']);?>" type="video/mp4">


                        Your browser does not support the video tag.
                      </video>

                  </div>
                  <div class="col-md-6 col-lg-6">
                    <?=(empty($ln['gl_descricao']))?'':'<p class="lead galleria-texto" align="justify" style="font-size:15px; font-family: Roboto, sans-serif; font-weight:300;">'.stripslashes((nl2br($ln['gl_descricao']))).'</p>';?>
                    <ul class="list-group">
                      <li class="list-group-item" style="text-align:justify;"><b>Comentário:</b> <?=stripslashes((nl2br(($ln['comentario'])))); ?></li>
                      <li class="list-group-item">Vídeo (<?=($ln['ordem']);?>)</li>
                    </ul>
                  </div>
                </div>
              <? else: ?>
                <div align="center">Não há conteúdo disponível</div>
              <? endif; ?>

            <div class="row">
              <div class="col-lg-12">
              <? $res = mysql_query("${sql} ORDER BY vd.ordem ASC"); ?>
              <? if( mysql_num_rows($res) ): ?>
                  <div class="page-header title-movie"><h3>Outros vídeos</h3></div>
                  <div class="row">
                    <? while($ln = mysql_fetch_assoc($res)): ?>
                    <div class="col-sm-4 col-md-3 col-lg-2">
                      <div class="thumbnail" style="min-height: 300px;">
                        <!-- <img src="/<?=base64_encode('/arquivo_site/'.$ln['gp_diretorio'].'/topicos/'.$ln['tp_diretorio'].'/videos/'. $ln['gl_diretorio'].'/'.$ln['foto']).substr($ln['foto'], -4); ?>" style="height: 160px;"/>-->
                        <img src="/arquivo_site/<?=$ln['gp_diretorio'];?>/topicos/<?=$ln['tp_diretorio'];?>/videos/<?= $ln['gl_diretorio'];?>/<?=$ln['foto'];?>" style="height: 160px;"/>
                        <div class="caption">
                          <h6 class="descricao-video"><?=substr(($ln['comentario']),0,200)."...";?></h6>
                          <a href="/adm/sj/index.php?op=mostra_galeria_video&galeria=<?=$iGaleria?>&video=<?=$ln['id'];?>" class="btn btn-danger" role="button">Visualizar</a>
                          <small>Vídeo (<?=$ln['ordem'];?>)</small>
                        </div>
                      </div>
                    </div>
                    <? endwhile; ?>
                  </div>
              <? endif; ?>
            </div>
          </div>

