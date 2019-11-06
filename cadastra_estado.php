<!DOCTYPE html>

<html lang = "pt-BR">
	<head>
		<title>Cadastrar Estado</title>
		<meta charset = "UTF-8" />
		<script src = "jquery-3.4.1.min.js"></script>
		<script>
			var id = null;
			$(document).ready(function(){
				$("#cad").click(function(){
					$.ajax({
						url: "insere_estado.php",
						type: "post",
						data: {nome: $("#nome_est").val(), uf: $("#uf").val()},
						success: function(data){
							if(data==1){
								$("#msg").html("Cadastro realizado com sucesso!");
								$("#msg").css("color", "green");
							}else{
								$("#msg").html("Não foi possível cadastrar esse estado!");
								$("#msg").css("color", "red");
							}
						}
					});
				});
				
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_estado_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("#nome_est").val(vetor.nome);
							$("#uf").val(vetor.uf);
			
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar cadastro");
						}
					});
				});
				
				function paginacao(p){
					$.ajax({
						url: "carrega_estado.php",
						type: "post",
						data: {pg: p},
						success: function(matriz){
							$("#tb").html("");
							for(i=0;i<matriz.length;i++){
								console.log(matriz);
								linha = "<tr>";
								linha += "<td class = 'nome'>" + matriz[i].nome + "</td>";
								linha += "<td class = 'uf'>" + matriz[i].UF + "</td>";
								linha += "<td><button type='button' class='alterar' value='" + matriz[i].id_estado + "'>Alterar</button> | <button type='button' class='remover' value='" + matriz[i].id_estado + "'>Remover</button></td>";
								linha += "</tr>";
								
								$("#tb").append(linha);
							}	
						}
					});
				}
				
				$(".pg").click(function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
				$(document).on("click",".alteracao",function(){
					$.ajax({
						url: "alteracao_estado.php",
						type: "post",
						data: {id:id, nome_e:$("#nome_est").val(), uf:$("#uf").val()},
						success: function(data){
							if(data==1){
								$("#msg").html("Estado alterada com sucesso!");
								paginacao(0);
								$("#nome_est").val("");
								$(".alteracao").attr("class", "cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else{
								$("#msg").html("Não foi possível alterar o cadastro deste estado!");
							}
						}
					});
				});
			});
		</script>
	</head>
	
	<body>
		<h3>Cadastro de Estado:</h3><br/>
	
		Nome: <input type="text" id="nome_est" required="required" /><br/><br/>
		
		UF: <input type="text" id="uf" required="required" /><br/><br/>
		
		<input type="button" id="cad" value="Cadastrar" /><br/><br/>
		
		<div id="msg"></div><br/><br/>
		
		<h3>Listagem de Estados:</h3><br/>
		
		<table border="1">
			<thead>
				<tr>
					<th>Nome</th>
					<th>UF</th>
					<th>Ação</th>
				</tr>
			</thead>
			
			<tbody id="tb"></tbody>
		</table><br/><br/>
		
		<?php
			include("paginacao_estado.php");
		?>
	</body>
</html>