  
  <? if($gridType == 'B'): ?>
    <? while($ln = mysql_fetch_assoc($query)): ?>
      <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
        <div class="thumbnail grid-box">
          <a href="<?=$urlLink.$ln['id'];?>">
            <div class="grid-img-thumb">
              <img src="<?=getPhoto('/'.base64_encode($ln['foto']).'.'.substr($ln['foto'], -4), $ln['capa']);?>" width="100%" alt=""/>
            </div>
          </a>
          <div class="caption">
            <blockquote>
              <h4 class="grid-title" style="<?=(strlen($ln['titulo'])>70)?'font-size:70%':'font-size:90%';?>"><?=$ln['titulo'];?></h4>
              <?=getBookTranlatePermission($ln);?>
              <small><?=$ln['cadastro'];?></small>
            </blockquote>
            <? $permisson = getBookPermission($ln); ?>
            <? if(!(isset($ln['lp_permissao']) || isset($ln['lv_permissao'])) || $permisson == "T"): ?>
              <a href="<?=$urlLink.$ln['id'];?>" class="btn btn-<?=$typeColor?> btn-sm btn-block">Saiba Mais</a>
            <? else: ?>
              <button class="btn btn-default btn-sm btn-block disabled">Saiba Mais</button>
            <? endif; ?>
          </div>
        </div>
      </div>
    <? endwhile; ?>
  <? elseif($gridType == 'L'): ?>
    <? while($ln = mysql_fetch_assoc($query)): ?>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="grid-box" style="min-height: initial; padding-bottom: 10px;">
          <div class="row">
            <div class="col-xs-6 col-sm-5 col-md-3 col-lg-3">
              <div class="grid-img-thumb">
                <a href="<?=$urlLink.$ln['id'];?>">
                  <img src="<?=getPhoto('/'.base64_encode($ln['foto']).'.'.substr($ln['foto'], -4), $ln['capa']);?>" width="100%">
                </a>
              </div>
              <? $permisson = getBookPermission($ln); ?>
              <? if(!(isset($ln['lp_permissao']) || isset($ln['lv_permissao'])) || $permisson == "T"): ?>
                <a href="<?=$urlLink.$ln['id'];?>" class="btn btn-<?=$typeColor?> btn-sm btn-block">Saiba Mais</a>
              <? else: ?>
                <button class="btn btn-default btn-sm btn-block disabled">Saiba Mais</button>
              <? endif; ?>
            </div>
            <div class="col-xs-6 col-sm-7 col-md-9 col-lg-9">
              <blockquote>
                <h4 class="grid-title"><?=$ln['titulo'];?></h4>
                <?=getBookTranlatePermission($ln);?>
                <small><?=$ln['cadastro'];?></small>
             </blockquote>
            </div>
          </div>
        </div>
      </div>
      <div class="spacing"></div>
    <? endwhile; ?>
  <? elseif($gridType == 'T'): ?>
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <table class="table table-striped">
        <thead>
          <tr>  
            <th>TÍTULO</th>
            <th>DATA</th>
            <th></th>
          </tr>
        </thead>
        <? while($ln = mysql_fetch_assoc($query)): ?>
        <? if(isset($ln['lp_permissao']) || isset($ln['lv_permissao'])): ?>
          <? $permisson = getBookPermission($ln); ?>
          <? if($permisson == "T"): ?>
            <tr>
              <td><a href="<?=$urlLink.$ln['id'];?>"><?=$ln['titulo'];?></a></td>
              <td><a href="<?=$urlLink.$ln['id'];?>"><?=$ln['cadastro'];?></a></td>
              <td><?=getBookTranlatePermission($ln)?></td>
            </tr>
          <? else: ?>
            <tr>
              <td><?=$ln['titulo'];?></td>
              <td><?=$ln['cadastro'];?></td>
              <td><?=getBookTranlatePermission($ln)?></td>
            </tr>
          <? endif; ?>
        <? else: ?>
          <tr>
            <td><a href="<?=$urlLink.$ln['id'];?>"><?=$ln['titulo'];?></a></td>
            <td colspan="2"><a href="<?=$urlLink.$ln['id'];?>"><?=$ln['cadastro'];?></a></td>
          </tr>
        <? endif; ?>
        <? endwhile; ?>
      </table>
    </div>
  <? endif; ?>