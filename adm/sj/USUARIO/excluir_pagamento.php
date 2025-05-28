<?
$id_mensa = $_GET["op1"];



$delete_topicos = @mysql_query("DELETE FROM mensalidade where id='$id_mensa'")  or die (mysql_error());


echo "<script language=javascript>alert(\"MENSALIDADE DELETADO COM SUCESSO !!!\");</script> ";
echo("<script>window.location.href='index.php?op=lis_usu';</script>");

?>