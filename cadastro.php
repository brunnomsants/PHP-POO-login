<?php
require_once('classes/Users.php');
require_once('conexao/conexao.php');

    $database = new Database();
    $db = $database->getConnection();
    $usuario = new User($db);

    if(isset($_POST['cadastrar'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confSenha = $_POST['confSenha'];

        if($usuario->register($nome,$email,$senha,$confSenha)){
            echo "<script>alert('Cadastro efetuado com sucesso')</script>";
        }else{
            echo "<script>alert('Erro ao cadastrar')</script>";
            
        }
    }

?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastrar</title>
</head>
<body>
    <div class="form">
    <form method = "POST">
        <label for="">Nome</label>
        <input type="text" name = "nome" placeholder = "Coloque seu nome" REQUIRED>
        <label for="">E-mail</label>
        <input type="" name = "email" placeholder = "Coloque seu email" REQUIRED>
        <label for="">Senha</label>
        <input type="password" name = "senha" placeholder = "Coloque sua senha" REQUIRED>
        <label for="">Confirme sua senha</label>
        <input type="password" name = "confSenha" placeholder = "Coloque sua senha" REQUIRED>

        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>
        <a href="index.php">Clique aqui para logar</a>
        </div>
</body>
</html>