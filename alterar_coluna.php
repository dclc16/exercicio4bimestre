<?php
	include("conexao.php");
	
	$coluna = $_POST["coluna"];
	$valor = $_POST["valor"];
	$id = $_POST["id"];
	$tabela = $_POST["tabela"];
	
	if($tabela == 'cadastro'){
		$update = "UPDATE cadastro SET $coluna = '$valor' WHERE id_cadastro = '$id'";
	}elseif($tabela == 'estado'){
		$update = "UPDATE estado SET $coluna = '$valor' WHERE id_estado = '$id'";
	}else{
		$update = "UPDATE cidade SET $coluna = '$valor' WHERE id_cidade = '$id'";
	}
	
	$update = "UPDATE cadastro SET $coluna = '$valor' WHERE id_cadastro = '$id'";
	
	mysqli_query($conexao, $update) or die(mysqli_error($conexao));
	
	echo "1";
?>