<?php
require 'templates/cabecalho.php'
?>

<head>
    <title>Cadastro de Usuários</title>
</head>
<div class="container">
    <h2>Cadastro</h2>
    <form id="cadastro-form" action="/public/Routes/cadastrarUsuario.php" method="POST">
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" id="senha" name="senha" placeholder="Senha" required>
        <input type="text" id="nome" name="nome" placeholder="Nome Completo" required>
        <input type="text" id="cpf" name="cpf" placeholder="CPF">
        <input type="text" id="telefone" name="telefone" placeholder="+55">
        <input type="text" id="municipio" name="logradouro" placeholder="Rua">
        <input type="text" id="numero" name="numero" placeholder="N.">
        <input type="text" id="municipio" name="municipio" placeholder="Município">
        <select id="estado" name="uf">
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select>
        <button type="submit">Cadastrar</button>
    </form>
</div>
<?php
require 'templates/final.php';
?>