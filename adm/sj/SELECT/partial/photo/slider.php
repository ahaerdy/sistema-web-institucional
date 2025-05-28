<div class="row">
  <?php mysql_data_seek($res, 0); ?>
  <?php while ($ln = mysql_fetch_assoc($res)): ?>
    <div class="col-xs-4 col-sm-3 col-md-3 col-lg-2">
      <small style="margin-top: -10px">Foto (<?=++$i;?>)</small>
      <a style="height: 180px; overflow: hidden; display: block; margin-bottom: 30px; background: url(/<?=base64_encode(('/arquivo_site/'.$ln['gp_diretorio'].'/topicos/'.$ln['tp_diretorio'].'/fotos/'.$ln['gl_diretorio'].'/'.$ln['foto'])) . substr($ln['foto'], -4);?>); background-position: center center; background-size: auto 100%; background-repeat: no-repeat; background-color: #f2f2f2;" class="thumbnails" title="<?=$ln['comentario'];?>" href="/<?=base64_encode(('/arquivo_site/'.$ln['gp_diretorio'].'/topicos/'.$ln['tp_diretorio'].'/fotos/'.$ln['gl_diretorio'].'/'.$ln['foto'])) . substr($ln['foto'], -4);?>" data-lightbox="roadtrip"> 


      </a>
    </div>
  <? endwhile; ?>
</div>
<?php 
  $scripts[] = "/adm/sj/js/slider/js/lightbox-2.6.min.js";
?>