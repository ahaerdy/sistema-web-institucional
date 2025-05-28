<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="pull-right">
      <ul class="pagination">
        <?
          if($sql):
            if(empty($fieldPag))
              $fieldPag = 'pagina';
            $total      = mysql_num_rows(mysql_query($sql));
            if($total):
              $pags       = ceil($total / $qnt);
              $max_links  = 2;

              echo "<li><a href='?${urlPaginacao}&${fieldPag}=1'>Primeira</a></li>";

              for($i = $currentPageNumber-$max_links; $i <= $currentPageNumber-1; $i++):
                if($i <=0):
                else:
                    echo "<li><a href='?${urlPaginacao}&${fieldPag}=${i}'>${i}</a></li>";
                endif;
              endfor;

              echo "<li class='active'><a href='?${urlPaginacao}&${fieldPag}=${currentPageNumber}'>${currentPageNumber}</a></li>";

              for($i = $currentPageNumber+1; $i <= $currentPageNumber+$max_links; $i++):
                if($i > $pags):
                else:
                  echo "<li><a href='?${urlPaginacao}&${fieldPag}=${i}'>${i}</a><li>";
                endif;
              endfor;

              echo "<li><a href='?${urlPaginacao}&${fieldPag}=${pags}'>Última</a></li>";
            endif;
          else:
            $total = 0;
          endif;
        ?>
      </ul>
      <?
        if($livro)
          echo "<p align='right'>O livro contem ${total} páginas.</p>";
        else
          echo "<p align='right'>${total} registro(s) encontrado.</p>";
      ?>
    </div>
    <div class="clearfix"></div>
  </div>
</div>