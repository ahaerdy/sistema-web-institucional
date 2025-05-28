<?php
	if (empty ( $_SESSION ['login'] ['usuario'] ['todos_id_us'] )) {
		echo 'Acesso negado!';
		exit ();
	}

	$iLivro = (! empty ( $_GET ['livro'] ) && ( int ) $_GET ['livro']) ? ( int ) $_GET ['livro'] : exit ();

	$res = mysql_query ( "SELECT 
    						gr.nome 	 as grupo,
    						tp.nome 	 as topico,
							lv.*,
							DATE_FORMAT(lv.cadastrado,'%d/%m/%Y') AS cadastrado
						 FROM 
							grupos   gr,
							topicos  tp, 
							livros 	 lv 
						WHERE
							gr.id = tp.id_grupo
							AND
                            lv.id = $iLivro
                            AND
                            lv.id_topico = tp.id
                            AND
                            tp.id_grupo in (" . $_SESSION ['login'] ['usuario'] ['todos_id_us'] . ")
						" ) or die ( mysql_error () );
						
	if (mysql_num_rows ( $res ))
	{
		$ln = mysql_fetch_assoc ( $res );
?>
		<div class="box">
			<div class="box-esp">
				<div class="tit-laranja">
					LIVRO | Dados Técnicos
				</div>

				<div class="h20px"></div>

				<div class="box-content">
				
					<div class="right">
						<div class="left label-livro">
							<a href="/adm/sj/index.php?op=mostra_livro&livro=<?=(int)$_GET['livro'];?>">Acessar 1° página</a>
						</div>
					</div>
					
					<div class="clear"></div>
				
					<div class="box-row-input">
						<label class="c-titulo">Título:</label>
						<div class="campo"><?=$ln['titulo'];?></div>
					</div>
					<div class="box-row-input">
						<label class="c-titulo">Prefácio:</label>
						<div class="campo"><?=$ln['descricao'];?></div>
					</div>
					<div class="box-row-input">
						<label class="c-titulo">Autor:</label>
						<div class="campo"><?=$ln['autor'];?></div>
					</div>
					<div class="box-row-input">
						<label class="c-titulo">Revisão:</label>
						<div class="campo"><?=$ln['revisao'];?></div>
					</div>
					<div class="box-row-input">
						<label class="c-titulo">ISBN:</label>
						<div class="campo"><?=$ln['isbn'];?></div>
					</div>
			    	<div class="box-row-input">
						<label class="c-titulo">Grupo:</label>
						<div class="campo"><?=$ln['grupo'];?></div>
					</div>
					<div class="box-row-input">
						<label class="c-titulo">Tópico:</label>
						<div class="campo"><?=$ln['topico'];?></div>
					</div>
					<div class="box-row-input">
						<label class="c-titulo">Compre este livro:</label>
						<div class="campo">
							<a href="<?=$ln['url_loja'];?>" target="_blank"><?=$ln['url_loja'];?></a>
						</div>
					</div>
		
					<div class="clear h20px"></div>
				</div>
			</div>
		</div>
<?php
	}
?>
				