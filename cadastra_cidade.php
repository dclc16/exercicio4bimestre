<!DOCTYPE html>

<html lang = "pt-BR">
	<head>
		<title>Cadastrar Cidade</title>
		<meta charset = "UTF-8" />
		<script src = "jquery-3.4.1.min.js"></script>
		<script>
			var id = null;
			$(document).ready(function(){
				paginacao(0);
				$("#cad").click(function(){
					$.ajax({
						url: "insere_cidade.php",
						type: "post",
						data: {nome: $("#nome_cidade").val(), cod_estado: $(".id_est").val()},
						success: function(data){
							if(data==1){
								$("#msg").html("Cadastro realizado com sucesso!");
								$("#msg").css("color", "green");
								paginacao(0);
							}else{
								$("#msg").html("Não foi possível cadastrar essa cidade!");
								$("#msg").css("color", "red");
							}
						}
					});
				});
				
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_cidade_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("#nome_cidade").val(vetor.nome);
							$("select[nome='estado']").val(vetor.cod_estado);
							
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar cadastro");
						}
					});
				});
				
				function paginacao(p){
					$.ajax({
						url: "carrega_cidade.php",
						type: "post",
						data: {pg: p},
						success: function(matriz){
							$("#tb").html("");
							for(i=0;i<matriz.length;i++){
								console.log(matriz);
								linha = "<tr>";
								linha += "<td class='nome'>" + matriz[i].nome_cid + "</td>";
								linha += "<td class='estado'>" + matriz[i].nome_est + "</td>";
								linha += "<td><button type='button' class='alterar' value='" + matriz[i].id_cidade + "'>Alterar</button> | <button type='button' class='remover' value='" + matriz[i].id_cidade + "'>Remover</button></td>";
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
						url: "alteracao_cidade.php",
						type: "post",
						data: {id:id, nome:$("#nome_cidade").val()},
						success: function(data){
							if(data==1){
								$("#msg").html("Cidade alterada com sucesso!");
								paginacao(0);
								$("#nome_cidade").val("");
								$(".alteracao").attr("class", "cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else{
								$("#msg").html("Não foi possível alterar o cadastro desta cidade!");
							}
						}
					});
				});
				
				$(document).on("click",".nome",function(){
					td = $(this);
					nome = td.html();
					td.html("<input type='text' id='nome_alterar' name='nome' value = '" + nome + "' />");
					td.attr("class", "nome_alterar");
				});
				
				$(document).on("blur",".nome_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "alterar_coluna.php",
						type: "post",
						data: {coluna:'nome', valor: $("#nome_alterar").val(), id: id_linha},
						success: function(){
							nome = $("#nome_alterar").val;
							td.html(nome);
							td.attr("class", "nome");
						}
					});
				});
			});
		</script>
	</head>
	
	<body>
		<h3>Cadastro de Cidade:</h3><br/>
		
		Nome: <input type="text" id="nome_cidade" required="required" /><br/><br/>
		
		<?php
			include("conexao.php");
			
			$consulta = "SELECT * FROM estado";
			
			$result = mysqli_query($conexao,$consulta) or die("ERRO!" .mysqli_error($conexao));
			
			echo "<select name='estado'>";
			
			while($linha = mysqli_fetch_assoc($result)){
				echo '<option value="'.$linha["id_estado"].'" class="id_est">'.$linha["nome"].'</option>';
			}
			
			echo "</select><br/><br/>";
		?>
		
		<input type="button" id="cad" value="Cadastrar" /><br/><br/>
		
		<div id="msg"></div><br/><br/>
		
		<h3>Listagem de Cidades:</h3><br/>
		
		<table border="1">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Estado</th>
					<th>Ação</th>
				</tr>
			</thead>
			
			<tbody id="tb"></tbody>
		</table><br/><br/>
		
		<?php
			include("paginacao_cidade.php");
		?>
	</body>
</html>