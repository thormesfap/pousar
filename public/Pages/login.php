<?php
require_once '../../autoload.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php
    include "templates/header.php";
    ?>
    <div class="container">
        <h2>Login</h2>
        <form id="login-form" action="/public/Routes/logar.php" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <a href="cadastro.php"><button type="button">Cadastrar-se</button></a>
    </div>
    </div>
</body>

</html>