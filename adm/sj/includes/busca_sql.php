<?php
$buscar = getParam('buscar');
$b_palavra = getParam('b_palavra');
$b_grupo = (int) getParam('b_grupo');
$b_assunto = (int) getParam('b_assunto');
$b_topico = (int) getParam('b_topico');
$b_sub_topico = (int) getParam('b_sub_topico');
$b_categoria = getParam('b_categoria');
$b_tipo = getParam('b_tipo');
$sessao = (int) getParam('sessao');
$ordem_sessao = getParam('ordem_sessao');
$ordem_grupo = getParam('ordem_grupo');
$ordem_topico = getParam('ordem_topico');
$ordem_titulo = getParam('ordem_titulo');
$ordem_cadastro = getParam('ordem_cadastro');
$op = getParam('op');
$pagina = (int) getParam('pagina');

if(isset($buscar) && $buscar == 'Buscar')
{
	// VALIDAÇÃO DE DADOS
	if(empty($b_palavra)):
		if(!isset($b_grupo) || !isset($b_topico) || !isset($b_categoria) || !isset($b_tipo)):
			if(empty($b_palavra)):
				echo redirect2('/adm/sj/index.php?op=bus_conteu');
				exit;
			endif;
		else:
			if( (empty($b_categoria) || empty($b_tipo)) || (empty($b_grupo) && empty($b_palavra))):
				echo redirect2('/adm/sj/index.php?op=bus_conteu');
				exit;
			endif;
		endif;
	endif;

	if($b_sub_topico):
		$b_topico = (int) $b_sub_topico;
	elseif($b_topico):
		$b_topico = (int) $b_topico;
	elseif($b_assunto):
		$b_topico = (int) $b_assunto;
	endif;

	
	// PALAVRAS
	$w   = array();
	$w1  = array();
	$w2  = array();
	$w3  = array();
	$w4  = array();
	$wh  = array();
	$wh1 = array();
	$wh2 = array();
	$wh3 = array();
	$wh4 = array();
	$wh5 = array();

	$b_tipo    = ( $b_tipo    != '' ) ? trim(addslashes(strip_tags($b_tipo))) :  'P'; // TIPO DE PESQUISA
	$b_palavra = ( $b_palavra != '' ) ? trim(addslashes(strip_tags($b_palavra))) : ''; // PALAVRA OU FRASE
	$b_palavra = str_replace(array('  ', '   '), ' ', $b_palavra);

	if(!empty($b_grupo)):
		$w1[] = $w[] = addslashes(strip_tags('gp.id = ' . (int) $b_grupo));
		$grupoTodos = (int) $b_grupo;
		$grupoLe    = (int) $b_grupo;
	else:
		$grupoTodos = $_SESSION['login']['usuario']['todos_id_us'];
		$grupoLe    = $_SESSION['login']['usuario']['todos_id_le'];
	endif;

	
	if(!empty($b_topico))
		$w1[] = $w[] = addslashes(strip_tags('tp.id = ' . $b_topico));
	
	if(!empty($b_palavra)):
		if($b_tipo == 'F' && $b_palavra): // BUSCA POR FRASE
		$w[]  = "(at.titulo         LIKE '%".$b_palavra."%' OR at.texto_pesquisa LIKE '%".$b_palavra."%')";
		$w1[] = "(gl.titulo         LIKE '%".$b_palavra."%' OR gl.descricao LIKE '%".$b_palavra."%')";
		$w2[] = "(lv.titulo         LIKE '%".$b_palavra."%')";
		$w3[] = "(cp.descricao      LIKE '%".$b_palavra."%')";
		$w4[] = "(pg.texto_pesquisa LIKE '%".$b_palavra."%')";
		$w   = implode(' AND ', $w);
		$w1 = implode(' AND ', $w1);
		$w2 = implode(' AND ', $w2);
		$w3 = implode(' AND ', $w3);
		$w4 = implode(' AND ', $w4);
		else:
			$pl = explode(' ', $b_palavra);
			foreach($pl as $ln):
				$wh[]  = "(at.titulo LIKE '%${ln}%' OR at.texto     LIKE '%${ln}%')";
				$wh1[] = "(gl.titulo LIKE '%${ln}%' OR gl.descricao LIKE '%${ln}%')";
				$wh2[] = "(lv.titulo LIKE '%${ln}%')";
				$wh3[] = "(cp.descricao LIKE '%${ln}%')";
				$wh4[] = "(pg.texto_pesquisa LIKE '%${ln}%')";
			endforeach;
			if($b_tipo == 'P'): // BUSCA POR PALAVRA
				$w  =  '('.implode(' OR ', $wh).')';
				$w1 = '('.implode(' OR ', $wh1).')';
				$w2 = '('.implode(' OR ', $wh2).')';
				$w3 = '('.implode(' OR ', $wh3).')';
				$w4 = '('.implode(' OR ', $wh4).')';
			elseif($b_tipo == 'I'):
				$w[]  = implode(' AND ', $wh);
				$w1[] = implode(' AND ', $wh1);
				$w2[] = implode(' AND ', $wh2);
				$w3[] = implode(' AND ', $wh3);
				$w4[] = implode(' AND ', $wh4);
				$w  = '('.implode(' AND ', array_merge($w,  $wh)).')';
				$w1 = '('.implode(' AND ', array_merge($w1, $wh1)).')';
				$w2 = '('.implode(' AND ', array_merge($w2, $wh2)).')';
				$w3 = '('.implode(' AND ', array_merge($w3, $wh3)).')';
				$w4 = '('.implode(' AND ', array_merge($w4, $wh4)).')';
			endif;
		endif;
		$groupByBookId = '';
		if(!empty($b_topico)):
			$wT = "(tp.id = ${b_topico}) AND ";
		endif;
	else:
		$w = $w1 = $w2 = $w3 = $w4 = implode(' AND ', $w);
		$groupByBookId = ' GROUP BY lv.id';
	endif;

	$sql1 = "SELECT
				'Artigos' as tipo,
				gp.nome as grupo,
				tp.nome as topico,
				at.id,
				at.titulo,
				'' as capitulo,
				'' as pagina,
				'' as lv_permissao,
				'' as lp_permissao,
				DATE_FORMAT(at.cadastro, '%d/%m/%Y') AS cadastro
			FROM
				grupos as gp
			INNER JOIN topicos as tp ON tp.id_grupo  = gp.id
			INNER JOIN artigos as at ON at.id_topico = tp.id
			WHERE
				( ( gp.id IN (${grupoLe}) ) OR ( gp.id IN (${grupoTodos}) AND gp.id NOT IN (${grupoLe}) AND at.compartilhado = 'S') ) AND
				gp.ativo = 'S' AND
				tp.ativo = 'S' AND
				at.ativo = 'S' AND
				$w";

	$sql2 = "SELECT
				'Fotos' as tipo,
				gp.nome as grupo,
				tp.nome as topico,
				gl.id,
				gl.titulo,
				'' as capitulo,
				'' as pagina,
				'' as lv_permissao,
				'' as lp_permissao,
				DATE_FORMAT(gl.cadastro, '%d/%m/%Y') AS cadastro
			FROM
				grupos as gp
			INNER JOIN topicos  as tp ON tp.id_grupo  = gp.id
			INNER JOIN galerias as gl ON gl.id_topico = tp.id
			WHERE
				( ( gp.id IN (${grupoLe}) ) OR ( gp.id IN (${grupoTodos}) AND gp.id NOT IN (${grupoLe}) AND gl.compartilhado = 'S') ) AND
				gp.ativo = 'S' AND
				tp.ativo = 'S' AND
				gl.ativo = 'S' AND
				$w1";

	$sql3 = "SELECT
				'Vídeos' as tipo,
				gp.nome as grupo,
				tp.nome as topico,
				gl.id,
				gl.titulo,
				'' as capitulo,
				'' as pagina,
				'' as lv_permissao,
				'' as lp_permissao,
				DATE_FORMAT(gl.cadastro, '%d/%m/%Y') AS cadastro
			FROM
				grupos as gp
			INNER JOIN topicos        as tp ON tp.id_grupo  = gp.id
			INNER JOIN galerias_video as gl ON gl.id_topico = tp.id
			WHERE
				( ( gp.id IN (${grupoLe}) ) OR ( gp.id IN (${grupoTodos}) AND gp.id NOT IN (${grupoLe}) AND gl.compartilhado = 'S') ) AND
				gp.ativo = 'S' AND
				tp.ativo = 'S' AND
				gl.ativo = 'S' AND
				$w1";

	$sql4 = "SELECT
				'Livros' as tipo,
				gp.nome as grupo,
				tp.nome as topico,
				lv.id,
				lv.titulo,
				cp.id as capitulo,
				pg.numero as pagina,
				lv.permissao as lv_permissao,
				lp.permissao as lp_permissao,
				DATE_FORMAT(lv.cadastrado, '%d/%m/%Y') AS cadastro
			FROM
				grupos as gp
			INNER JOIN topicos   as tp ON tp.id_grupo    = gp.id
			INNER JOIN livros    as lv ON lv.id_topico   = tp.id
			INNER JOIN capitulos as cp ON cp.id_livro    = lv.id
			INNER JOIN paginas   as pg ON pg.id_capitulo = cp.id
			LEFT JOIN tbl_livro_permissao lp ON lp.id = ( SELECT
																id
															FROM
																tbl_livro_permissao lp2
															WHERE
																lp2.id_livro = lv.id AND (lp2.id_usuario = ".getIdUsuario()." OR lp2.id_grupo = gp.id)
															ORDER BY
																lp2.id_usuario IS NULL ASC
															LIMIT 1)
			WHERE
				$wT ( ( gp.id IN (${grupoLe}) ) OR ( gp.id IN (${grupoTodos}) AND gp.id NOT IN (${grupoLe}) AND lv.compartilhado = 'S') ) AND
				gp.ativo = 'S' AND
				tp.ativo = 'S' AND
				lv.ativo = 'S' AND
				cp.paginado = 'SIM' AND
				($w2) GROUP BY lv.id $groupByBookId UNION ";

	$sql4 .= "SELECT
				'Livros' as tipo,
				gp.nome as grupo,
				tp.nome as topico,
				lv.id,
				lv.titulo,
				cp.id as capitulo,
				pg.numero as pagina,
				lv.permissao as lv_permissao,
				lp.permissao as lp_permissao,
				DATE_FORMAT(lv.cadastrado, '%d/%m/%Y') AS cadastro
			FROM
				grupos as gp
			INNER JOIN topicos   as tp ON tp.id_grupo    = gp.id
			INNER JOIN livros    as lv ON lv.id_topico   = tp.id
			INNER JOIN capitulos as cp ON cp.id_livro    = lv.id
			INNER JOIN paginas   as pg ON pg.id_capitulo = cp.id
			LEFT JOIN tbl_livro_permissao lp ON lp.id = ( SELECT
																id
															FROM
																tbl_livro_permissao lp2
															WHERE
																lp2.id_livro = lv.id AND (lp2.id_usuario = ".getIdUsuario()." OR lp2.id_grupo = gp.id)
															ORDER BY
																lp2.id_usuario IS NULL ASC
															LIMIT 1)
			WHERE
				$wT ( ( gp.id IN (${grupoLe}) ) OR ( gp.id IN (${grupoTodos}) AND gp.id NOT IN (${grupoLe}) AND lv.compartilhado = 'S') ) AND
				gp.ativo = 'S' AND
				tp.ativo = 'S' AND
				lv.ativo = 'S' AND
				cp.paginado = 'SIM' AND
				($w4) $groupByBookId";
	$odr = ', id ASC, ABS(pagina)';

	switch($b_categoria):
		case 'A':
			$sql = $sql1;
			break;
		case 'F':
			$sql = $sql2;
			break;
		case 'V':
			$sql = $sql3;
			break;
		case 'L':
			$sql = $sql4;
			break;
		default:
			$sql = "${sql1} UNION ALL ${sql2} UNION ALL ${sql3} UNION ALL ${sql4}";
	endswitch;

	// PAGINACAO PARAMETROS
	$qnt = QTD_ITEM_PAGINATOR;
	$paramsPaginator = getPaginatorCalc('pagina', $qnt);
	$currentPageNumber = $paramsPaginator['current_page_number'];
	$start = $paramsPaginator['start'];

	$orderParam = getOrderByParamUrl('ordem_sessao', 'tipo', 'A');
	$ordem_sessaoParametro = $orderParam['order'];
	$ordemSQL[] = $orderParam['fieldSql'];
	$orderParam = getOrderByParamUrl('ordem_grupo', 'grupo', 'A');
	$ordem_grupoParametro = $orderParam['order'];
	$ordemSQL[] = $orderParam['fieldSql'];
	$orderParam = getOrderByParamUrl('ordem_topico', 'topico', 'A');
	$ordem_topicoParametro = $orderParam['order'];
	$ordemSQL[] = $orderParam['fieldSql'];
	$orderParam = getOrderByParamUrl('ordem_titulo', 'titulo', 'A');
	$ordem_tituloParametro = $orderParam['order'];
	$ordemSQL[] = $orderParam['fieldSql'];
	$orderParam = getOrderByParamUrl('ordem_cadastro', 'cadastro', 'A');
	$ordem_cadastroParametro = $orderParam['order'];
	$ordemSQL[] = $orderParam['fieldSql'];
	$ordemSQL = getOrder($ordemSQL,'grupo ASC, topico ASC, titulo ASC, cadastro DESC');

	// Monta URl
	$url = getUrlParams(array('ordem_sessao', 'ordem_grupo', 'ordem_topico', 'ordem_titulo', 'ordem_cadastro'));
	$urlCompleta = getUrl($url);
	$url = getUrlParams(array('pagina'));
	$urlPaginacao = getUrl($url);

	$order = "ORDER BY FIELD(tipo, \"Artigos\", \"Fotos\", \"Vídeos\", \"Livros\"), ${ordemSQL} ${odr}";
	$limit = "LIMIT ${start}, ${qnt}";
}
?>
