<?				
	if ($id_usuario == '1'){
		$todos_dados = mysql_query("select
									A.id as QUADRO,
									A.opcao,
									A.subopcao,
									A.titulo as tt_quadro,
									A.texto as tex_quadro,
									B.id,
									B.situacao,
									B.id_topico,
									C.id_grupo,
									B.titulo,
									B.texto, 
									B.situacao,
									DATE_FORMAT(B.cadastro, '%d/%m/%Y') AS datas
									FROM
									quadros A
									JOIN
									artigos B
									on	A.opcao	   = 'Artigo'
									and	A.subopcao = B.id
									and	B.situacao <> 'B'
									LEFT JOIN 	
									topicos C
									on  B.id_topico = C.id
									GROUP BY
									A.id,
									A.opcao,
									A.subopcao,
									A.titulo,
									A.texto,
									B.id,
									B.situacao,
									B.id_topico,
									C.id_grupo,
									B.titulo,
									B.texto, 
									B.situacao,
									B.cadastro");
									while ($row_ttl_dd = mysql_fetch_array($todos_dados, MYSQL_ASSOC)) {//ABRIL	
										$ttl_situacao	=($row_ttl_dd['situacao']);
										$ttl_id			=($row_ttl_dd['QUADRO']);
										$ttl_titulo		=($row_ttl_dd['titulo']);
										$ttl_texto		=($row_ttl_dd['texto']);
										$ttl_data		=($row_ttl_dd['datas']);
										$tt_quadro		=($row_ttl_dd['tt_quadro']);
										$tt_texto		=($row_ttl_dd['tex_quadro']);
										
										$contador++;
										if($cont=='2'){
											$cont='0';	
											$tr1='<tr>';
											$tr2='<tr>';
										}	

?>

                <div class="left"><? echo $tt_quadro;?></div>
				<div class="right bold f10px">
					Postado: <? echo $ttl_data . ' | ' . $contador;?>
				</div>

				<div class="clear h20px"></div>

                <h2><?=$tt_texto;?></h2>
                <b>Artigo:</b> <?=$ttl_titulo;?>
                
                <div class="clear h20px"></div>
                
                <div class="justificado">
                	<b>Informação:</b>
                	<div class="h20px"></div>
                	<?=$ttl_texto;?>
                </div>
                
                <div class="clear h20px"></div>
    
                <div class="bar-tool">
					<a href="index.php?op=alte_quad&op1=<?echo $ttl_id;?>">Alterar</a>
					<a class="red" href="?op=exclui_quadro&op1=<?=$ttl_id?>" title="Excluir Quadros" onclick="return confirm( 'Deseja realmente excluir Quadro? ' );">Excluir</a>	
                </div>	
<?
            } // while
    }else{ // não é administrador	

		$busca_dados = mysql_query("select
									A.id as QUADRO,
									A.titulo as ttl_quadro,
									A.texto as texto_quadro,
									A.opcao,
									A.subopcao,
									B.id,
									B.situacao,
									B.id_topico,
									C.id_grupo,
									B.titulo,
									B.texto, 
									B.situacao,
									DATE_FORMAT(B.cadastro, '%d/%m/%Y') AS datas
									from
									quadros A
									JOIN
									artigos B
									on	A.opcao	   = 'Artigo'
									and	A.subopcao = B.id
									and	B.situacao <> 'B'
									LEFT JOIN 	
									topicos C
									on  B.id_topico = C.id
									and C.id_grupo !='1'
									JOIN
									dependente D
									on  C.id_grupo in ($todos_id_dep_a)
									GROUP BY
									A.id,
									A.titulo,
									A.texto,
									A.opcao,
									A.subopcao,
									B.id,
									B.situacao,
									B.id_topico,
									C.id_grupo,
									B.titulo,
									B.texto, 
									B.situacao,
									B.cadastro");
									
		if($busca_dados){
		
			while ($row_dados = mysql_fetch_array($busca_dados, MYSQL_ASSOC)) {
				$ttl_artigo	=($row_dados['titulo']);
				$tx_artigo	=($row_dados['texto']);
				$datas_art	=($row_dados['datas']);
				$id_art		=($row_dados['QUADRO']);
				$ttl_quad	=($row_dados['ttl_quadro']);
				$texto_quad	=($row_dados['texto_quadro']);
				$contador++;
			?>
	
	
            <table width='100%' style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 90%; font-size:90%; margin:0; border: 2px solid #C7D0F8;">
                <tr>
                    <td>
                        <table width="100%" border="0"  bgcolor="#cedff2" cellspacing="0" cellpadding="2" height="90%">
                            <tr>
                                <td  width="70%" align="left">
                                    <font color="#3333FF"><?echo $ttl_artigo;?></font>
                                </td>
                                <td  width="20%" align="center">
                                    <font size='1.5px' color="#FF0000"><B>POSTADO:</font><font size='1.5px'>&nbsp;<B><?echo $datas_art;?></B></font>
                                </td>
                                <td  width="10%"  align="center">
                                    <font size='0.1px'><B><?echo $contador;?></B></font>
                                </td>
                            </tr>
                        </table>
                        
                        <table>
                            <tr>	
                                <td width='90%' align="center">
                                    <font><?echo $tx_artigo;?></font>
                                </td>
                            </tr>		
                        </table>


        
                        <table width='90%'> 
                            <tr>
                                <td>
                                    <HR color="#cedff2">
                                </td>
                            </tr>
                            
                            <tr>
                                <td width='90%' align="center">
                                    <font size='0.1px'><B>Evento :<?echo $ttl_artigo;?></B></font>
                                </td>
    
                            </tr>
    

                            <tr>	
                                <td>	
                                    <font size='1' face='tahoma'><B>Informação :</B><?echo $tx_artigo;?></font>
                                </td>
                            </tr>												
                            
                        </table>

                        <table width='90%'>
                            <tr>
                                <td align="center">
                                    <a href="index.php?op=alte_quad&op1=<?echo $id_art;?>"><font size='1.5px'>Alterar</font></a>
                                    &nbsp;|&nbsp;

                                    <a href="?op=exclui_quadro&op1=<?=$id_art?>" title="Excluir Quadros" onclick="return confirm( 'Deseja realmente excluir Quadro? ' );"><font size='1.5px' color="#FF0000">Excluir</font></a>	
                                </td>
                            </tr>
                        </table>	
                    </td>
                </tr>
            </table>
<?
        } // fecha while
    } // fecha if
}
?>