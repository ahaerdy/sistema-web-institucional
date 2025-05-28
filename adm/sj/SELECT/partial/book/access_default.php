<div class="row">
  <div class="col-lg-4 col-lg-offset-8">
    <? if($totalOcorencia > 0): ?>
      <div class="pull-right">
          <div class="btn-group">
            <? if($totalOcorencia > 1): ?>
              <div class="btn btn-default">
                <a href="/adm/sj/index.php?<?=$urlCompleta . '&ocorencia=' . ($currOcorenciaAnt);?>">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
              </div>
            <? endif; ?>

            <div class="btn btn-default">Você está visualizando a <?=$current;?>° de <?=$totalOcorencia;?> ocorencia(s)</div>

            <? if($totalOcorencia > 1): ?>
              <div class="btn btn-default">
                <a href="/adm/sj/index.php?<?=$urlCompleta . '&ocorencia=' . ($currOcorenciaProx);?>">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
              </div>
            <? endif; ?>
          </div>
        </div>
    <? endif; ?>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default book-content">
      <div class="panel-body">
        <?php
          echo '...';
          $ini = $ocorencias[$currOcorencia][1]-400;
          if($ini <= -1)
            $ini = 0;
          echo substr($texto, $ini, 800);
          echo '...';
        ?>
      </div>
    </div>
  </div>
</div>