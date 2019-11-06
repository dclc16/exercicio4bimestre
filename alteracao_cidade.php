<?php
	include("conexao.php");
	
	$id = $_POST["id"];
	$nome = $_POST["nome"];
	
	$update = "UPDATE cidade SET nome = '$nome' WHERE id_cidade = $id";
	
	mysqli_query($conexao, $update) or die("0" .mysqli_error($conexao));
	
	echo "1";
?>