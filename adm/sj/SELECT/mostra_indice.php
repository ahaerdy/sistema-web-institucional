<?php
if (empty ( $_SESSION ['login'] ['usuario'] ['todos_id_us'] )) {
	echo 'Acesso negado!';
	exit ();
}

$iLivro = (! empty ( $_GET ['livro'] ) && ( int ) $_GET ['livro']) ? ( int ) $_GET ['livro'] : exit ();
?>

<div class="box">
	<div class="box-esp">
		<div class="tit-laranja">
			LIVRO | Índice
		</div>

		<div class="h20px"></div>

		<div class="box-content">
		
			<div class="right">
				<div style="padding: 5px; background: #F2F2F2; border: 1px solid #A6BBC6; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; margin-right: 10px;" class="left">
					<a href="/adm/sj/index.php?op=mostra_prefacio&livro=<?=(int)$_GET['livro'];?>"><img src="http://cdn2.iconfinder.com/data/icons/diagona/icon/16/164.png" class="left" style="margin-right: 10px"/>Acessar Prefácio</a>
				</div>
				<div style="padding: 5px; background: #F2F2F2; border: 1px solid #A6BBC6; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;" class="left">
					<a href="/adm/sj/index.php?op=mostra_livro&livro=<?=(int)$_GET['livro'];?>"><img src="http://cdn4.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/list_num.png"  class="left" style="margin-right: 10px"/>Acessar 1° página</a>
				</div>
			</div>
			
			<div class="clear"></div>

			<table width="100%" border="0" class="livro-indice">
				<?php
					$sql = 'SELECT 
								lv.id as id_livro,
								lv.titulo,
								lv.descricao,
								cp.id as id_capitulo,
								cp.numero as num_capitulo,
								cp.descricao,
								cp.pagina_inicial
							FROM
							    livros lv,
							    capitulos cp
								WHERE
								lv.id = ' . $iLivro . '
								AND
							    lv.id = cp.id_livro
							ORDER BY num_capitulo ASC';
	
					$query = mysql_query($sql) or die( mysql_error() );
	
					while($ln = mysql_fetch_assoc($query))
					{
						if($i++ == 0)
						{
							echo '<tr>';
								echo '<td colspan="2" style="border: 0;"><b>Livro: </b>'.$ln['titulo'].'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td colspan="2" style="border: 0;"><b>Prefácio: </b>'.$ln['descricao'].'</td>';
							echo '</tr>';
							echo '<tr>';
							echo '<td colspan="2"><br/></td>';
							echo '</tr>';
						}

						echo '<tr>';
							echo '<td colspan="2" style="border: 0;"><b>Capítulo: '.$ln['num_capitulo'].'</b></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td><li><a href="/adm/sj/index.php?op=mostra_livro&livro='.$ln['id_livro'].'&capitulo='.$ln['num_capitulo'].'&pagina='.$ln['pagina_inicial'].'">'.$ln['descricao'].'</a></li></td>';
							echo '<td><a href="/adm/sj/index.php?op=mostra_livro&livro='.$ln['id_livro'].'&capitulo='.$ln['num_capitulo'].'&pagina='.$ln['pagina_inicial'].'">'.$ln['pagina_inicial'].'</a></td>';
						echo '</tr>';
					}
				?>
			</table>

		</div>

	</div>

</div>