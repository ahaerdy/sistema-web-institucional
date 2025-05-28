<link rel="stylesheet" type="text/css" href="/adm/sj/js/slider/css/lightbox.css"/>
<?php
  if(empty($_SESSION['login']['usuario']['todos_id_us'])){ echo 'Acesso negado!'; exit; }
  $iGaleria = (!empty($_GET['galeria']) && (int)$_GET['galeria']) ? (int)$_GET['galeria'] : exit; 
  $res = mysql_query("SELECT 
                        gp.diretorio as gp_diretorio,
                        tp.diretorio as tp_diretorio,
                        gl.diretorio as gl_diretorio,
                        gl.id        as gl_id,
                        gl.titulo    as gl_titulo,
                        gl.descricao as gl_descricao,
                        DATE_FORMAT(gl.cadastro,'%d/%m/%Y') AS gl_cadastro,
                        ft.foto,
                        ft.ordem,
                        ft.comentario,
                        ft.cadastro as ft_cadastro
                      FROM 
                        grupos   gp
                        INNER JOIN topicos  tp ON  tp.id_grupo = gp.id
                        INNER JOIN galerias gl ON  gl.id_topico = tp.id
                        INNER JOIN fotos    ft ON  ft.galerias_id = gl.id
                      WHERE
                        ((gp.id IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") ) OR 
                        ( gp.id IN (" . $_SESSION['login']['usuario']['todos_id_dep_a'] . ") AND gp.id NOT IN (" . $_SESSION['login']['usuario']['todos_id_le'] . ") AND gl.compartilhado = 'S' )) AND 
                        gl.id = ${iGaleria} AND 
                        gp.ativo = 'S' AND 
                        tp.ativo = 'S' AND 
                        gl.ativo = 'S'
                      ORDER BY ordem ASC");
  if(mysql_num_rows($res)):
    $params['usuario_id'] = getIdUsuario();
    $params['galeria_foto_id'] = getParam('galeria');
    setLogAtividade($params);
    require "partial/photo/description.php";
    echo '<div class="spacing"></div>';
    require "partial/photo/slider.php";
  else: 
    echo '<h3 class="text-center">Não há conteúdo disponível.</h3>';
  endif; 
?>