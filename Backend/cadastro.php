<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <form id="cadastro-form" action="cadastrar.php" method="POST">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="senha" name="senha" placeholder="Senha" required>
            <input type="text" id="nome" name="nome" placeholder="Nome Completo" required>
            <input type="text" id="cpf" name="cpf" placeholder="CPF">
            <input type="text" id="telefone" name="telefone" placeholder="+55">
            <input type="text" id="municipio" name="logradouro" placeholder="Rua">
            <input type="text" id="numero" name="numero" placeholder="N.">
            <input type="text" id="municipio" name="municipio" placeholder="Município">
            <select name="uf">
                <option>AC</option>
                <option>AL</option>
                <option>AM</option>
                <option>AP</option>
                <option>CE</option>
                <option>MA</option>
                <option>MS</option>
                <option>MT</option>
                <option>PA</option>
                <option>PB</option>
                <option>PE</option>
                <option>PR</option>
                <option>SE</option>
                <option>RJ</option>
                <option>SP</option>
                <option>RR</option>
                <option>SC</option>
                <option>RS</option>
                <option>RN</option>
                <option>PI</option>
                <option>GO</option>
                <option>TO</option>
                <option>ES</option>
            </select>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>