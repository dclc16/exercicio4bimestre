<!DOCTYPE html>

<html lang = "pt-BR">
	<head>
		<title>Cadastrar Estado</title>
		<meta charset = "UTF-8" />
		<script src = "jquery-3.4.1.min.js"></script>
		<script>
			var id = null;
			$(document).ready(function(){
				paginacao(0);
				$("#cad").click(function(){
					$.ajax({
						url: "insere_estado.php",
						type: "post",
						data: {nome:$("#nome_est").val(), uf:$("#uf").val()},
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
							$("#uf").val(vetor.UF);
			
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
								linha = "<tr>";
								linha += "<td class='nome'>" + matriz[i].nome + "</td>";
								linha += "<td class='uf'>" + matriz[i].UF + "</td>";
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
				
				$(document).on("click",".nome",function(){
					td = $(this);
					nome = td.html();
					td.html("<input type='text' id='nome_alterar' name='nome' value='" + nome + "' />");
					td.attr("class","nome_alterar");
				});
				
				$(document).on("blur",".nome_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "alterar_coluna.php",
						type: "post",
						data: {tabela:'estado', coluna:'nome', valor:$("#nome_alterar").val(), id:id_linha},
						success: function(){
							nome = $("#nome_alterar").val;
							td.html(nome);
							td.attr("class","nome");
						},
					});
				});
				
				$(document).on("click",".uf",function(){
					td = $(this);
					uf = td.html();
					td.html("<input type='text' id='uf_alterar' name='uf' value='" + uf + "' />");
					td.attr("class","uf_alterar");
				});
				
				$(document).on("blur",".uf_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "alterar_coluna.php",
						type: "post",
						data: {tabela:'estado', coluna:'UF', valor:$("#uf_alterar").val(), id:id_linha},
						success: function(){
							uf = $("#uf_alterar").val;
							td.html(uf);
							td.attr("class","uf");
						},
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