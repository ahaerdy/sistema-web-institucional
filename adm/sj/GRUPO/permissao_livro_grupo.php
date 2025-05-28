<?php if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; } 
  (isset($_GET["pagina"])) ? $p = (int) $_GET["pagina"] : $p = 1;
  $qnt    = 50;
  $inicio   = ($p * $qnt) - $qnt;
  if(isset($_GET['op']  ) && !empty($_GET['op']   )){ $url[] = 'op='   . $_GET['op'];   }
  if(isset($_GET['grupo']  ) && !empty($_GET['grupo'] )){ $url[] = 'grupo=' . $_GET['grupo'];   }
  $urlPaginacao = implode('&', $url);
  $id_grupo = (int)$_GET['grupo'];
  if( !$id_grupo )
    msg('Grupo não encontrado!', 'danger');
  if( !empty($_POST) && !empty($_GET['grupo']) && !empty($_POST['submit_permissao'])):
    foreach ($_POST['permissao'] as $key => $value):
      $res = mysql_query("SELECT id FROM tbl_livro_permissao WHERE id_grupo = ${id_grupo} AND id_livro = ${key}") or die ( mysql_error() );
      if( mysql_num_rows($res) == 0 )
        mysql_query( "INSERT INTO tbl_livro_permissao (id_grupo, id_livro, permissao) VALUES ('${id_grupo}', '${key}', '${value}')" ) or die ( mysql_error() );
      else
        mysql_query( "UPDATE tbl_livro_permissao SET permissao = '${value}' WHERE id_grupo = ${id_grupo} AND id_livro = ${key}" ) or die ( mysql_error() );
    endforeach;
    setFlashMessage('Permissão alterada com sucesso!', 'success');
    echo redirect2('index.php?op=lis_grup');
    exit;
  else:
?>
    <div class="box left box-w756px">
      <div class="box-esp">
        <div class="tit-azul">Permissões de livros (Para acesso por grupos compartilhados)</div>
        <div class="h20px"></div>
        <div class="box-content">
            <table class="table table-striped">
              <thead>
                <tr>
                  <td colspan='5'>
                    <div class="right">
                      <form action="<?=$_SERVER['REQUEST_URI']?>" method="get" id="pesquisa">
                        <input type="hidden" name="op" value="permissao_livro_grupo">
                        <input type="hidden" name="grupo" value="<?=$id_grupo;?>">
                        <input type="text" name="nome" value="<?=$_GET['nome'];?>" placeholder="Pesquisar Livro">
                        <input type="image" src="http://cdn5.iconfinder.com/data/icons/glyph_set/16/search.png" style="background: #f2f2f2; margin-bottom: -6px;">
                      </form>
                    </div>
                  </td>
                </tr>
              </thead>
              <form method="post" action="<?=$_SERVER['REQUEST_URI'];?>" id="form">
                <tr>
                  <th width="10%">Grupo</th>
                  <th width="10%">Tópico</th>
                  <th>Livro</th>
                  <th width="180">Permissão</th>
                </tr>
                <tbody>
                  <?php
                    if( !empty($_GET['nome']) )
                    {
                      if(!empty($_GET['nome'])){ $w[] = 'lv.titulo like"%' . $_GET['nome'] . '%"'; }
                      $w = implode(' AND ', $w) . ' AND ';
                    }
                    $sql = "SELECT
                              gp.nome as grupo,
                              tp.nome as topico,
                              lv.id,
                              lv.titulo,
                              lp.permissao
                            FROM
                              grupos gp
                              INNER JOIN topicos tp ON tp.id_grupo = gp.id 
                              INNER JOIN livros lv ON  lv.id_topico = tp.id
                              LEFT JOIN tbl_livro_permissao lp ON lp.id_livro = lv.id AND lp.id_grupo = ${id_grupo}
                            WHERE
                              $w gp.id = ${id_grupo}";
                    $sql_paginacao = str_replace(strstr($sql, 'LIMIT'), '', $sql);
                    $res = mysql_query($sql) or die( mysql_error() );
                    while( $ln = mysql_fetch_assoc($res) ):
                  ?>
                      <tr>
                        <td><?=$ln['grupo'];?></td>
                        <td><?=$ln['topico'];?></td>
                        <td><?=$ln['titulo'];?></td>
                        <td>
                          TL  <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == 'T')?  'checked="checked"' : ''; ?> value="T" title="TOTAL">
                          PC  <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == 'P')?  'checked="checked"' : ''; ?> value="P" title="PARCIAL">
                          TR  <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == 'TR')? 'checked="checked"' : ''; ?> value="TR" title="TRECHO">
                          PCL <input type="radio" name="permissao[<?=$ln['id'];?>]" <?=($ln['permissao'] == '')? 'checked="checked"' : ''; ?> value="" title="PERMISSÃO PELO CADASTRO DO LIVRO">
                        </td>
                      </tr>
                  <? endwhile; ?>
                </tbody>
              <tfoot>
                <tr>
                  <td colspan='5'><br/><input type="submit" name="submit_permissao" value="Salvar Permissão"><br/><br/></td>
                </tr>
              </tfoot>
              </form>
            </table>
            <?php require('paginacao_sql.php'); ?>
        </div>
      </div>
    </div>    
<? endif; ?>