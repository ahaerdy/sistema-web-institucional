<?php
  echo '<ul class="list-group">';
    echo '<li class="list-group-item"><b>Título: </b>'.$ln2['titulo'].'</li>';
    echo '<li class="list-group-item"><b>Visualizando Página: </b>'.$ln2['numero'].'</li>';
    if(!empty($ln2['url_loja']))
      echo '<li class="list-group-item"><b>URL de compra do livro: </b><a href="'.$ln2['url_loja'].'" target="_blank">'.$ln2['url_loja'].'</a></li>';
    switch(PERMISSAO):
      case DEFAULT_ACESSO:
        echo '<li class="list-group-item"><b>Visualização por trecho da página.</b></li>';
        break;
      case ACESSO_PARCIAL:
        echo '<li class="list-group-item"><b>Visualização parcial de página.</b></li>';
        break;
      case ACESSO_TOTAL:
        echo '<li class="list-group-item"><b>Visualização total de página.</b></li>';
        break;
    endswitch;
  echo '</ul>';
?>