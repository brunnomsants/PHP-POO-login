<?php

session_start();

require_once('classes/Users.php');
require_once('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$usuario = new User($db);

if(isset($_POST['logar'])){

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $id = $usuario->IDVerify($nome);

    if($usuario->login($nome, $senha)){
        $_SESSION['nome'] = $nome;
        $_SESSION['id'] = $usuario->IDVerify($nome);

        header("Location: dashboard.php");
        exit();;
    }
    else{
        print"<script>alert('Login invalido')</script>";
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tela</title>
</head>
<body>
<div class="form">
<form method="post">
    <input type="hidden" name="id" value="">            
    <label for="nome">Nome de usuário</label>
    <input type="nome" name = "nome" placeholder = "Coloque seu nome">
    <label for="Senha">Senha</label>
    <input type="password" name = "senha" placeholder = "Coloque sua senha">

    <button type="submit" name="logar">Logar</button>
</form>
    <a href="cadastro.php">Clique aqui para criar uma conta</a>
    </div>
</body>
</html>
