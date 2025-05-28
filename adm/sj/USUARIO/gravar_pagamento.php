<?
require('../../config.inc.php');
Conectar();

$mes		= $_POST['requiredmes'];
$valor		= $_POST['requiredvalor'];
$cod_usu	= $_POST['COD_USUARIO'];
$id_usu		= $_POST['ID_USUARIO'];

$mes = str_replace('/', '-', $mes);

					
$insere = @mysql_query("INSERT INTO mensalidade (cod_usuario,cadastro,id_usuario,valor,data) 
						values 
						('$cod_usu',NOW(),'$id_usu','$valor',STR_TO_DATE('$mes', '%d-%m-%Y'))") or die ("ERRO");						
						
			
						if($insere >='1'){
							echo "<script language=javascript>alert(\"PAGAMENTO CADASTRADO SUCESSO !!!\");</script> ";
							echo("<script>window.location.href='../index.php?op=lis_usu';</script>");
						}
						else{
							echo "<script language=javascript>alert(\"ERRO CADASTRAR PAGAMENTO !!!\");</script> ";
							echo("<script>window.location.href='../index.php?op=lis_usu';</script>");
						}

?>