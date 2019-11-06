<!DOCTYPE html>

<html lang = "pt-BR">
	<head>
		<title></title>
		<meta charset = "UTF-8" />
		<script src = "jquery-3.4.1.min.js"></script>
		<script>
			var id = null;
			var filtro = null;
			$(document).ready(function(){
				paginacao(0);
				
				$("#filtrar").click(function(){
					$.ajax({
						url: "paginacao_cadastro.php",
						type: "post",
						data:{nome_filtro: $("input[name='nome_filtro']").val()},
						success: function(d){
							$("#paginacao").html(d);
							filtro = $("input[name='nome_filtro']").val();
							paginacao(0);
						}
					});
				});
				
				$(document).on("click", ".cadastrar", function(){
					id = $(this).attr("value");
					$.ajax({
						url: "insere_pessoas.php",
						type: "post",
						data: {nome: $("#nome").val(), email: $("#email").val(), sexo: $("input[name='sexo']:checked").val(), salario: $("#salario").val(), cid: $("select[name='cidade']").val()},
						success: function(data){
							if(data==1){
								$("#msn").html("Pessoa cadastrada com sucesso!");
								paginacao(0);
								$("#nome").val("");
								$("#email").val("");
								$("#salario").val("");
								$("input[name='sexo']").prop("checked", false);
							}else{
								$("#msn").html("Não foi possível cadastrar esta pessoa!");
							}
						}
					});
				});
				
				function paginacao(p){
					$.ajax({
						url: "carrega_cadastro.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							$("#tb").html("");
							for(i=0;i<matriz.length;i++){
								linha = "<tr>";
								linha += "<td class = 'nome'>" + matriz[i].nome + "</td>";
								linha += "<td class = 'email'>" + matriz[i].email + "</td>";
								linha += "<td class = 'sexo'>" + matriz[i].sexo + "</td>";
								linha += "<td class = 'salario'>" + matriz[i].salario + "</td>";
								linha += "<td class = 'cidade'>" + matriz[i].cidade + "</td>";
								linha += "<td><button type='button' class = 'alterar' value='" + matriz[i].id_cadastro + "'>Alterar</button> | <button type='button' class='remover' value='" + matriz[i].id_cadastro + "'>Remover</button></td>";
								linha += "</tr>";
								
								$("#tb").append(linha);
							}	
						}
					});
				}
				
				$(document).on("click", ".pg", function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_cadastro_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("#nome").val(vetor.nome);
							$("#email").val(vetor.email);
							$("#salario").val(vetor.salario);
							$("#cidade").val(vetor.cod_cidade);
							if(vetor.sexo == "F"){
								$("input[name = 'sexo'][value='M']").attr("checked", false);
								$("input[name = 'sexo'][value='F']").attr("checked", true);
							}else{
								$("input[name = 'sexo'][value='F']").attr("checked", false);
								$("input[name = 'sexo'][value='M']").attr("checked", true);
							}
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar cadastro");
						}
					});
				});
				
				$(document).on("click",".alteracao",function(){
					$.ajax({
						url: "alteracao_pessoas.php",
						type: "post",
						data: {id: id, nome: $("#nome").val(), email: $("#email").val(), sexo: $("input[name='sexo']:checked").val(), salario: $("#salario").val(), cid: $(".id_cid").val()},
						success: function(data){
							if(data==1){
								$("#msn").html("Cadastro alterado com sucesso!");
								paginacao(0);
								$("#nome").val("");
								$("#email").val("");
								$("#salario").val("");
								$(".alteracao").attr("class", "cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else{
								$("#msn").html("Não foi possível alterar o cadastro desta pessoa!");
							}
						}
					});
				});
				
				$(document).on("click",".nome",function(){
					td = $(this);
					nome = td.html();
					td.html("<input type = 'text' id = 'nome_alterar' name = 'nome' value = '" + nome + "' />");
					td.attr("class", "nome_alterar");
				});
				
				$(document).on("blur",".nome_alterar",function(){
					td = $(this);
					id_linha = $(this).closest("tr").find("button").val();
					$.ajax({
						url: "alterar_coluna.php",
						type: "post",
						data: {coluna: 'nome', valor: $("#nome_alterar").val(), id: id_linha},
						success: function(){
							nome = $("#nome_alterar").val;
							td.html(nome);
							td.attr("class", "nome");
						},
					});
				});
			});
		</script>
	</head>
	
	<body>
		<h3>Cadastro de Pessoas:</h3><br/>
		
		<form>
			Nome: <input type="text" id="nome" required="required" /><br/><br/>
			E-mail: <input type="email" id="email" required="required" /><br/><br/>
			Sexo: 
				<input type="radio" name="sexo" value="F" /> Feminino
				<input type="radio" name="sexo" value="M" /> Masculino<br/><br/>
			
			Salário: <input type="number" id="salario" required="required" min="0" step="0.01" /><br/><br/>
			
			<?php
				include("conexao.php");
				
				$consulta = "SELECT * FROM cidade";
				
				$result = mysqli_query($conexao,$consulta) or die("ERRO!" .mysqli_error($conexao));
				
				echo "<select name='cidade'>";
				
				while($linha = mysqli_fetch_assoc($result)){
					echo '<option value="'.$linha["id_cidade"].'" class="id_cid">'.$linha["nome"].'</option>';
				}
				
				echo "</select><br/><br/>";
			?>
			
			<input type="button" value="Cadastrar..." class="cadastrar" />
		</form><br/><br/>
		
		<div id="msn"></div><br/><br/>
		
		<h3>Filtrar:</h3><br/>
		
		<form name="filtro" >
			<input type="text" name="nome_filtro" placeholder="Filtrar por nome..." />
			<button type="button" id="filtrar">Filtrar</button>
		</form>
		
		<h3>Listagem de Pessoas:</h3><br/>
		
		<table border="1">
			<thead>
				<tr>
					<th>Nome</th>
					<th>E-mail</th>
					<th>Sexo</th>
					<th>Salário</th>
					<th>Cidade</th>
					<th>Ação</th>
				</tr>
			</thead>
			
			<tbody id="tb"></tbody>
		</table><br/><br/>
		
		<div id="paginacao">
			<?php
				include("paginacao_cadastro.php");
			?>	
		</div>
		
		<br/><br/><a href="cadastra_cidade.php">Cadastrar Cidade</a><br/><br/>
		<a href="cadastra_estado.php">Cadastrar Estado</a>
	</body>
</html>