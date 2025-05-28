<?php
if(empty($_SESSION['login']['admin']['todos_id_us'])){ echo 'Acesso negado!'; exit; }

$galeria = $_GET["op1"];

$res = mysql_query("SELECT titulo, DATE_FORMAT(cadastro, '%d/%m/%Y') AS data FROM  galerias_videos  WHERE  id = '$galeria'");
$ln  = mysql_fetch_array($res);
?>

<div>
	<table width="100%">
		<tr style="background-color: #cedff2;width:80%;">
			<td style="float:left;"><font color="#3333FF" face="arial" size="2"><b>Galeria de Fotos: <?= $ln['titulo'] ?> </b></font></td>
			<td style="float:rigth;width:20%;"><font color="#3333FF" face="arial" size="2"><b> <?= $ln['data']	?> </b></font></td>
		</tr>
	</table>
</div>
<div>
	<ul>
		<?php
            $sql_dir = mysql_query("SELECT gr.diretorio as d_grupo, t.diretorio as d_topico, ga.diretorio as d_galeria, ga.id_topico, ga.titulo FROM  grupos gr, topicos t, galerias_videos ga  WHERE  ga.id = " . $galeria . " AND gr.id = t.id_grupo AND t.id = ga.id_topico");
            
            $res = mysql_fetch_assoc($sql_dir);
            
            $diretorio = "/public/" . $res["d_grupo"] . "/topicos/" . $res["d_topico"] . "/videos/" . $res["d_galeria"] . "/";
        
			$sql_foto = mysql_query("SELECT id, galerias_id, foto, comentario FROM  videos  WHERE  galerias_id = '$galeria'");
			
			while($ln = mysql_fetch_array($sql_foto))
			{
				$id	        = $ln['id'];
				$foto 		= $ln['foto'];
				$comentario = $ln['comentario'];
		?>
				<div align="center" style="width:270px; float:left; padding:10px; text-align:left; list-style-type:none;">
					<li id="gallery" style="width:150px; float:left; background:#efefef; padding:10px 10px 0 10px;"> <a href="<?php echo $diretorio.$foto;?>" title="<?php echo $comentario;?>"> <img src="<?php echo $diretorio."thumb_".$foto;?>" width="150"  alt="" /> </a> </li>
					<br />
					<?=$comentario;?>
				</div>
		<?php 
			}
      	?>
	</ul>
</div>
