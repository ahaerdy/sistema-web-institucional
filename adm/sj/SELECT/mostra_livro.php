<?
  if (empty ( $_SESSION ['login'] ['usuario'] ['todos_id_us'] )):
    echo 'Acesso negado!';
    exit ();
  endif;

  define('DEFAULT_ACESSO', 'TR');
  define('ACESSO_PARCIAL', 'P');
  define('ACESSO_TOTAL', 'T');

  //---------------------------------------------------------------------------------------------------------
  $op         = getParam('op');
  $idLivro    = (int)getParam('livro');
  $idSessao   = (int)getParam('sessao');
  $idPagina   = (int)getParam('pagina');
  $paginacao  = getParam('paginacao');
  $palavra    = getParam('b_palavra');
  $tipo       = getParam('b_tipo');
  $ocorencia  = getParam('ocorencia', 1);

  if( !$idLivro ){ echo '<script>location.href="/adm/sj/index.php"</script>'; }

  $w = array();
  $wPg = array();

  if($idLivro) $w[] = "lv.id = ${idLivro}";
  if($idSessao) $w[] = "cp.id = ${idSessao}";
  $wPg = implode(' AND ', $w);

  if($idPagina) $w[] = "pg.numero = ${idPagina}";
  $w = implode(' AND ', $w);

  // Monta URl
  //---------------------------------------------------------------------------------------------------------
  if(!empty($op       )){ $url[] = 'op='       . $op;      }
  if(!empty($idLivro  )){ $url[] = 'livro='    . $idLivro; }
  if(!empty($idSessao )){ $url[] = 'sessao='   . $idSessao;}
  if(!empty($idPagina )){ $url[] = 'pagina='   . $idPagina;}
  if(!empty($paginacao)){ $url[] = 'paginacao='. $paginacao; }
  if(!empty($palavra  )){ $url[] = 'b_palavra='. $palavra; }
  if(!empty($tipo     )){ $url[] = 'b_tipo='   . $tipo; }

  $urlCompleta = implode('&', $url);

  // PERMISSOES
  //---------------------------------------------------------------------------------------------------------

  $query = mysql_query("SELECT
                          lv.permissao as lv_permissao,
                          lp.permissao as lp_permissao
                        FROM
                          grupos gp
                        INNER JOIN topicos tp ON tp.id_grupo = gp.id
                        INNER JOIN livros lv ON  lv.id_topico = tp.id
                        LEFT JOIN tbl_livro_permissao lp ON lp.id = ( SELECT
                                                                          id
                                                                      FROM
                                                                          tbl_livro_permissao lp2
                                                                      WHERE
                                                                        lp2.id_livro = lv.id AND (lp2.id_usuario = ".getIdUsuario()." OR lp2.id_grupo = gp.id)
                                                                      ORDER BY
                                                                        lp2.id_usuario IS NULL ASC
                                                                      LIMIT 1)
                        WHERE lv.id = ${idLivro} AND gp.ativo = 'S' AND tp.ativo = 'S'") or die( mysql_error() );

  $permissao = mysql_fetch_assoc($query);
  $permissao = (empty($permissao['lp_permissao'])) ? $permissao['lv_permissao'] : $permissao['lp_permissao'];
  $permissao = (empty($permissao))? DEFAULT_ACESSO : $permissao;

  define('PERMISSAO', $permissao);

  if(PERMISSAO != ACESSO_TOTAL && empty($palavra)):
    setFlashMessage('Você não tem permissão para visualizar completamente o livro selecionado!', 'warning');
    echo redirect2('/adm/sj/index.php');
    exit;
  endif;

  $paginacao = getParam("paginacao");
  if(empty($paginacao)):
  	if($paginacao != 0 || $paginacao == ''):
	    $count=0;
	    $query = mysql_query("SELECT lv.id, cp.id as sessao, pg.numero, cp.paginado FROM livros lv INNER JOIN capitulos cp ON cp.id_livro = lv.id INNER JOIN paginas pg ON pg.id_capitulo = cp.id WHERE lv.id = ${idLivro} ORDER BY cp.ordem ASC, pg.numero ASC");
	    while( $ln = mysql_fetch_assoc($query) ):
	      if($idSessao == $ln['sessao'] && $idPagina == $ln['numero'] && $ln['paginado'] == 'SIM'):
	        echo '<script>location.href="/adm/sj/index.php?op=mostra_livro&livro='.$ln['id'].'&sessao='.$ln['sessao'].'&pagina='.$ln['numero'].'&paginacao='.$count.'&b_palavra='.getParam('b_palavra').'&b_tipo='.getParam('b_tipo').'"</script>';
	        exit;
	      endif;
	      $count++;
	    endwhile;
	endif;
  endif;

  //---------------------------------------------------------------------------------------------------------

  $query = mysql_query("SELECT
                          lv.id,
                          lv.titulo,
                          lv.url_loja,
                          lv.ativo,
                          cp.id as id_sessao,
                          cp.numero as sessao,
                          cp.paginado,
                          pg.numero,
                          pg.texto,
                          pg.texto_pesquisa
                        FROM
                          grupos   gr
                          INNER JOIN topicos tp   ON tp.id_grupo = gr.id
                          INNER JOIN livros lv    ON lv.id_topico = tp.id
                          INNER JOIN capitulos cp ON cp.id_livro = lv.id
                          INNER JOIN paginas pg   ON pg.id_capitulo = cp.id
                        WHERE
                          (
                            (gr.id IN (".$_SESSION['login']['usuario']['todos_id_le'].") ) OR
                            (gr.id IN (".$_SESSION['login']['usuario']['todos_id_dep_a'].") AND gr.id NOT IN (".$_SESSION['login']['usuario']['todos_id_le'].") AND lv.compartilhado = 'S' )
                          ) AND
                          gr.ativo = 'S' AND
                          tp.ativo = 'S' AND
                          ${w}
                        ORDER BY cp.ordem ASC, pg.numero ASC
                        LIMIT 1") or die(mysql_error());

  if(mysql_num_rows($query)):

    $ln = mysql_fetch_assoc($query);
    $ln2 = $ln;

    if($ln['ativo'] == 'N'):
      echo '<script>';
        echo 'alert("Livro indisponínivel!");';
        echo 'var t = window.setTimeout("location.href=\'/adm/sj/index.php\'", 500);';
      echo '</script>';
      exit;
    endif;

    //-------------------------------------------------------------------------------------------------------

    $sql = 'SELECT
          cp.id, cp.numero as sessao
        FROM
          livros lv INNER JOIN capitulos cp ON cp.id_livro = lv.id
        WHERE lv.id = ' . $ln2['id'] . '
        ORDER BY cp.ordem ASC';
    $qrSessao = mysql_query($sql) or die(mysql_error());

    //-------------------------------------------------------------------------------------------------------

    if(in_array(PERMISSAO, array(ACESSO_PARCIAL, DEFAULT_ACESSO))):

      // Correções de espaços e caracteres residuais.
      //-----------------------------------------------------------------------------------------------------
      $texto = $ln['texto_pesquisa'];
      $texto = removCaracter($texto);
      $texto = removAcento($texto);

      $bTipo = getParam('b_tipo');
      if($bTipo != 'F')
        $pl = explode(' ', $palavra);
      else
        $pl = array($palavra);

      $found = 1;
      $ad = 0;
      foreach ($pl as $p):
        preg_match_all('/'.removAcento($p).'/i', ($texto), $ocorencias, PREG_OFFSET_CAPTURE);
        $ocs[] = $ocorencias;
        if(count($ocorencias)){
           foreach( $ocorencias[0] AS $pos ){
             $pos[1] += $ad;
             $selected = ($ocorencia == $found)? 'selected':'';
             $pre     = "<span class='highlight $selected'>";
             $texto2  = substr($texto, 0, $pos[1]).$pre.$p.'</span>';
             $texto2 .= substr($texto, ($pos[1]+strlen($p)));
             $texto  = $texto2;
             $ad += strlen($pre)+7;
             $found++;
          }
        }
      endforeach;

      $ocorencias=array();

      foreach($ocs as $oc):
        foreach($oc[0] as $o):
          array_push($ocorencias, $o);
        endforeach;
      endforeach;

      // Checa a ocorencia da palvra no texto
      //-----------------------------------------------------------------------------------------------------
      if(empty($ocorencias)):
        setFlashMessage('A página não contem a palavra procurada, você não tem permissão para visualizar completamento o livro!', 'warning');
        echo redirect2('/adm/sj/index.php');
        exit;
      endif;
    endif;

    if(PERMISSAO == DEFAULT_ACESSO):
      $totalOcorencia = count($ocorencias);
      $oc = (int) getParam('ocorencia');
      if($oc == 0):
        $currOcorencia      = 0;
        $currOcorenciaAnt   = 1;
        $currOcorenciaProx  = 2;
        $current            = 1;
      elseif($oc > $totalOcorencia):
        $currOcorencia      = $totalOcorencia;
        $currOcorenciaAnt   = $oc-1;
        $currOcorenciaProx  = $totalOcorencia;
        $current            = $currOcorencia;
      else:
        $current            = ($oc-1 == 0)? 1 : $oc;
        $currOcorencia      = $current-1;
        $currOcorenciaAnt   = ($oc-1 == 0)? 1 : $oc-1;
        $currOcorenciaProx  = ($oc+1 > $totalOcorencia )? $totalOcorencia : $oc+1;
      endif;
    else:
      $texto = $ln['texto'];
    endif;
?>
    <div class="page-header title-book">
      <h2><?=$ln['titulo'];?></h2>
    </div>
    <?php
      switch (PERMISSAO):
        case DEFAULT_ACESSO:
          require "partial/book/access_default.php";
          require "partial/book/description_book.php";
          break;
        case ACESSO_PARCIAL:
          require "partial/book/access_partial.php";
          require "partial/book/description_book.php";
          break;
        case ACESSO_TOTAL:
          require "partial/book/access_total.php";
          break;
      endswitch;
  else:
    require "partial/book/not_found.php";
  endif;
?>
<script>
  $(document).ready(function(){
    $('select[name="sessao"]').change(function(){
      location.href="/adm/sj/index.php?op=mostra_livro&livro=<?=$ln2['id'];?>&sessao=" + $(this).val() + "&b_palavra=<?=getParam('b_palavra')?>&b_tipo=<?=getParam('b_tipo')?>";
    });
    $('form[id="abrir-pagina"]').submit(function(event){
      event.preventDefault();
      var form = $(this);
      location.href="/adm/sj/index.php?op=mostra_livro&livro=<?=$ln2['id'];?>&sessao=" + form.find('select').val() + "&pagina=" + form.find('input').val() + "&b_palavra=<?=getParam('b_palavra')?>&b_tipo=<?=getParam('b_tipo')?>";
    });
  });
</script>
