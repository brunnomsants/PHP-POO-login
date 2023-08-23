<?php

require_once('classes/Users.php');

require_once('conexao/conexao.php');
$database = new Database();
$db = $database->getConnection();
$usuario = new User($db);

session_start();

if(!isset($_SESSION['nome'])){

    header("Location: index.php");
    exit;

}



$nome = $_SESSION['nome'];
$id = $_SESSION['id'];

if(isset($_GET['action'])){
    switch($_GET['action']){

        case 'update':
            $usuario->update($_POST);
            $usuario->read();
            break;
        }
}


?>
<?php   
                
                

                $result = $usuario->readOne($id); 
                if(!$result){
                    echo "Registro não encontrado.";
                    exit();
                    
                }
                $name = $result['nome'];
                $id = $result['id'];
                $email = $result['email'];
                $senha = $result['senha'];
    
    
        ?>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>

    <div class="form">
    <h1>Olá <?php echo$name; ?></h1>
    <h3>Deseja alteral alguma informaçao?</h3>
       
                <form action="?action=update" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <label for="nome">Nome</label>
                    <input type="text" required name="nome" value="<?php echo $name?>">
                
                    <label for="email">Email</label>
                    <input type="text" required name="email" value="<?php echo $email?>">
                
                    <label for="senha">Nova senha</label>
                    <input type="password" required name="senha">
                    <button type="submit" value="Atualizar" name="enviar" onclick="return confirm('Tem certeza que deseja atualizar esse registro?')">Atualizar</button>
                
                </form>

                
    <a href="logout.php">Sair</a>
    </div>
</body>
</html>
