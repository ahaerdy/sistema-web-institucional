<!-- Scripts -->
<script src="/adm/sj/js/bootstrap.min.js"></script>
<script src="/adm/sj/js/bootstrap-form-helpers/dist/js/bootstrap-formhelpers.min.js"></script>
<script src="https://malsup.github.io/min/jquery.form.min.js"></script>
<script src="/adm/sj/js/jquery.highlight-3.js"></script>
<script src="/adm/sj/js/jquery.highlight-3.yui.js"></script>
<script src="/adm/sj/js/jquery.validate.min.js"></script>
<script src="/adm/sj/js/additional-methods.min.js"></script>
<script src="/adm/sj/js/uploadify/jquery.uploadify.min.js"></script>
<script src="/adm/sj/js/jquery.sortable.min.js"></script>
<script src="/adm/sj/js/scripts.js"></script>

<!-- Scroll-UP -->
<!-- <script type="text/javascript" src="/adm/sj/js/jquery-1.11.1.min.js"></script>
 --><script type="text/javascript" src="/adm/sj/js/jquery.scrollUp.js"></script>

<script>
/* scrollUp Minimum setup */
// $(function () {
// $.scrollUp();
// });

/* scrollUp full options */
$(function () {
    $.scrollUp({
        scrollName: 'scrollUp', // Element ID
        topDistance: '300', // Distance from top before showing element (px)
        topSpeed: 300, // Speed back to top (ms)
        animation: 'slide', // Fade, slide, none
        animationInSpeed: 200, // <a href="http://www.jqueryscript.net/animation/">Animation</a> in speed (ms)
        animationOutSpeed: 200, // Animation out speed (ms)
        scrollText: 'Voltar ao topo', // Text for element
        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
    });
});
</script>

<script>
  jQuery('document').ready(function(){
    var el = jQuery('.book-content > div.panel-body, .artigo-texto, .galleria-texto');
    <?php 
      $word = getParam('b_palavra');
      $ocorencia = (int) getParam('ocorencia');
      $ocorencia = (empty($ocorencia))? 0:($ocorencia-1);
      if(!empty($word)):
        if(getParam('b_tipo') != 'F'):
          $palavras = explode(' ', urldecode($word));
          foreach ($palavras as $ln):
            echo "el.highlight('${ln}');";
          endforeach;
        else:
          echo "el.highlight('${word}');";
        endif;
        echo "
              var span = jQuery('body').find('span.highlight').each(function(index, value){
              if(index == ${ocorencia})
                jQuery(this).html('<span class=\"high-active\">'+jQuery(this).text()+'</span>');
              });";
      endif;
      $aba = (int)getParam('aba');
      if(!empty($aba))
        echo "jQuery('a[href=\"#${aba}\"]').tab('show');";
    ?>
  });
  jQuery('#filtro').click(function(){
    var txt = jQuery('#txt-filtro').val();
    jQuery('body').removeHighlight();
    jQuery('body').highlight(txt);
  });
  if(typeof printModal != 'undefined')
  {
    var m = jQuery('#message-modal');
    m.modal('show');
    setTimeout(function(){ m.modal( 'hide' ); }, 3000);
  }
</script>

<?php
  if(!isset($scripts)) $scripts = array();
  foreach ($scripts as $script):
    echo "<script src=\"${script}\"></script>\n";
  endforeach;
?>

