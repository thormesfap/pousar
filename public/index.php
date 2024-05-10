<?php
require_once dirname(__DIR__) . '/autoloader.php';

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
    include "./Pages/header.php";
    ?>
    <div class="container">
        <h2>Login</h2>
        <form id="login-form" action="./Routes/login.php" method="POST">
            <input type="text" id="email" name="email" placeholder="Username" required>
            <input type="password" id="senha" name="senha" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>