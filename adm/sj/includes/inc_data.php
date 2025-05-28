<?php
    if(empty($_SESSION['login'][$_SESSION['login']['tipo']]['todos_id_us'])){ echo 'Acesso negado!'; exit; }

	$data = date('Y-m-d H:i:s');
	setlocale(LC_ALL, "pt_BR", "ptb");
    $data=strftime("%A %d de %B de %Y", strtotime($data));
	$data=ucfirst($data);
    echo utf8_encode($data);
?>

